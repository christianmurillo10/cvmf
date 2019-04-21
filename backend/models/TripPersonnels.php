<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "trip_personnels".
 *
 * @property int $id
 * @property double $percentage
 * @property string $profit_amount
 * @property int $user_id refd to user.id
 * @property int $trip_id refd to trips.id
 * @property int $employee_id refd to employees.id
 * @property int $role_type 1=Driver 2=Helper 3=Driver/Helper
 * @property string $created_at
 * @property string $updated_at
 * @property int $is_deleted
 *
 * @property User $user
 * @property Trips $trip
 * @property Employees $employee
 */
class TripPersonnels extends \yii\db\ActiveRecord
{
    const PERSONNEL_DRIVER = 1;
    const PERSONNEL_HELPER = 2;
    const PERSONNEL_DRIVER_HELPER = 3;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'trip_personnels';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['employee_id', 'role_type'], 'required'],
            [['user_id', 'trip_id', 'employee_id', 'role_type', 'is_deleted'], 'integer'],
            // [['percentage', 'profit_amount'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['trip_id'], 'exist', 'skipOnError' => true, 'targetClass' => Trips::className(), 'targetAttribute' => ['trip_id' => 'id']],
            [['employee_id'], 'exist', 'skipOnError' => true, 'targetClass' => Employees::className(), 'targetAttribute' => ['employee_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'percentage' => 'Percentage',
            'profit_amount' => 'Profit Amount',
            'user_id' => 'User',
            'trip_id' => 'Trip',
            'employee_id' => 'Employee',
            'role_type' => 'Role Type',
            'created_at' => 'Date Created',
            'updated_at' => 'Date Modified',
            'is_deleted' => 'Is Deleted',
        ];
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
    public function getTrip()
    {
        return $this->hasOne(Trips::className(), ['id' => 'trip_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployee()
    {
        return $this->hasOne(Employees::className(), ['id' => 'employee_id']);
    }

    public static function get_ActiveRoleType($id = null)
    {
        $active = [
            self::PERSONNEL_DRIVER => 'Driver',
            self::PERSONNEL_HELPER => 'Helper',
            self::PERSONNEL_DRIVER_HELPER => 'Driver/Helper',
        ];
        if (is_null($id))
            return $active;
        else
            return $active[$id];
    }

    public static function get_DefaultPercentage($id = null)
    {
        $active = [
            self::PERSONNEL_DRIVER => 15,
            self::PERSONNEL_HELPER => 8,
            self::PERSONNEL_DRIVER_HELPER => 15,
        ];
        if (is_null($id))
            return $active;
        else
            return $active[$id];
    }
}
