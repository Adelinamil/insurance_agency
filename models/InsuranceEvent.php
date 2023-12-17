<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "insurance_events".
 *
 * @property int $event_id
 * @property string $event_date
 * @property string|null $description
 * @property int $policy_id
 *
 * @property Policy $policy
 */
class InsuranceEvent extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'insurance_events';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['event_date', 'policy_id'], 'required'],
            [['event_date'], 'safe'],
            [['description'], 'string'],
            [['policy_id'], 'integer'],
            [['policy_id'], 'exist', 'skipOnError' => true, 'targetClass' => Policy::class, 'targetAttribute' => ['policy_id' => 'policy_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'event_id' => 'Event ID',
            'event_date' => 'Event Date',
            'description' => 'Description',
            'policy_id' => 'Policy ID',
        ];
    }

    /**
     * Gets query for [[Policy]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPolicy()
    {
        return $this->hasOne(Policy::class, ['policy_id' => 'policy_id']);
    }

    public static function create($description, $policy_id): InsuranceEvent {
        $event = new InsuranceEvent();
        $event->event_date = (new \DateTime())->add(new \DateInterval('P30D'))->format('Y-m-d');
        $event->description = $description;
        $event->policy_id = $policy_id;
        $event->save();
        return $event;
    }
}
