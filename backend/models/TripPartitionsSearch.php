<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\TripPartitions;

/**
 * TripPartitionsSearch represents the model behind the search form of `backend\models\TripPartitions`.
 */
class TripPartitionsSearch extends TripPartitions
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'trip_id', 'tax_percentage_id', 'is_deleted'], 'integer'],
            [['gross_amount', 'vat_amount', 'maintenance_amount', 'total_expense_amount', 'net_amount', 'total_personnel_profit_amount', 'net_profit_amount'], 'number'],
            [['created_at', 'updated_at'], 'safe'],
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
        $query = TripPartitions::find();

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
            'gross_amount' => $this->gross_amount,
            'vat_amount' => $this->vat_amount,
            'maintenance_amount' => $this->maintenance_amount,
            'total_expense_amount' => $this->total_expense_amount,
            'net_amount' => $this->net_amount,
            'total_personnel_profit_amount' => $this->total_personnel_profit_amount,
            'net_profit_amount' => $this->net_profit_amount,
            'user_id' => $this->user_id,
            'trip_id' => $this->trip_id,
            'tax_percentage_id' => $this->tax_percentage_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'is_deleted' => $this->is_deleted,
        ]);

        return $dataProvider;
    }
}
