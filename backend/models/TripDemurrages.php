<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "trip_demurrages".
 *
 * @property int $id
 * @property double $percentage
 * @property double $days
 * @property string $trip_amount
 * @property string $gross_amount
 * @property string $remarks
 * @property int $user_id refd to user.id
 * @property int $trip_id refd to trips.id
 * @property int $header_id refd to trips.id (New generated trip)
 * @property string $date_from
 * @property string $date_to
 * @property string $created_at
 * @property string $updated_at
 * @property int $is_deleted
 *
 * @property User $user
 * @property Trips $trip
 * @property Trips $header
 */
class TripDemurrages extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'trip_demurrages';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'trip_id', 'header_id', 'created_at'], 'required'],
            // [['percentage', 'days', 'trip_amount', 'gross_amount'], 'number'],
            [['remarks'], 'string'],
            [['user_id', 'trip_id', 'header_id', 'is_deleted'], 'integer'],
            [['date_from', 'date_to', 'created_at', 'updated_at'], 'safe'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['trip_id'], 'exist', 'skipOnError' => true, 'targetClass' => Trips::className(), 'targetAttribute' => ['trip_id' => 'id']],
            [['header_id'], 'exist', 'skipOnError' => true, 'targetClass' => Trips::className(), 'targetAttribute' => ['header_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'percentage' => 'Percentage',
            'days' => 'Days',
            'trip_amount' => 'Trip Amount',
            'gross_amount' => 'Gross Amount',
            'remarks' => 'Remarks',
            'user_id' => 'User',
            'trip_id' => 'Trip',
            'header_id' => 'Header',
            'date_from' => 'Date From',
            'date_to' => 'Date To',
            'created_at' => 'Date Created',
            'updated_at' => 'Date Modified',
            'is_deleted' => 'Is Deleted',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTrip()
    {
        return $this->hasOne(Trips::className(), ['id' => 'trip_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHeader()
    {
        return $this->hasOne(Trips::className(), ['id' => 'header_id']);
    }
}
