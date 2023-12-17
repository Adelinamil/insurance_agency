<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "policies".
 *
 * @property int $policy_id
 * @property string $policy_number
 * @property string $start_date
 * @property string $end_date
 * @property string $insurance_type
 * @property float $coverage
 * @property float $premium
 * @property int $customer_id
 *
 * @property Customer $customer
 * @property InsuranceEvent[] $insuranceEvents
 */
class Policy extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'policies';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['policy_number', 'start_date', 'end_date', 'insurance_type', 'coverage', 'premium', 'customer_id'], 'required'],
            [['start_date', 'end_date'], 'safe'],
            [['coverage', 'premium'], 'number'],
            [['customer_id'], 'integer'],
            [['policy_number'], 'string', 'max' => 20],
            [['insurance_type'], 'string', 'max' => 50],
            [['policy_number'], 'unique'],
            [['customer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Customer::class, 'targetAttribute' => ['customer_id' => 'customer_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'policy_id' => 'Policy ID',
            'policy_number' => 'Policy Number',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'insurance_type' => 'Insurance Type',
            'coverage' => 'Coverage',
            'premium' => 'Premium',
            'customer_id' => 'Customer ID',
        ];
    }

    /**
     * Gets query for [[Customer]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCustomer()
    {
        return $this->hasOne(Customer::class, ['customer_id' => 'customer_id']);
    }

    /**
     * Gets query for [[InsuranceEvents]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getInsuranceEvents()
    {
        return $this->hasMany(InsuranceEvent::class, ['policy_id' => 'policy_id']);
    }
}
