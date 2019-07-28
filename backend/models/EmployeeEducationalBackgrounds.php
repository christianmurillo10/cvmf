<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "employee_educational_backgrounds".
 *
 * @property int $id
 * @property int $year_from
 * @property int $year_to
 * @property string $course
 * @property string $school_name
 * @property string $school_address
 * @property int $employee_id refd to employees.id
 * @property int $educational_type_id refd to educational_types.id
 * @property int $user_id refd to users.id
 * @property string $created_at
 * @property string $updated_at
 * @property int $is_deleted
 *
 * @property Employees $employee
 * @property EducationalTypes $educationalType
 * @property User $user
 */
class EmployeeEducationalBackgrounds extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'employee_educational_backgrounds';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['employee_id', 'user_id', 'created_at'], 'required'],
            [['year_from', 'year_to', 'employee_id', 'educational_type_id', 'user_id', 'is_deleted'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['course', 'school_name', 'school_address'], 'string', 'max' => 100],
            [['employee_id'], 'exist', 'skipOnError' => true, 'targetClass' => Employees::className(), 'targetAttribute' => ['employee_id' => 'id']],
            [['educational_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => EducationalTypes::className(), 'targetAttribute' => ['educational_type_id' => 'id']],
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
            'year_from' => 'Year From',
            'year_to' => 'Year To',
            'course' => 'Course',
            'school_name' => 'School Name',
            'school_address' => 'School Address',
            'employee_id' => 'Employee',
            'educational_type_id' => 'Educational Type',
            'user_id' => 'User',
            'created_at' => 'Date Created',
            'updated_at' => 'Last Modified',
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
    public function getEducationalType()
    {
        return $this->hasOne(EducationalTypes::className(), ['id' => 'educational_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
