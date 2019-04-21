<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\EmployeeContracts;

/**
 * EmployeeContractsSearch represents the model behind the search form of `backend\models\EmployeeContracts`.
 */
class EmployeeContractsSearch extends EmployeeContracts
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'employee_id', 'employee_contract_month_id', 'employee_contract_type_id', 'employee_contract_status_id', 'occupation_id', 'position_id', 'user_id', 'status', 'is_deleted'], 'integer'],
            [['salary'], 'number'],
            [['file_name', 'file_path', 'date_start', 'date_end', 'created_at', 'updated_at'], 'safe'],
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
        $query = EmployeeContracts::find();

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
            'salary' => $this->salary,
            'employee_id' => $this->employee_id,
            'employee_contract_month_id' => $this->employee_contract_month_id,
            'employee_contract_type_id' => $this->employee_contract_type_id,
            'employee_contract_status_id' => $this->employee_contract_status_id,
            'occupation_id' => $this->occupation_id,
            'position_id' => $this->position_id,
            'user_id' => $this->user_id,
            'date_start' => $this->date_start,
            'date_end' => $this->date_end,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'status' => $this->status,
            'is_deleted' => $this->is_deleted,
        ]);

        $query->andFilterWhere(['like', 'file_name', $this->file_name])
            ->andFilterWhere(['like', 'file_path', $this->file_path]);

        return $dataProvider;
    }
}
