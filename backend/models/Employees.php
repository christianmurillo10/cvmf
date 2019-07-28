<?php

namespace backend\models;

use Yii;
use common\models\utilities\Utilities;

/**
 * This is the model class for table "employees".
 *
 * @property int $id
 * @property string $employee_no
 * @property string $firstname
 * @property string $middlename
 * @property string $lastname
 * @property string $primary_address
 * @property string $secondary_address
 * @property string $email
 * @property string $contact_no
 * @property int $suffix_id refd to suffixes.id
 * @property int $occupation_id refd to occupations.id
 * @property int $position_id refd to positions.id
 * @property int $employee_department_id refd to employee_departments.id
 * @property int $educational_level_id refd to educational_levels.id
 * @property int $pay_rate_type_id refd to pay_rate_types.id
 * @property int $employment_status_id refd to employment_statuses.id
 * @property int $user_id refd to user.id
 * @property string $birthdate
 * @property string $date_start
 * @property string $date_endo
 * @property string $created_at
 * @property string $updated_at
 * @property int $gender_type 1=Male 2=Female
 * @property int $civil_status_type 1=Single 2=Married 3=Divorced 4=Widowed
 * @property int $is_active
 * @property int $is_deleted
 *
 * @property EmployeeBenefits[] $employeeBenefits
 * @property EmployeeContacts[] $employeeContacts
 * @property EmployeeContracts[] $employeeContracts
 * @property EmployeeEducationalBackgrounds[] $employeeEducationalBackgrounds
 * @property EmployeeGovernmentDetails[] $employeeGovernmentDetails
 * @property EmployeeImages[] $employeeImages
 * @property EmployeeReferences[] $employeeReferences
 * @property EmployeeRelatives[] $employeeRelatives
 * @property EmployeeSalaries[] $employeeSalaries
 * @property Suffixes $suffix
 * @property Occupations $occupation
 * @property EmployeeDepartments $employeeDepartment
 * @property EducationalLevels $educationalLevel
 * @property PayRateTypes $payRateType
 * @property EmploymentStatuses $employmentStatus
 * @property User $user
 * @property Positions $position
 * @property TripBillingHeaders[] $tripBillingHeaders
 * @property TripBillingHeaders[] $tripBillingHeaders0
 * @property TripPersonnels[] $tripPersonnels
 */
