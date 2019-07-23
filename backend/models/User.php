<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 *
 * @property ClientDirectCompanies[] $clientDirectCompanies
 * @property Clients[] $clients
 * @property EmployeeBenefits[] $employeeBenefits
 * @property EmployeeContacts[] $employeeContacts
 * @property EmployeeContracts[] $employeeContracts
 * @property EmployeeEducationalBackgrounds[] $employeeEducationalBackgrounds
 * @property EmployeeGovernmentDetails[] $employeeGovernmentDetails
 * @property EmployeeImages[] $employeeImages
 * @property EmployeeReferences[] $employeeReferences
 * @property EmployeeRelatives[] $employeeRelatives
 * @property EmployeeSalaries[] $employeeSalaries
 * @property Employees[] $employees
 * @property TripBillingDetails[] $tripBillingDetails
 * @property TripBillingHeaders[] $tripBillingHeaders
 * @property TripDemurrages[] $tripDemurrages
 * @property TripExpenses[] $tripExpenses
 * @property TripFoulTrips[] $tripFoulTrips
 * @property TripPartitions[] $tripPartitions
 * @property TripTransactions[] $tripTransactions
 * @property Trips[] $trips
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'auth_key', 'password_hash', 'email', 'created_at', 'updated_at'], 'required'],
            [['status', 'created_at', 'updated_at'], 'integer'],
            [['username', 'password_hash', 'password_reset_token', 'email'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['username'], 'unique'],
            [['email'], 'unique'],
            [['password_reset_token'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'email' => 'Email',
            'status' => 'Status',
            'created_at' => 'Date Created',
            'updated_at' => 'Date Modified',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClientDirectCompanies()
    {
        return $this->hasMany(ClientDirectCompanies::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getClients()
    {
        return $this->hasMany(Clients::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployeeBenefits()
    {
        return $this->hasMany(EmployeeBenefits::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployeeContacts()
    {
        return $this->hasMany(EmployeeContacts::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployeeContracts()
    {
        return $this->hasMany(EmployeeContracts::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployeeEducationalBackgrounds()
    {
        return $this->hasMany(EmployeeEducationalBackgrounds::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployeeGovernmentDetails()
    {
        return $this->hasMany(EmployeeGovernmentDetails::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployeeImages()
    {
        return $this->hasMany(EmployeeImages::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployeeReferences()
    {
        return $this->hasMany(EmployeeReferences::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployeeRelatives()
    {
        return $this->hasMany(EmployeeRelatives::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployeeSalaries()
    {
        return $this->hasMany(EmployeeSalaries::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployees()
    {
        return $this->hasMany(Employees::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTripBillingDetails()
    {
        return $this->hasMany(TripBillingDetails::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTripBillingHeaders()
    {
        return $this->hasMany(TripBillingHeaders::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTripDemurrages()
    {
        return $this->hasMany(TripDemurrages::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTripExpenses()
    {
        return $this->hasMany(TripExpenses::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTripFoulTrips()
    {
        return $this->hasMany(TripFoulTrips::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTripPartitions()
    {
        return $this->hasMany(TripPartitions::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTripTransactions()
    {
        return $this->hasMany(TripTransactions::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTrips()
    {
        return $this->hasMany(Trips::className(), ['user_id' => 'id']);
    }
}
