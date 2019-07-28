<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "trip_foul_trips".
 *
 * @property int $id
 * @property string $trip_no
 * @property double $percentage
 * @property string $trip_amount
 * @property string $gross_amount
 * @property string $remarks
 * @property int $user_id refd to user.id
 * @property int $trip_id refd to trips.id
 * @property string $date
 * @property string $created_at
 * @property string $updated_at
 * @property int $is_deleted
 *
 * @property User $user
 * @property Trips $trip
 * @property TripTransactions[] $tripTransactions
 */
class TripFoulTrips extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'trip_foul_trips';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'trip_id', 'created_at'], 'required'],
            // [['percentage', 'trip_amount', 'gross_amount'], 'number'],
            [['remarks'], 'string'],
            [['user_id', 'trip_id', 'is_deleted'], 'integer'],
            [['date', 'created_at', 'updated_at'], 'safe'],
            [['trip_no'], 'string', 'max' => 50],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['trip_id'], 'exist', 'skipOnError' => true, 'targetClass' => Trips::className(), 'targetAttribute' => ['trip_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'trip_no' => 'Trip No',
            'percentage' => 'Percentage',
            'trip_amount' => 'Trip Amount',
            'gross_amount' => 'Gross Amount',
            'remarks' => 'Remarks',
            'user_id' => 'User',
            'trip_id' => 'Trip',
            'date' => 'Date',
            'created_at' => 'Date Created',
            'updated_at' => 'Date Modified',
            'is_deleted' => 'Deleted?',
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
    public function getTripTransactions()
    {
        return $this->hasMany(TripTransactions::className(), ['trip_foul_trip_id' => 'id']);
    }
}
