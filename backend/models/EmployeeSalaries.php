<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "employee_salaries".
 *
 * @property int $id
 * @property string $amount
 * @property int $employee_id refd to employees.id
 * @property int $employee_contract_id refd to employee_contracts.id
 * @property int $user_id refd to users.id
 * @property string $date_issued
 * @property string $created_at
 * @property string $updated_at
 * @property int $is_current
 * @property int $is_deleted
 *
 * @property Employees $employee
 * @property EmployeeContracts $employeeContract
 * @property User $user
 */
class EmployeeSalaries extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'employee_salaries';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['amount'], 'number'],
            [['employee_id', 'employee_contract_id', 'user_id', 'date_issued', 'created_at'], 'required'],
            [['employee_id', 'employee_contract_id', 'user_id', 'is_current', 'is_deleted'], 'integer'],
            [['date_issued', 'created_at', 'updated_at'], 'safe'],
            [['employee_id'], 'exist', 'skipOnError' => true, 'targetClass' => Employees::className(), 'targetAttribute' => ['employee_id' => 'id']],
            [['employee_contract_id'], 'exist', 'skipOnError' => true, 'targetClass' => EmployeeContracts::className(), 'targetAttribute' => ['employee_contract_id' => 'id']],
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
            'amount' => 'Amount',
            'employee_id' => 'Employee ID',
            'employee_contract_id' => 'Employee Contract ID',
            'user_id' => 'User ID',
            'date_issued' => 'Date Issued',
            'created_at' => 'Date Created',
            'updated_at' => 'Last Modified',
            'is_current' => 'Is Current',
            'is_deleted' => 'Is Deleted',
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
    public function getEmployeeContract()
    {
        return $this->hasOne(EmployeeContracts::className(), ['id' => 'employee_contract_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
