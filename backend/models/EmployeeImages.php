<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "employee_images".
 *
 * @property int $id
 * @property string $file_name
 * @property string $file_path
 * @property int $employee_id refd to employees.id
 * @property int $user_id refd to user.id
 * @property string $created_at
 * @property string $updated_at
 * @property int $is_deleted
 *
 * @property Employees $employee
 * @property User $user
 */
class EmployeeImages extends \yii\db\ActiveRecord
{
    public $image_upload;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'employee_images';
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
            [['file_name', 'file_path'], 'string', 'max' => 100],
            [['image_upload'], 'file', 'extensions' => 'jpg, gif, png'],
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
            'image_upload' => 'Image Upload',
            'file_name' => 'File Name',
            'file_path' => 'File Path',
            'employee_id' => 'Employee ID',
            'user_id' => 'User ID',
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
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
