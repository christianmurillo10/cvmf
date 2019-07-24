<?php

namespace backend\models;

use Yii;
use common\models\utilities\Utilities;

/**
 * This is the model class for table "clients".
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $contact_no
 * @property int $payment_term_id refd to payment_terms.id
 * @property int $user_id refd to user.id
 * @property int $status 1=Active 0=Inactive
 * @property string $created_at
 * @property string $updated_at
 * @property int $client_type 1=Direct Contractor 2=Sub-Contractor
 * @property int $is_deleted
 *
 * @property ClientDirectCompanies[] $clientDirectCompanies
 * @property User $user
 * @property PaymentTerms $paymentTerm
 * @property TripCreditBalance[] $tripCreditBalances
 * @property TripPaymentHeaders[] $tripPaymentHeaders
 * @property TripTransactions[] $tripTransactions
 * @property Trips[] $trips
 */
class Clients extends \yii\db\ActiveRecord
{
    const CLIENT_TYPE_DIRECT_CONTRACTOR = 1;
    const CLIENT_TYPE_SUB_CONTRACTOR = 2;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'clients';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'email', 'contact_no', 'payment_term_id', 'user_id', 'created_at'], 'required'],
            [['payment_term_id', 'user_id', 'status', 'client_type', 'is_deleted'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 100],
            [['email', 'contact_no'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
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
            'name' => 'Name',
            'email' => 'Email',
            'contact_no' => 'Contact No',
            'payment_term_id' => 'Payment Term',
            'user_id' => 'User',
            'status' => 'Status',
            'created_at' => 'Date Created',
            'updated_at' => 'Last Modified',
            'client_type' => 'Client Type',
            'is_deleted' => 'Is Deleted',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClientDirectCompanies()
    {
        return $this->hasMany(ClientDirectCompanies::className(), ['client_id' => 'id']);
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
    public function getPaymentTerm()
    {
        return $this->hasOne(PaymentTerms::className(), ['id' => 'payment_term_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTripCreditBalances()
    {
        return $this->hasMany(TripCreditBalance::className(), ['client_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTripPaymentHeaders()
    {
        return $this->hasMany(TripPaymentHeaders::className(), ['client_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTripTransactions()
    {
        return $this->hasMany(TripTransactions::className(), ['client_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTrips()
    {
        return $this->hasMany(Trips::className(), ['client_id' => 'id']);
    }

    public static function get_ActiveClientTypes($id = null)
    {
        $active = [
            self::CLIENT_TYPE_DIRECT_CONTRACTOR => "Direct Contractor",
            self::CLIENT_TYPE_SUB_CONTRACTOR => "Sub-Contractor",
        ];
        if (is_null($id))
            return $active;
        else
            return $active[$id];
    }

    public function getColoredStatus() 
    {
        return Utilities::get_ActiveColoredStatus($this->status);
    }

    public function getClientType() 
    {
        return self::get_ActiveClientTypes($this->client_type);
    }
}
