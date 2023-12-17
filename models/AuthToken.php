<?php

namespace app\models;

use app\models\User;
use Yii;

/**
 * This is the model class for table "auth_tokens".
 *
 * @property string $token
 * @property int $user_id
 * @property string $expiry_date
 *
 * @property User $user
 */
class AuthToken extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'auth_tokens';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['token', 'user_id', 'expiry_date'], 'required'],
            [['user_id'], 'integer'],
            [['expiry_date'], 'safe'],
            [['token'], 'string', 'max' => 256],
            [['token'], 'unique'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'user_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'token' => 'Token',
            'user_id' => 'User ID',
            'expiry_date' => 'Expiry Date',
        ];
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['user_id' => 'user_id']);
    }
}
