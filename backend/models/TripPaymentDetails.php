<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "trip_payment_details".
 *
 * @property int $id
 * @property string $amount
 * @property string $amount_payable
 * @property string $account_no
 * @property string $cheque_no
 * @property int $cheque_bank_id refd to banks.id
 * @property int $trip_transaction_id refd to trip_transactions.id
 * @property int $header_id refd to trip_payment_headers.id
 * @property string $cheque_date
 * @property string $created_at
 * @property string $updated_at
 * @property int $payment_type 1=Cash 2=Cheque 3=Post Dated Cheque(PDC)
 * @property int $is_deleted
 *
 * @property Banks $chequeBank
 * @property TripTransactions $tripTransaction
 * @property TripPaymentHeaders $header
 */
class TripPaymentDetails extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'trip_payment_details';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['amount', 'amount_payable'], 'number'],
            [['account_no', 'cheque_no', 'cheque_bank_id', 'trip_transaction_id', 'header_id', 'cheque_date', 'created_at'], 'required'],
            [['cheque_bank_id', 'trip_transaction_id', 'header_id', 'payment_type', 'is_deleted'], 'integer'],
            [['cheque_date', 'created_at', 'updated_at'], 'safe'],
            [['account_no', 'cheque_no'], 'string', 'max' => 50],
            [['cheque_bank_id'], 'exist', 'skipOnError' => true, 'targetClass' => Banks::className(), 'targetAttribute' => ['cheque_bank_id' => 'id']],
            [['trip_transaction_id'], 'exist', 'skipOnError' => true, 'targetClass' => TripTransactions::className(), 'targetAttribute' => ['trip_transaction_id' => 'id']],
            [['header_id'], 'exist', 'skipOnError' => true, 'targetClass' => TripPaymentHeaders::className(), 'targetAttribute' => ['header_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'amount' => 'Amount',
            'amount_payable' => 'Amount Payable',
            'account_no' => 'Account No',
            'cheque_no' => 'Cheque No',
            'cheque_bank_id' => 'Cheque Bank ID',
            'trip_transaction_id' => 'Trip Transaction ID',
            'header_id' => 'Header ID',
            'cheque_date' => 'Cheque Date',
            'created_at' => 'Date Created',
            'updated_at' => 'Last Modified',
            'payment_type' => 'Payment Type',
            'is_deleted' => 'Deleted?',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChequeBank()
    {
        return $this->hasOne(Banks::className(), ['id' => 'cheque_bank_id']);
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
    public function getHeader()
    {
        return $this->hasOne(TripPaymentHeaders::className(), ['id' => 'header_id']);
    }
}
