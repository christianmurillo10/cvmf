<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "trip_credit_balance".
 *
 * @property int $id
 * @property string $credit
 * @property string $debit
 * @property string $balance
 * @property string $remarks
 * @property int $client_id refd to clients.id
 * @property int $trip_transaction_id refd to trip_transactions.id
 * @property int $user_id refd to users.id
 * @property string $created_at
 * @property string $updated_at
 * @property int $transaction_type 1=Credit 2=Debit 3=Delete
 * @property int $is_deleted
 *
 * @property Clients $client
 * @property TripTransactions $tripTransaction
 * @property User $user
 */
class TripCreditBalance extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'trip_credit_balance';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['credit', 'debit', 'balance'], 'number'],
            [['remarks'], 'string'],
            [['client_id', 'trip_transaction_id', 'user_id', 'created_at'], 'required'],
            [['client_id', 'trip_transaction_id', 'user_id', 'transaction_type', 'is_deleted'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['client_id'], 'exist', 'skipOnError' => true, 'targetClass' => Clients::className(), 'targetAttribute' => ['client_id' => 'id']],
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
            'credit' => 'Credit',
            'debit' => 'Debit',
            'balance' => 'Balance',
            'remarks' => 'Remarks',
            'client_id' => 'Client ID',
            'trip_transaction_id' => 'Trip Transaction ID',
            'user_id' => 'User ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'transaction_type' => 'Transaction Type',
            'is_deleted' => 'Is Deleted',
        ];
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
