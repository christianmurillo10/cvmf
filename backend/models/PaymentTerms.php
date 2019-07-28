<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "payment_terms".
 *
 * @property int $id
 * @property string $name
 * @property int $value
 * @property string $created_at
 * @property string $updated_at
 * @property int $is_deleted
 *
 * @property Clients[] $clients
 * @property TripBillingHeaders[] $tripBillingHeaders
 */
class PaymentTerms extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'payment_terms';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'value', 'created_at'], 'required'],
            [['value', 'is_deleted'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 100],
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
            'value' => 'Value',
            'created_at' => 'Date Created',
            'updated_at' => 'Last Modified',
            'is_deleted' => 'Deleted?',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClients()
    {
        return $this->hasMany(Clients::className(), ['payment_term_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTripBillingHeaders()
    {
        return $this->hasMany(TripBillingHeaders::className(), ['payment_term_id' => 'id']);
    }
}
