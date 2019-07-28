<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "trip_billing_details".
 *
 * @property int $id
 * @property string $gross_amount
 * @property string $other_amount
 * @property string $net_amount
 * @property string $other_remarks
 * @property int $header_id refd to trip_billing_headers.id
 * @property int $trip_transaction_id refd to trip_transactions.id
 * @property int $user_id refd to users.id
 * @property string $created_at
 * @property string $updated_at
 * @property int $is_deleted
 *
 * @property TripBillingHeaders $header
 * @property TripTransactions $tripTransaction
 * @property User $user
 */
class TripBillingDetails extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'trip_billing_details';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['gross_amount', 'other_amount', 'net_amount'], 'number'],
            [['header_id', 'trip_transaction_id', 'user_id', 'created_at'], 'required'],
            [['other_remarks'], 'string'],
            [['header_id', 'trip_transaction_id', 'user_id', 'is_deleted'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['header_id'], 'exist', 'skipOnError' => true, 'targetClass' => TripBillingHeaders::className(), 'targetAttribute' => ['header_id' => 'id']],
            [['trip_transaction_id'], 'exist', 'skipOnError' => true, 'targetClass' => TripTransactions::className(), 'targetAttribute' => ['trip_transaction_id' => 'id']],
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
            'gross_amount' => 'Gross Amount',
            'other_amount' => 'Other Amount',
            'net_amount' => 'Net Amount',
            'other_remarks' => 'Other Remarks',
            'header_id' => 'Header',
            'trip_transaction_id' => 'Trip Transaction',
            'user_id' => 'User',
            'created_at' => 'Date Created',
            'updated_at' => 'Last Modified',
            'is_deleted' => 'Deleted?',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHeader()
    {
        return $this->hasOne(TripBillingHeaders::className(), ['id' => 'header_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTripTransaction()
    {
        return $this->hasOne(TripTransactions::className(), ['id' => 'trip_transaction_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
