<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "vehicles".
 *
 * @property int $id
 * @property string $plate_no
 * @property string $temporary_plate_no
 * @property string $model
 * @property int $year_model
 * @property int $user_id refd to user.id
 * @property int $global_brand_id refd to global_brands.id
 * @property int $vehicle_type_id refd to vehicle_types.id
 * @property int $vehicle_owner_id refd to vehicle_owners.id
 * @property int $owned_type 1=Purchased 2=Rented
 * @property int $is_with_plate
 * @property int $is_brand_new
 * @property int $status 1=Active 0=Inactive
 * @property string $created_at
 * @property string $updated_at
 * @property int $is_deleted
 *
 * @property Trips[] $trips
 */
class Vehicles extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vehicles';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['model', 'year_model', 'user_id', 'global_brand_id', 'vehicle_type_id', 'vehicle_owner_id', 'created_at'], 'required'],
            [['year_model', 'user_id', 'global_brand_id', 'vehicle_type_id', 'vehicle_owner_id', 'owned_type', 'is_with_plate', 'is_brand_new', 'status', 'is_deleted'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['plate_no', 'temporary_plate_no', 'model'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'plate_no' => 'Plate No',
            'temporary_plate_no' => 'Temporary Plate No',
            'model' => 'Model',
            'year_model' => 'Year Model',
            'user_id' => 'User',
            'global_brand_id' => 'Global Brand',
            'vehicle_type_id' => 'Vehicle Type',
            'vehicle_owner_id' => 'Vehicle Owner',
            'owned_type' => 'Owned Type',
            'is_with_plate' => 'Is With Plate',
            'is_brand_new' => 'Is Brand New',
            'status' => 'Status',
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
        return $this->hasMany(Trips::className(), ['vehicle_id' => 'id']);
    }
}
