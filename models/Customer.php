<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "customers".
 *
 * @property int $customer_id
 * @property string $first_name
 * @property string $last_name
 * @property string $birth_date
 * @property string|null $address
 * @property string|null $phone
 * @property string $email
 *
 * @property Policy[] $policies
 */
class Customer extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'customers';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['first_name', 'last_name', 'birth_date', 'email'], 'required'],
            [['birth_date'], 'safe'],
            [['first_name', 'last_name'], 'string', 'max' => 50],
            [['address'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 20],
            [['email'], 'string', 'max' => 100],
            [['email'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'customer_id' => 'Customer ID',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'birth_date' => 'Birth Date',
            'address' => 'Address',
            'phone' => 'Phone',
            'email' => 'Email',
        ];
    }

    /**
     * Gets query for [[Policies]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPolicies()
    {
        return $this->hasMany(Policy::class, ['customer_id' => 'customer_id']);
    }
}
