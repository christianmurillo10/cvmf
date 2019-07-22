<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\TripTransactions;

/**
 * TripTransactionsSearch represents the model behind the search form of `backend\models\TripTransactions`.
 */
class TripTransactionsSearch extends TripTransactions
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'trip_id', 'trip_demurrage_id', 'trip_foul_trip_id', 'client_id', 'user_id', 'trip_status', 'is_billed', 'is_fully_paid', 'is_deleted'], 'integer'],
            [['ref_no', 'trip_no', 'date', 'created_at', 'updated_at'], 'safe'],
            [['amount'], 'number'],
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
        $query = TripTransactions::find();

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
            'amount' => $this->amount,
            'trip_id' => $this->trip_id,
            'trip_demurrage_id' => $this->trip_demurrage_id,
            'trip_foul_trip_id' => $this->trip_foul_trip_id,
            'client_id' => $this->client_id,
            'user_id' => $this->user_id,
            'date' => $this->date,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'trip_status' => $this->trip_status,
            'is_billed' => $this->is_billed,
            'is_fully_paid' => $this->is_fully_paid,
            'is_deleted' => $this->is_deleted,
        ]);

        $query->andFilterWhere(['like', 'ref_no', $this->ref_no])
            ->andFilterWhere(['like', 'trip_no', $this->trip_no]);

        return $dataProvider;
    }
}
