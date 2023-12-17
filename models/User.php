<?php

namespace app\models;
use Yii;

/**
 * This is the model class for table "users".
 *
 * @property int $user_id
 * @property string $username
 * @property string $password
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $role
 */
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'password', 'first_name', 'last_name', 'email', 'role'], 'required'],
            [['username', 'first_name', 'last_name'], 'string', 'max' => 50],
            [['password', 'email'], 'string', 'max' => 100],
            [['password'], 'string', 'min' => 5],
            [['role'], 'string', 'max' => 20],
            ['role', 'in', 'range' => ['admin', 'agent', 'support']],
            ['username', 'match', 'pattern' => '/^[a-zA-Z0-9_\-]+$/', 'message' => 'Допустимы только буквы, цифры, подчеркивания и дефисы.'],
            [['username'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'username' => 'Username',
            'password' => 'Password',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'email' => 'Email',
            'role' => 'Role',
        ];
    }

    public function fields()
    {
        return [
            'id' => 'user_id',
            'username',
            'email',
            'first_name',
            'last_name',
            'role'
        ];
    }

    public function validatePassword($password): bool
    {
        return Yii::$app->getSecurity()->validatePassword($password, $this->password);
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }
    public static function findIdentityByAccessToken($token, $type = null)
    {
        $auth_token = AuthToken::findOne(['token' => $token]);
        if (!is_null($auth_token)) {
            $now = new \DateTime();
            $expiry_date = new \DateTime($auth_token->expiry_date);
            if ($now > $expiry_date) {
                $auth_token->delete();
                return false;
            }

            return static::findOne(['user_id' => $auth_token->user_id]);
        }
        return false;
    }
    public function getId()
    {
        return $this->user_id;
    }
    public function getAuthKey()
    {
    }
    public function validateAuthKey($authKey)
    {
    }
}
