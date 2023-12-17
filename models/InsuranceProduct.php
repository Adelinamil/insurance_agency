<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "insurance_products".
 *
 * @property int $product_id
 * @property string $name
 * @property string|null $description
 * @property string $type
 * @property float $coverage
 * @property float $default_sum_insured
 * @property float $default_premium
 */
class InsuranceProduct extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'insurance_products';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'type', 'coverage', 'default_sum_insured', 'default_premium'], 'required'],
            [['description'], 'string'],
            [['coverage', 'default_sum_insured', 'default_premium'], 'number'],
            [['name'], 'string', 'max' => 100],
            [['type'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'product_id' => 'Product ID',
            'name' => 'Name',
            'description' => 'Description',
            'type' => 'Type',
            'coverage' => 'Coverage',
            'default_sum_insured' => 'Default Sum Insured',
            'default_premium' => 'Default Premium',
        ];
    }
}
