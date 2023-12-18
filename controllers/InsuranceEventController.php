<?php
namespace app\controllers;

use app\models\InsuranceEvent;
use yii\filters\auth\HttpBearerAuth;
use yii\web\ForbiddenHttpException;
use Yii;

class InsuranceEventController extends FunctionController
{
    public $modelClass = 'app\models\InsuranceEvent';

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

    public function actionView($id = null, $policy_id = null, $limit = null, $offset = null, $sort_date = 'ASC', $start_date = null, $end_date = null)
    {
        if (!is_null($id)) {
            $event = InsuranceEvent::findOne($id);
            if (is_null($event))
                return $this->send_error(400, "Событие не найдено");
        }
        if (is_null($policy_id))
            return $this->send_error(400, 'Поле `policy_id` не может быть пустым');

        $limit = is_null($limit) ? 100: $limit;
        $offset = is_null($offset) ? 0: $offset;
        if($limit < 1 || $limit > 1000)
            return $this->send_error(400, 'Поле `limit` должно быть между 1 и 1000');
        

        $sort_value = SORT_ASC;
        if ($sort_date === 'DESC')
            $sort_value = SORT_DESC;

        $start_date = $start_date ?? date('Y-m-d', strtotime('-30 days'));
        $end_date = $end_date ?? date('Y-m-d');

        return $this->send(
            200,
            InsuranceEvent::find()->where(
                [
                    'AND',
                    ['between', 'event_date', $start_date, $end_date],
                    ['policy_id' => $policy_id]
                ]
            )->orderBy(['event_date' => $sort_value])->limit($limit)->offset($offset)->all()
        );
    }
}