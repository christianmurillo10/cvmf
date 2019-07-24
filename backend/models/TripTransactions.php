<?php

namespace backend\models;

use Yii;
use common\models\utilities\Utilities;

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
 * @property TripBillingDetails[] $tripBillingDetails
 * @property TripCreditBalance[] $tripCreditBalances
 * @property TripPaymentDetails[] $tripPaymentDetails
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
            'trip_id' => 'Trip',
            'trip_demurrage_id' => 'Trip Demurrage',
            'trip_foul_trip_id' => 'Trip Foul Trip',
            'client_id' => 'Client',
            'user_id' => 'User',
            'date' => 'Date',
            'created_at' => 'Date Created',
            'updated_at' => 'Last Modified',
            'trip_status' => 'Trip Status',
            'is_billed' => 'Billed?',
            'is_fully_paid' => 'Fully Paid?',
            'is_deleted' => 'Is Deleted',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTripBillingDetails()
    {
        return $this->hasMany(TripBillingDetails::className(), ['trip_transaction_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTripCreditBalances()
    {
        return $this->hasMany(TripCreditBalance::className(), ['trip_transaction_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTripPaymentDetails()
    {
        return $this->hasMany(TripPaymentDetails::className(), ['trip_transaction_id' => 'id']);
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

    public static function get_ActiveTripStatus($id = null)
    {
        $active = [
            self::TRIP_STATUS_DONE => 'Done',
            self::TRIP_STATUS_DEMURRAGE => 'Demurrage',
            self::TRIP_STATUS_FOUL_TRIP => 'Foul Trip',
        ];
        if (is_null($id))
            return $active;
        else
            return $active[$id];
    }

    public function getTripStatus()
    {
        return self::get_ActiveTripStatus($this->trip_status);
    }

    public function getColoredTripStatus() 
    {
        $status_id = $this->trip_status;
        $status = self::get_ActiveTripStatus($this->trip_status);

        if ($status_id == self::TRIP_STATUS_DONE) {
            return '<span class="label label-success">'.$status.'</span>';
        } else if ($status_id == self::TRIP_STATUS_DEMURRAGE) {
            return '<span class="label label-warning">'.$status.'</span>';
        } else if ($status_id == self::TRIP_STATUS_FOUL_TRIP) {
            return '<span class="label label-danger">'.$status.'</span>';
        }
    }

    public function getIsBilled()
    {
        return Utilities::get_ActiveSelect($this->is_billed);
    }

    public function getIsFullyPaid()
    {
        return Utilities::get_ActiveSelect($this->is_fully_paid);
    }

    public function getFormattedAmount() 
    {
        return Utilities::setNumberFormatWithPeso($this->amount, 2);
    }
}
