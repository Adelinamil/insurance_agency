<?php
namespace app\controllers;

use app\models\AuthToken;
use app\models\User;
use app\models\LoginForm;
use yii\filters\auth\HttpBearerAuth;
use yii\web\ForbiddenHttpException;
use Yii;

class UserController extends FunctionController
{
    public $modelClass = 'app\models\User';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::class,
            'except' => ['login'],
        ];
        return $behaviors;
    }

    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            if ($action->id === 'login')
                return true;

            $userRole = Yii::$app->user->identity->role;
            if ($userRole !== 'admin') {
                throw new ForbiddenHttpException('У вас нет доступа к данному действию.');
            }
            return true;
        }
        return false;
    }

    public function actionView()
    {
        $id = Yii::$app->request->get('id');
        $query = Yii::$app->request->get('query');
        $user = null;
        if (is_null($id) && is_null($query))
            return $this->send(200, User::find()->all());
        else if (!is_null($id))
            $user = User::findOne($id);
        else if (!is_null($query))
            $user = User::find()->where(
                ['OR',
                    ['user_id' => $query],
                    ['email' => $query],
                    ['username' => $query],
                ]
            )->one();

        if (is_null($user))
            return $this->send_error(400, "Пользователь не найден");
        return $this->send(200, $user);
    }

    public function actionCreate()
    {
        $data = Yii::$app->request->post();
        $user = new User();
        $user->load($data, '');
        if (!$user->validate())
            return $this->validation($user);
        $user->password = Yii::$app->getSecurity()->generatePasswordHash($user->password);
        $user->save();
        return $this->send(204, null);
    }

    public function actionUpdate()
    {
        $user = User::findOne(Yii::$app->request->post('id'));

        if (!$user)
            return $this->send_error(400, "Пользователь не найден");

        $username = Yii::$app->request->post('username');
        if ($username)
            $user->username = $username;

        $first_name = Yii::$app->request->post('first_name');
        if ($first_name)
            $user->first_name = $first_name;

        $last_name = Yii::$app->request->post('last_name');
        if ($last_name)
            $user->last_name = $last_name;

        $role = Yii::$app->request->post('role');
        if ($role)
            $user->role = $role;


        if (!$user->validate())
            return $this->validation($user);

        $user->save();
        return $this->send(200, $user);
    }
    public function actionDelete($id)
    {
        $user = User::findOne($id);
        if (is_null($user))
            return $this->send_error(400, "Пользователь не найден");

        $user->delete();
        return $this->send(200, true);
    }

    public function actionLogin()
    {
        $data = Yii::$app->request->post();
        $login_data = new LoginForm();
        $login_data->load($data, '');
        if (!$login_data->validate())
            return $this->validation($login_data);

        $user = $login_data->getUser();

        $token = Yii::$app->getSecurity()->generateRandomString(128);
        $auth_token = new AuthToken();
        $auth_token->token = $token;
        $auth_token->user_id = $user->user_id;
        $auth_token->expiry_date = (new \DateTime())->add(new \DateInterval('P30D'))->format('Y-m-d');
        $auth_token->save(false);
        return $this->send(200, ['data' => ['token' => $token]]);
    }
}
?>