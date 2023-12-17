<?php
namespace app\controllers;

use yii\rest\ActiveController;
use yii\filters\auth\HttpBearerAuth;
use yii\web\ForbiddenHttpException;
use Yii;

class CustomerController extends ActiveController
{
    public $modelClass = 'app\models\Customer';

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

}