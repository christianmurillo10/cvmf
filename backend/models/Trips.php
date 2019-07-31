<?php

namespace backend\models;

use Yii;
use common\models\utilities\Utilities;

/**
 * This is the model class for table "trips".
 *
 * @property int $id
 * @property string $trip_no
 * @property int $quantity
 * @property string $rate_amount
 * @property string $amount
 * @property string $remarks
 * @property int $user_id refd to user.id
 * @property int $client_id refd to clients.id
 * @property int $client_direct_company_id refd to client_direct_companies.id
 * @property int $vehicle_id refd to vehicles.id
 * @property int $destination_from_id refd to destinations.id
 * @property int $destination_to_id refd to destinations.id
 * @property int $trip_load_type_id refd to trip_load_types.id
 * @property int $status 1=New 2=Done 3=Cancelled 4=Failed 5=Demurrage 6=Foul Trip
 * @property string $date_issued
 * @property string $date_delivered
 * @property string $created_at
 * @property string $updated_at
 * @property int $is_deleted
 *
 * @property TripDemurrages[] $tripDemurrages
 * @property TripExpenses[] $tripExpenses
 * @property TripFoulTrips[] $tripFoulTrips
 * @property TripPartitions[] $tripPartitions
 * @property TripPersonnels[] $tripPersonnels
 * @property TripTransactions[] $tripTransactions
 * @property User $user
 * @property Clients $client
 * @property Vehicles $vehicle
 * @property Destinations $destinationFrom
 * @property Destinations $destinationTo
 * @property ClientDirectCompanies $clientDirectCompany
 * @property TripLoadTypes $tripLoadType
 */
class Trips extends \yii\db\ActiveRecord
{
    const TRIP_STATUS_NEW = 1;
    const TRIP_STATUS_DONE = 2;
    const TRIP_STATUS_CANCELLED = 3;
    const TRIP_STATUS_FAILED = 4;
    const TRIP_STATUS_DEMURRAGE = 5;
    const TRIP_STATUS_FOUL_TRIP = 6;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'trips';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['trip_no', 'quantity', 'rate_amount', 'amount', 'user_id', 'client_id', 'vehicle_id', 'destination_from_id', 'destination_to_id', 'trip_load_type_id', 'date_issued', 'created_at'], 'required'],
            [['rate_amount', 'amount'], 'number'],
            [['remarks'], 'string'],
            [['quantity', 'user_id', 'client_id', 'client_direct_company_id', 'vehicle_id', 'destination_from_id', 'destination_to_id', 'trip_load_type_id', 'status', 'is_deleted'], 'integer'],
            [['date_issued', 'date_delivered', 'created_at', 'updated_at'], 'safe'],
            [['trip_no'], 'string', 'max' => 50],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['client_id'], 'exist', 'skipOnError' => true, 'targetClass' => Clients::className(), 'targetAttribute' => ['client_id' => 'id']],
            [['vehicle_id'], 'exist', 'skipOnError' => true, 'targetClass' => Vehicles::className(), 'targetAttribute' => ['vehicle_id' => 'id']],
            [['destination_from_id'], 'exist', 'skipOnError' => true, 'targetClass' => Destinations::className(), 'targetAttribute' => ['destination_from_id' => 'id']],
            [['destination_to_id'], 'exist', 'skipOnError' => true, 'targetClass' => Destinations::className(), 'targetAttribute' => ['destination_to_id' => 'id']],
            [['client_direct_company_id'], 'exist', 'skipOnError' => true, 'targetClass' => ClientDirectCompanies::className(), 'targetAttribute' => ['client_direct_company_id' => 'id']],
            [['trip_load_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => TripLoadTypes::className(), 'targetAttribute' => ['trip_load_type_id' => 'id']],
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
            'quantity' => 'Quantity',
            'rate_amount' => 'Rate Amount',
            'amount' => 'Amount',
            'remarks' => 'Remarks',
            'user_id' => 'User',
            'client_id' => 'Client',
            'client_direct_company_id' => 'Client Direct Company',
            'vehicle_id' => 'Vehicle',
            'destination_from_id' => 'Destination From',
            'destination_to_id' => 'Destination To',
            'trip_load_type_id' => 'Load Type',
            'status' => 'Status',
            'date_issued' => 'Date Issued',
            'date_delivered' => 'Date Delivered',
            'created_at' => 'Date Created',
            'updated_at' => 'Date Modified',
            'is_deleted' => 'Deleted?',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTripDemurrages()
    {
        return $this->hasMany(TripDemurrages::className(), ['trip_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTripExpenses()
    {
        return $this->hasMany(TripExpenses::className(), ['trip_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTripFoulTrips()
    {
        return $this->hasMany(TripFoulTrips::className(), ['trip_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTripPartitions()
    {
        return $this->hasMany(TripPartitions::className(), ['trip_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTripPersonnels()
    {
        return $this->hasMany(TripPersonnels::className(), ['trip_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTripTransactions()
    {
        return $this->hasMany(TripTransactions::className(), ['trip_id' => 'id']);
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
    public function getClient()
    {
        return $this->hasOne(Clients::className(), ['id' => 'client_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVehicle()
    {
        return $this->hasOne(Vehicles::className(), ['id' => 'vehicle_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDestinationFrom()
    {
        return $this->hasOne(Destinations::className(), ['id' => 'destination_from_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDestinationTo()
    {
        return $this->hasOne(Destinations::className(), ['id' => 'destination_to_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClientDirectCompany()
    {
        return $this->hasOne(ClientDirectCompanies::className(), ['id' => 'client_direct_company_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTripLoadType()
    {
        return $this->hasOne(TripLoadTypes::className(), ['id' => 'trip_load_type_id']);
    }

    public static function get_ActiveStatus($id = null)
    {
        $active = [
            self::TRIP_STATUS_NEW => 'New',
            self::TRIP_STATUS_DONE => 'Done',
            self::TRIP_STATUS_CANCELLED => 'Cancelled',
            self::TRIP_STATUS_FAILED => 'Failed',
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
        return self::get_ActiveStatus($this->status);
    }

    public function getFormattedAmount() 
    {
        return Utilities::setNumberFormatWithPeso($this->amount, 2);
    }

    public function getColoredStatus() 
    {
        $status_id = $this->status;
        $status = self::get_ActiveStatus($this->status);

        if ($status_id == self::TRIP_STATUS_NEW) {
            return '<span class="label label-info">'.$status.'</span>';
        } else if ($status_id == self::TRIP_STATUS_DONE) {
            return '<span class="label label-success">'.$status.'</span>';
        } else if ($status_id == self::TRIP_STATUS_CANCELLED) {
            return '<span class="label label-warning">'.$status.'</span>';
        } else if ($status_id == self::TRIP_STATUS_FAILED) {
            return '<span class="label label-danger">'.$status.'</span>';
        } else if ($status_id == self::TRIP_STATUS_DEMURRAGE) {
            return '<span class="label label-default">'.$status.'</span>';
        } else if ($status_id == self::TRIP_STATUS_FOUL_TRIP) {
            return '<span class="label label-primary">'.$status.'</span>';
        }
    }
}
