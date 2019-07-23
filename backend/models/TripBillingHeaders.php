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
 */
class TripBillingHeaders extends \yii\db\ActiveRecord
{
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
            [['billing_no', 'prepared_by', 'noted_by', 'user_id', 'created_at'], 'required'],
            [['total_amount'], 'number'],
            [['prepared_by', 'noted_by', 'user_id', 'status', 'is_with_others', 'is_deleted'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['billing_no'], 'string', 'max' => 50],
            [['prepared_by'], 'exist', 'skipOnError' => true, 'targetClass' => Employees::className(), 'targetAttribute' => ['prepared_by' => 'id']],
            [['noted_by'], 'exist', 'skipOnError' => true, 'targetClass' => Employees::className(), 'targetAttribute' => ['noted_by' => 'id']],
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
            'billing_no' => 'Billing No',
            'total_amount' => 'Total Amount',
            'prepared_by' => 'Prepared By',
            'noted_by' => 'Noted By',
            'user_id' => 'User ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
            'is_with_others' => 'Is With Others',
            'is_deleted' => 'Is Deleted',
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
}
