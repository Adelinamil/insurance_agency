<?php
namespace app\controllers;

use app\models\InsuranceEvent;
use app\models\Policy;
use yii\filters\auth\HttpBearerAuth;
use yii\web\ForbiddenHttpException;
use Yii;

class PolicyController extends FunctionController
{
    public $modelClass = 'app\models\Policy';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::class,
        ];
        return $behaviors;
    }

    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            $userRole = Yii::$app->user->identity->role;
            if (!in_array($userRole, ['admin', 'agent'])) {
                throw new ForbiddenHttpException('У вас нет доступа к данному действию.');
            }
            return true;
        }
        return false;
    }

    public function actionView($id = null, $query = null, $customer_id = null)
    {
        $policy = null;
        if (is_null($id) && is_null($query))
            if(is_null($customer_id))
                return $this->send(200, Policy::find()->all());
            else
                return $this->send(200, Policy::find()->where(['customer_id' => $customer_id])->all());
        else if (!is_null($id))
            $policy = Policy::findOne($id);
        else if (!is_null($query))
            $policy = Policy::find()->where(
                ['OR',
                    ['policy_id' => $query],
                    ['policy_number' => $query]
                ]
            )->one();

        if (is_null($policy))
            return $this->send_error(400, "Полис не найден");
        return $this->send(200, $policy);
    }

    public function actionCreate()
    {
        $policy = new Policy();
        $policy->load(Yii::$app->request->getBodyParams(), '');
        if (!$policy->validate())
            return $this->validation($policy);
        
        $policy->save();
        InsuranceEvent::create('Оформление полиса', $policy->policy_id);
        
        return $this->send(200, $policy);
    }

    public function actionUpdate($id)
    {
        $policy = Policy::findOne($id);
        $policy->load(Yii::$app->request->getBodyParams(), '');
        if (!$policy->validate())
            return $this->validation($policy);

        $policy->save();
        InsuranceEvent::create('Изменение полиса', $policy->policy_id);
        return $this->send(200, $policy);
    }
}