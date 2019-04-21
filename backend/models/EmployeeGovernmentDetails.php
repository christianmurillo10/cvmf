<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "employee_government_details".
 *
 * @property int $id
 * @property string $tin_no
 * @property string $sss_no
 * @property string $pagibig_no
 * @property string $philhealth_no
 * @property int $employee_id refd to employees.id
 * @property int $user_id refd to user.id
 * @property string $created_at
 * @property string $updated_at
 * @property int $is_deleted
 *
 * @property Employees $employee
 * @property User $user
 */
class EmployeeGovernmentDetails extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'employee_government_details';
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
            [['tin_no', 'sss_no', 'pagibig_no', 'philhealth_no'], 'string', 'max' => 100],
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
            'tin_no' => 'TIN No',
            'sss_no' => 'SSS No',
            'pagibig_no' => 'Pagibig No',
            'philhealth_no' => 'Philhealth No',
            'employee_id' => 'Employee ID',
            'user_id' => 'User ID',
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
