<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "trip_partitions".
 *
 * @property int $id
 * @property string $gross_amount
 * @property string $vat_amount
 * @property string $maintenance_amount
 * @property string $total_expense_amount
 * @property string $net_amount
 * @property string $total_personnel_profit_amount
 * @property string $net_profit_amount
 * @property int $user_id refd to user.id
 * @property int $trip_id refd to trips.id
 * @property int $tax_percentage_id refd to tax_percentage_lists.id
 * @property string $created_at
 * @property string $updated_at
 * @property int $is_deleted
 * @property int $personnel_commission_type 1=Percentage 2=Per Trip
 *
 * @property User $user
 * @property Trips $trip
 * @property TaxPercentageLists $taxPercentage
 */
class TripPartitions extends \yii\db\ActiveRecord
{
    const PERSONNEL_COMMISSION_TYPE_PERCENTAGE = 1;
    const PERSONNEL_COMMISSION_TYPE_PER_TRIP = 2;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'trip_partitions';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // [['gross_amount', 'vat_amount', 'total_expense_amount', 'net_amount', 'total_personnel_profit_amount', 'net_profit_amount'], 'number'],
            [['user_id', 'trip_id', 'tax_percentage_id', 'created_at'], 'required'],
            [['user_id', 'trip_id', 'tax_percentage_id', 'is_deleted', 'personnel_commission_type'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['trip_id'], 'exist', 'skipOnError' => true, 'targetClass' => Trips::className(), 'targetAttribute' => ['trip_id' => 'id']],
            [['tax_percentage_id'], 'exist', 'skipOnError' => true, 'targetClass' => TaxPercentageLists::className(), 'targetAttribute' => ['tax_percentage_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'gross_amount' => 'Gross Amount',
            'vat_amount' => 'Vat Amount',
            'maintenance_amount' => 'Maintenance Amount',
            'total_expense_amount' => 'Total Expense Amount',
            'net_amount' => 'Net Amount',
            'total_personnel_profit_amount' => 'Total Personnel Profit Amount',
            'net_profit_amount' => 'Net Profit Amount',
            'user_id' => 'User',
            'trip_id' => 'Trip',
            'tax_percentage_id' => 'Tax Percentage',
            'created_at' => 'Date Created',
            'updated_at' => 'Date Modified',
            'is_deleted' => 'Is Deleted',
            'personnel_commission_type' => 'Commission Type',
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
    public function getTaxPercentage()
    {
        return $this->hasOne(TaxPercentageLists::className(), ['id' => 'tax_percentage_id']);
    }
}
