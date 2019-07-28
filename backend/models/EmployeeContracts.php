<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "employee_contracts".
 *
 * @property int $id
 * @property string $salary
 * @property string $file_name
 * @property string $file_path
 * @property int $employee_id refd to employees.id
 * @property int $employee_contract_month_id refd to employee_contract_months.id
 * @property int $employee_contract_type_id refd to employee_contract_types.id
 * @property int $employee_contract_status_id refd to employee_contract_statuses.id
 * @property int $occupation_id refd to occupations.id
 * @property int $position_id refd to positions.id
 * @property int $user_id refd to user.id
 * @property string $date_start
 * @property string $date_end
 * @property string $created_at
 * @property string $updated_at
 * @property int $status 1=On Going 2=Expired
 * @property int $is_deleted
 *
 * @property Employees $employee
 * @property EmployeeContractMonths $employeeContractMonth
 * @property EmployeeContractTypes $employeeContractType
 * @property EmployeeContractStatuses $employeeContractStatus
 * @property Occupations $occupation
 * @property Positions $position
 * @property User $user
 */
class EmployeeContracts extends \yii\db\ActiveRecord
{
    const STATUS_ON_GOING = 1;
    const STATUS_EXPIRED = 2;

    public $file_upload;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'employee_contracts';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['salary', 'employee_id', 'employee_contract_type_id', 'employee_contract_status_id', 'occupation_id', 'position_id', 'user_id', 'date_start', 'created_at', 'status'], 'required'],
            [['employee_id', 'employee_contract_month_id', 'employee_contract_type_id', 'employee_contract_status_id', 'occupation_id', 'position_id', 'user_id', 'status', 'is_deleted'], 'integer'],
            [['date_start', 'date_end', 'created_at', 'updated_at'], 'safe'],
            [['file_name', 'file_path'], 'string', 'max' => 100],
            [['file_upload'], 'file'],
            [['employee_id'], 'exist', 'skipOnError' => true, 'targetClass' => Employees::className(), 'targetAttribute' => ['employee_id' => 'id']],
            [['employee_contract_month_id'], 'exist', 'skipOnError' => true, 'targetClass' => EmployeeContractMonths::className(), 'targetAttribute' => ['employee_contract_month_id' => 'id']],
            [['employee_contract_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => EmployeeContractTypes::className(), 'targetAttribute' => ['employee_contract_type_id' => 'id']],
            [['employee_contract_status_id'], 'exist', 'skipOnError' => true, 'targetClass' => EmployeeContractStatuses::className(), 'targetAttribute' => ['employee_contract_status_id' => 'id']],
            [['occupation_id'], 'exist', 'skipOnError' => true, 'targetClass' => Occupations::className(), 'targetAttribute' => ['occupation_id' => 'id']],
            [['position_id'], 'exist', 'skipOnError' => true, 'targetClass' => Positions::className(), 'targetAttribute' => ['position_id' => 'id']],
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
            'file_upload' => 'File Upload',
            'salary' => 'Salary',
            'file_name' => 'File Name',
            'file_path' => 'File Path',
            'employee_id' => 'Employee',
            'employee_contract_month_id' => 'Contract Month',
            'employee_contract_type_id' => 'Contract Type',
            'employee_contract_status_id' => 'Remarks',
            'occupation_id' => 'Occupation',
            'position_id' => 'Position',
            'user_id' => 'User',
            'date_start' => 'Date Start',
            'date_end' => 'Date End',
            'created_at' => 'Date Created',
            'updated_at' => 'Last Modified',
            'status' => 'Status',
            'is_deleted' => 'Deleted?',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployee()
    {
        return $this->hasOne(Employees::className(), ['id' => 'employee_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployeeContractMonth()
    {
        return $this->hasOne(EmployeeContractMonths::className(), ['id' => 'employee_contract_month_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployeeContractType()
    {
        return $this->hasOne(EmployeeContractTypes::className(), ['id' => 'employee_contract_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployeeContractStatus()
    {
        return $this->hasOne(EmployeeContractStatuses::className(), ['id' => 'employee_contract_status_id']);
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
    public function getPosition()
    {
        return $this->hasOne(Positions::className(), ['id' => 'position_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public static function get_Statuses($id = null)
    {
        $active = [
            self::STATUS_ON_GOING => 'On Going',
            self::STATUS_EXPIRED => 'Expired',
        ];
        if (is_null($id))
            return $active;
        else
            return $active[$id];
    }

    public static function get_ColoredStatuses($id = null)
    {
        $active = [
            self::STATUS_ON_GOING => '<span class="label label-success">On Going</span>',
            self::STATUS_EXPIRED => '<span class="label label-danger">Expired</span>',
        ];
        if (is_null($id))
            return $active;
        else
            return $active[$id];
    }

    public function getStatuses() 
    {
        return self::get_Statuses($this->status);
    }

    public function getColoredStatuses() 
    {
        return self::get_ColoredStatuses($this->status);
    }
}
