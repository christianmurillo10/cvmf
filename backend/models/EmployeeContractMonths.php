<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "employee_contract_months".
 *
 * @property int $id
 * @property string $name
 * @property string $value
 * @property string $created_at
 * @property string $updated_at
 * @property int $is_deleted
 *
 * @property EmployeeContracts[] $employeeContracts
 */
class EmployeeContractMonths extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'employee_contract_months';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'value', 'created_at'], 'required'],
            [['created_at', 'updated_at'], 'safe'],
            [['is_deleted'], 'integer'],
            [['name', 'value'], 'string', 'max' => 100],
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
            'value' => 'Value',
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
        return $this->hasMany(EmployeeContracts::className(), ['employee_contract_month_id' => 'id']);
    }
}