class Employees extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'employees';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['employee_no', 'firstname', 'lastname', 'primary_address', 'email', 'contact_no', 'occupation_id', 'position_id', 'employee_department_id', 'pay_rate_type_id', 'employment_status_id', 'user_id', 'gender_type', 'civil_status_type', 'birthdate', 'date_start', 'created_at', 'is_active'], 'required'],
            [['suffix_id', 'occupation_id', 'position_id', 'employee_department_id', 'educational_level_id', 'pay_rate_type_id', 'employment_status_id', 'user_id', 'gender_type', 'civil_status_type', 'is_active', 'is_deleted'], 'integer'],
            [['birthdate', 'date_start', 'date_endo', 'created_at', 'updated_at'], 'safe'],
            [['employee_no'], 'string', 'max' => 50],
            [['firstname', 'middlename', 'lastname', 'email', 'contact_no'], 'string', 'max' => 100],
            [['primary_address', 'secondary_address'], 'string', 'max' => 255],
            [['suffix_id'], 'exist', 'skipOnError' => true, 'targetClass' => Suffixes::className(), 'targetAttribute' => ['suffix_id' => 'id']],
            [['occupation_id'], 'exist', 'skipOnError' => true, 'targetClass' => Occupations::className(), 'targetAttribute' => ['occupation_id' => 'id']],
            [['employee_department_id'], 'exist', 'skipOnError' => true, 'targetClass' => EmployeeDepartments::className(), 'targetAttribute' => ['employee_department_id' => 'id']],
            [['educational_level_id'], 'exist', 'skipOnError' => true, 'targetClass' => EducationalLevels::className(), 'targetAttribute' => ['educational_level_id' => 'id']],
            [['pay_rate_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => PayRateTypes::className(), 'targetAttribute' => ['pay_rate_type_id' => 'id']],
            [['employment_status_id'], 'exist', 'skipOnError' => true, 'targetClass' => EmploymentStatuses::className(), 'targetAttribute' => ['employment_status_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['position_id'], 'exist', 'skipOnError' => true, 'targetClass' => Positions::className(), 'targetAttribute' => ['position_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'employee_no' => 'Employee No',
            'firstname' => 'Firstname',
            'middlename' => 'Middlename',
            'lastname' => 'Lastname',
            'primary_address' => 'Primary Address',
            'secondary_address' => 'Secondary Address',
            'email' => 'Email',
            'contact_no' => 'Contact No',
            'suffix_id' => 'Suffix',
            'occupation_id' => 'Occupation',
            'position_id' => 'Position',
            'employee_department_id' => 'Department',
            'educational_level_id' => 'Educational Level',
            'pay_rate_type_id' => 'Pay Rate Type',
            'employment_status_id' => 'Employment Status',
            'user_id' => 'User',
            'birthdate' => 'Birthdate',
            'date_start' => 'Date Start',
            'date_endo' => 'Date Endo',
            'created_at' => 'Date Created',
            'updated_at' => 'Date Modified',
            'gender_type' => 'Gender',
            'civil_status_type' => 'Civil Status',
            'is_active' => 'Active',
            'is_deleted' => 'Deleted?',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployeeBenefits()
    {
        return $this->hasMany(EmployeeBenefits::className(), ['employee_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployeeContacts()
    {
        return $this->hasMany(EmployeeContacts::className(), ['employee_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployeeContracts()
    {
        return $this->hasMany(EmployeeContracts::className(), ['employee_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployeeEducationalBackgrounds()
    {
        return $this->hasMany(EmployeeEducationalBackgrounds::className(), ['employee_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployeeGovernmentDetails()
    {
        return $this->hasMany(EmployeeGovernmentDetails::className(), ['employee_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployeeImages()
    {
        return $this->hasMany(EmployeeImages::className(), ['employee_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployeeReferences()
    {
        return $this->hasMany(EmployeeReferences::className(), ['employee_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployeeRelatives()
    {
        return $this->hasMany(EmployeeRelatives::className(), ['employee_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployeeSalaries()
    {
        return $this->hasMany(EmployeeSalaries::className(), ['employee_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSuffix()
    {
        return $this->hasOne(Suffixes::className(), ['id' => 'suffix_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOccupation()
    {
        return $this->hasOne(Occupations::className(), ['id' => 'occupation_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployeeDepartment()
    {
        return $this->hasOne(EmployeeDepartments::className(), ['id' => 'employee_department_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEducationalLevel()
    {
        return $this->hasOne(EducationalLevels::className(), ['id' => 'educational_level_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPayRateType()
    {
        return $this->hasOne(PayRateTypes::className(), ['id' => 'pay_rate_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmploymentStatus()
    {
        return $this->hasOne(EmploymentStatuses::className(), ['id' => 'employment_status_id']);
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
    public function getPosition()
    {
        return $this->hasOne(Positions::className(), ['id' => 'position_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTripBillingHeaders()
    {
        return $this->hasMany(TripBillingHeaders::className(), ['prepared_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTripBillingHeaders0()
    {
        return $this->hasMany(TripBillingHeaders::className(), ['noted_by' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTripPersonnels()
    {
        return $this->hasMany(TripPersonnels::className(), ['employee_id' => 'id']);
    }

    public function getFullname()
    {
        $suffixName = empty($this->suffix_id) ? '' : Utilities::setCapitalFirst($this->suffix->name);
        return Utilities::setCapitalAll($this->lastname) . ', ' . Utilities::setCapitalFirst($this->firstname) . ' ' . Utilities::setCapitalFirst(substr($this->middlename, 0 , 1) . '. ' . $suffixName);
    }

    public function getColoredStatus() 
    {
        return Utilities::get_ActiveColoredStatus($this->is_active);
    }
}
