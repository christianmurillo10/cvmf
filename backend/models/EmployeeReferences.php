<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "employee_references".
 *
 * @property int $id
 * @property string $name
 * @property string $work
 * @property string $company_name
 * @property string $company_address
 * @property string $email
 * @property string $contact_no
 * @property int $employee_id refd to employees.id
 * @property int $user_id refd to user.id
 * @property string $created_at
 * @property string $updated_at
 * @property int $is_deleted
 *
 * @property Employees $employee
 * @property User $user
 */
class EmployeeReferences extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'employee_references';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['employee_id', 'user_id', 'created_at'], 'required'],
            [['employee_id', 'user_id', 'is_deleted'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'work', 'company_name', 'company_address', 'email', 'contact_no'], 'string', 'max' => 100],
            [['employee_id'], 'exist', 'skipOnError' => true, 'targetClass' => Employees::className(), 'targetAttribute' => ['employee_id' => 'id']],
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
            'name' => 'Name',
            'work' => 'Work',
            'company_name' => 'Company Name',
            'company_address' => 'Company Address',
            'email' => 'Email',
            'contact_no' => 'Contact No',
            'employee_id' => 'Employee',
            'user_id' => 'User',
            'created_at' => 'Date Created',
            'updated_at' => 'Last Modified',
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
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
