<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "destinations".
 *
 * @property int $id
 * @property string $name
 * @property string $created_at
 * @property string $updated_at
 * @property int $is_deleted
 * 
 * @property Trips[] $trips 
 * @property Trips[] $trips0 
 */
class Destinations extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'destinations';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'created_at'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['is_deleted'], 'integer'],
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
            'created_at' => 'Date Created',
            'updated_at' => 'Date Modified',
            'is_deleted' => 'Is Deleted',
        ];
    }
 
    /** 
     * @return \yii\db\ActiveQuery 
     */ 
    public function getTrips() 
    { 
        return $this->hasMany(Trips::className(), ['destination_from_id' => 'id']); 
    } 
  
    /** 
     * @return \yii\db\ActiveQuery 
     */ 
    public function getTrips0() 
    { 
        return $this->hasMany(Trips::className(), ['destination_to_id' => 'id']); 
    } 
}
