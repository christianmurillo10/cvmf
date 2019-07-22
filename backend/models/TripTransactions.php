<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "trip_transactions".
 *
 * @property int $id
 * @property string $ref_no
 * @property string $trip_no
 * @property string $amount
 * @property int $trip_id refd to trips.id
 * @property int $trip_demurrage_id refd to trip_demurrages.id
 * @property int $trip_foul_trip_id refd to trip_foul_trips.id
 * @property int $client_id refd to clients.id
 * @property int $user_id refd to user.id
 * @property string $date
 * @property string $created_at
 * @property string $updated_at
 * @property int $trip_status 1=Done, 2=Demurrage, 3=Foul Trip
 * @property int $is_billed
 * @property int $is_fully_paid
 * @property int $is_deleted
 *
 * @property Trips $trip
 * @property TripDemurrages $tripDemurrage
 * @property TripFoulTrips $tripFoulTrip
 * @property Clients $client
 * @property User $user
 */
class TripTransactions extends \yii\db\ActiveRecord
{
    const TRIP_STATUS_DONE = 1;
    const TRIP_STATUS_DEMURRAGE = 2;
    const TRIP_STATUS_FOUL_TRIP = 3;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'trip_transactions';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ref_no', 'trip_no', 'client_id', 'user_id', 'date', 'created_at'], 'required'],
            [['amount'], 'number'],
            [['trip_id', 'trip_demurrage_id', 'trip_foul_trip_id', 'client_id', 'user_id', 'trip_status', 'is_billed', 'is_fully_paid', 'is_deleted'], 'integer'],
            [['date', 'created_at', 'updated_at'], 'safe'],
            [['ref_no', 'trip_no'], 'string', 'max' => 50],
            [['trip_id'], 'exist', 'skipOnError' => true, 'targetClass' => Trips::className(), 'targetAttribute' => ['trip_id' => 'id']],
            [['trip_demurrage_id'], 'exist', 'skipOnError' => true, 'targetClass' => TripDemurrages::className(), 'targetAttribute' => ['trip_demurrage_id' => 'id']],
            [['trip_foul_trip_id'], 'exist', 'skipOnError' => true, 'targetClass' => TripFoulTrips::className(), 'targetAttribute' => ['trip_foul_trip_id' => 'id']],
            [['client_id'], 'exist', 'skipOnError' => true, 'targetClass' => Clients::className(), 'targetAttribute' => ['client_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ref_no' => 'Ref No',
            'trip_no' => 'Trip No',
            'amount' => 'Amount',
            'trip_id' => 'Trip ID',
            'trip_demurrage_id' => 'Trip Demurrage ID',
            'trip_foul_trip_id' => 'Trip Foul Trip ID',
            'client_id' => 'Client ID',
            'user_id' => 'User ID',
            'date' => 'Date',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'trip_status' => 'Trip Status',
            'is_billed' => 'Is Billed',
            'is_fully_paid' => 'Is Fully Paid',
            'is_deleted' => 'Is Deleted',
        ];
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
    public function getTripDemurrage()
    {
        return $this->hasOne(TripDemurrages::className(), ['id' => 'trip_demurrage_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTripFoulTrip()
    {
        return $this->hasOne(TripFoulTrips::className(), ['id' => 'trip_foul_trip_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClient()
    {
        return $this->hasOne(Clients::className(), ['id' => 'client_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
