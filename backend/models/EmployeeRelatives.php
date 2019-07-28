<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "employee_relatives".
 *
 * @property int $id
 * @property string $name
 * @property string $work
 * @property string $company_name
 * @property string $company_address
 * @property string $email
 * @property string $contact_no
 * @property int $educational_level_id refd to educational_levels.id
 * @property int $relationship_id refd to relationships.id
 * @property int $employee_id refd to employees.id
 * @property int $user_id refd to user.id
 * @property string $created_at
 * @property string $updated_at
 * @property int $is_deleted
 *
 * @property EducationalLevels $educationalLevel
 * @property Relationships $relationship
 * @property Employees $employee
 * @property User $user
 */
class EmployeeRelatives extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'employee_relatives';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['employee_id', 'user_id', 'created_at'], 'required'],
            [['educational_level_id', 'relationship_id', 'employee_id', 'user_id', 'is_deleted'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'work', 'company_name', 'company_address', 'email', 'contact_no'], 'string', 'max' => 100],
            [['educational_level_id'], 'exist', 'skipOnError' => true, 'targetClass' => EducationalLevels::className(), 'targetAttribute' => ['educational_level_id' => 'id']],
            [['relationship_id'], 'exist', 'skipOnError' => true, 'targetClass' => Relationships::className(), 'targetAttribute' => ['relationship_id' => 'id']],
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
            'educational_level_id' => 'Educational Level',
            'relationship_id' => 'Relationship',
            'employee_id' => 'Employee',
            'user_id' => 'User',
            'created_at' => 'Date Created',
            'updated_at' => 'Last Modified',
            'is_deleted' => 'Deleted?',
        ];
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
    public function getRelationship()
    {
        return $this->hasOne(Relationships::className(), ['id' => 'relationship_id']);
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
