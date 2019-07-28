<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "trip_billing_headers".
 *
 * @property int $id
 * @property string $billing_no
 * @property string $total_amount
 * @property int $prepared_by refd to employees.id
 * @property int $noted_by refd to employees.id
 * @property int $user_id refd to users.id
 * @property int $client_id refd to clients.id
 * @property int $payment_term_id refd to payment_terms.id
 * @property string $date
 * @property string $created_at
 * @property string $updated_at
 * @property int $status 1=New 2=On Going 3=Paid
 * @property int $is_with_others
 * @property int $is_deleted
 *
 * @property TripBillingDetails[] $tripBillingDetails
 * @property Employees $preparedBy
 * @property Employees $notedBy
 * @property User $user
 * @property Clients $client
 * @property PaymentTerms $paymentTerm
 */
class TripBillingHeaders extends \yii\db\ActiveRecord
{
    const BILLING_STATUS_NEW = 1;
    const BILLING_STATUS_ON_GOING = 2;
    const BILLING_STATUS_PAID = 3;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'trip_billing_headers';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['billing_no', 'prepared_by', 'noted_by', 'user_id', 'client_id', 'payment_term_id', 'date', 'created_at'], 'required'],
            [['total_amount'], 'number'],
            [['prepared_by', 'noted_by', 'user_id', 'client_id', 'payment_term_id', 'status', 'is_with_others', 'is_deleted'], 'integer'],
            [['date', 'created_at', 'updated_at'], 'safe'],
            [['billing_no'], 'string', 'max' => 50],
            [['prepared_by'], 'exist', 'skipOnError' => true, 'targetClass' => Employees::className(), 'targetAttribute' => ['prepared_by' => 'id']],
            [['noted_by'], 'exist', 'skipOnError' => true, 'targetClass' => Employees::className(), 'targetAttribute' => ['noted_by' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['client_id'], 'exist', 'skipOnError' => true, 'targetClass' => Clients::className(), 'targetAttribute' => ['client_id' => 'id']],
            [['payment_term_id'], 'exist', 'skipOnError' => true, 'targetClass' => PaymentTerms::className(), 'targetAttribute' => ['payment_term_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'billing_no' => 'Billing No',
            'total_amount' => 'Total Amount',
            'prepared_by' => 'Prepared By',
            'noted_by' => 'Noted By',
            'user_id' => 'User',
            'client_id' => 'Client',
            'payment_term_id' => 'Payment Term',
            'date' => 'Date',
            'created_at' => 'Date Created',
            'updated_at' => 'Last Modified',
            'status' => 'Status',
            'is_with_others' => 'With Others?',
            'is_deleted' => 'Deleted?',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTripBillingDetails()
    {
        return $this->hasMany(TripBillingDetails::className(), ['header_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPreparedBy()
    {
        return $this->hasOne(Employees::className(), ['id' => 'prepared_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNotedBy()
    {
        return $this->hasOne(Employees::className(), ['id' => 'noted_by']);
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
    public function getPaymentTerm()
    {
        return $this->hasOne(PaymentTerms::className(), ['id' => 'payment_term_id']);
    }

    public static function get_ActiveBillingStatus($id = null)
    {
        $active = [
            self::BILLING_STATUS_NEW => 'New',
            self::BILLING_STATUS_ON_GOING => 'On Going',
            self::BILLING_STATUS_PAID => 'Paid',
        ];
        if (is_null($id))
            return $active;
        else
            return $active[$id];
    }

    public function getBillingStatus()
    {
        return self::get_ActiveBillingStatus($this->status);
    }
}
