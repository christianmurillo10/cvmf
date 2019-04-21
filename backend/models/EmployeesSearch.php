<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Employees;

/**
 * EmployeesSearch represents the model behind the search form of `backend\models\Employees`.
 */
class EmployeesSearch extends Employees
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'suffix_id', 'occupation_id', 'employee_department_id', 'educational_level_id', 'pay_rate_type_id', 'employment_status_id', 'user_id', 'gender_type', 'civil_status_type', 'is_active', 'is_deleted'], 'integer'],
            [['employee_no', 'firstname', 'middlename', 'lastname', 'primary_address', 'secondary_address', 'email', 'contact_no', 'birthdate', 'date_start', 'date_endo', 'created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Employees::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'suffix_id' => $this->suffix_id,
            'occupation_id' => $this->occupation_id,
            'employee_department_id' => $this->employee_department_id,
            'educational_level_id' => $this->educational_level_id,
            'pay_rate_type_id' => $this->pay_rate_type_id,
            'employment_status_id' => $this->employment_status_id,
            'user_id' => $this->user_id,
            'birthdate' => $this->birthdate,
            'date_start' => $this->date_start,
            'date_endo' => $this->date_endo,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'gender_type' => $this->gender_type,
            'civil_status_type' => $this->civil_status_type,
            'is_active' => $this->is_active,
            'is_deleted' => $this->is_deleted,
        ]);

        $query->andFilterWhere(['like', 'employee_no', $this->employee_no])
            ->andFilterWhere(['like', 'firstname', $this->firstname])
            ->andFilterWhere(['like', 'middlename', $this->middlename])
            ->andFilterWhere(['like', 'lastname', $this->lastname])
            ->andFilterWhere(['like', 'primary_address', $this->primary_address])
            ->andFilterWhere(['like', 'secondary_address', $this->secondary_address])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'contact_no', $this->contact_no]);

        return $dataProvider;
    }
}
