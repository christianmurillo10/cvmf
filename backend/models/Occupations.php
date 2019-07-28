<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "occupations".
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $created_at
 * @property string $updated_at
 * @property int $is_deleted
 *
 * @property EmployeeContracts[] $employeeContracts
 * @property Employees[] $employees
 */
class Occupations extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'occupations';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'description', 'created_at'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['is_deleted'], 'integer'],
            [['name'], 'string', 'max' => 100],
            [['description'], 'string', 'max' => 255],
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
            'description' => 'Description',
            'created_at' => 'Date Created',
            'updated_at' => 'Last Modified',
            'is_deleted' => 'Deleted?',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployeeContracts()
    {
        return $this->hasMany(EmployeeContracts::className(), ['occupation_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEmployees()
    {
        return $this->hasMany(Employees::className(), ['occupation_id' => 'id']);
    }
}
