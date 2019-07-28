<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "employee_contacts".
 *
 * @property int $id
 * @property string $name
 * @property string $address
 * @property string $contact_no
 * @property int $relationship_id refd to relationships.id
 * @property int $employee_id refd to employees.id
 * @property int $user_id refd to user.id
 * @property string $created_at
 * @property string $updated_at
 * @property int $is_deleted
 *
 * @property Relationships $relationship
 * @property Employees $employee
 * @property User $user
 */
class EmployeeContacts extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'employee_contacts';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['employee_id', 'user_id', 'created_at'], 'required'],
            [['relationship_id', 'employee_id', 'user_id', 'is_deleted'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'contact_no'], 'string', 'max' => 100],
            [['address'], 'string', 'max' => 255],
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
            'address' => 'Address',
            'contact_no' => 'Contact No',
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
