<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "trip_expenses".
 *
 * @property int $id
 * @property string $amount
 * @property string $remarks
 * @property int $user_id refd to user.id
 * @property int $trip_id refd to trips.id
 * @property int $expense_list_id refd to expense_lists.id
 * @property int $expense_type 1=Company 2=Personnel
 * @property string $created_at
 * @property string $updated_at
 * @property int $is_refundable
 * @property int $is_claimed
 * @property int $is_deleted
 *
 * @property Trips $trip
 * @property ExpenseLists $expenseList
 * @property User $user
 */
class TripExpenses extends \yii\db\ActiveRecord
{
    const EXPENSE_TYPE_COMPANY = 1;
    const EXPENSE_TYPE_PERSONNEL = 2;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'trip_expenses';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['amount'], 'number'],
            [['amount', 'expense_list_id', 'expense_type'], 'required'],
            [['remarks'], 'string'],
            [['user_id', 'trip_id', 'expense_list_id', 'expense_type', 'is_refundable', 'is_claimed', 'is_deleted'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['trip_id'], 'exist', 'skipOnError' => true, 'targetClass' => Trips::className(), 'targetAttribute' => ['trip_id' => 'id']],
            [['expense_list_id'], 'exist', 'skipOnError' => true, 'targetClass' => ExpenseLists::className(), 'targetAttribute' => ['expense_list_id' => 'id']],
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
            'remarks' => 'Remarks',
            'user_id' => 'User',
            'trip_id' => 'Trip',
            'expense_list_id' => 'Expense List',
            'expense_type' => 'Expense Type',
            'created_at' => 'Date Created',
            'updated_at' => 'Date Modified',
            'is_refundable' => 'Refundable?',
            'is_claimed' => 'Claimed?',
            'is_deleted' => 'Is Deleted',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTrip()
    {
        return $this->hasOne(Trips::className(), ['id' => 'trip_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getExpenseList()
    {
        return $this->hasOne(ExpenseLists::className(), ['id' => 'expense_list_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public static function get_ActiveExpenseType($id = null)
    {
        $active = [
            self::EXPENSE_TYPE_COMPANY => 'Company',
            self::EXPENSE_TYPE_PERSONNEL => 'Personnel',
        ];
        if (is_null($id))
            return $active;
        else
            return $active[$id];
    }
}
