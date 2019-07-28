<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "trip_payment_headers".
 *
 * @property int $id
 * @property string $ref_no
 * @property string $or_no
 * @property string $total_amount
 * @property string $vat_amount
 * @property int $client_id refd to clients.id
 * @property int $user_id refd to users.id
 * @property string $date
 * @property string $created_at
 * @property string $updated_at
 * @property int $is_with_vat
 * @property int $is_deleted
 *
 * @property TripPaymentDetails[] $tripPaymentDetails
 * @property Clients $client
 * @property User $user
 */
class TripPaymentHeaders extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'trip_payment_headers';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ref_no', 'or_no', 'client_id', 'user_id', 'date', 'created_at'], 'required'],
            [['total_amount', 'vat_amount'], 'number'],
            [['client_id', 'user_id', 'is_with_vat', 'is_deleted'], 'integer'],
            [['date', 'created_at', 'updated_at'], 'safe'],
            [['ref_no', 'or_no'], 'string', 'max' => 50],
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
            'or_no' => 'Or No',
            'total_amount' => 'Total Amount',
            'vat_amount' => 'Vat Amount',
            'client_id' => 'Client ID',
            'user_id' => 'User ID',
            'date' => 'Date',
            'created_at' => 'Date Created',
            'updated_at' => 'Last Modified',
            'is_with_vat' => 'Is With Vat',
            'is_deleted' => 'Deleted?',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTripPaymentDetails()
    {
        return $this->hasMany(TripPaymentDetails::className(), ['header_id' => 'id']);
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
