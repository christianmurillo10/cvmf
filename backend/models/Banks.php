<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "banks".
 *
 * @property int $id
 * @property string $code
 * @property string $name
 * @property string $created_at
 * @property string $updated_at
 * @property int $is_deleted
 *
 * @property TripPaymentDetails[] $tripPaymentDetails
 */
class Banks extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'banks';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['code', 'name', 'created_at'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['is_deleted'], 'integer'],
            [['code', 'name'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => 'Code',
            'name' => 'Name',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'is_deleted' => 'Is Deleted',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTripPaymentDetails()
    {
        return $this->hasMany(TripPaymentDetails::className(), ['cheque_bank_id' => 'id']);
    }
}
