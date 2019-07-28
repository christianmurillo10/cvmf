<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tax_percentage_lists".
 *
 * @property int $id
 * @property double $value
 * @property string $created_at
 * @property string $updated_at
 * @property int $is_deleted
 */
class TaxPercentageLists extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tax_percentage_lists';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['value', 'created_at'], 'required'],
            [['value'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['is_deleted'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'value' => 'Value',
            'created_at' => 'Date Created',
            'updated_at' => 'Date Modified',
            'is_deleted' => 'Deleted?',
        ];
    }
}
