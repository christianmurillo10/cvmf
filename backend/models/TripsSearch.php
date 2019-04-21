<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Trips;

/**
 * TripsSearch represents the model behind the search form of `backend\models\Trips`.
 */
class TripsSearch extends Trips
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'client_id', 'vehicle_id', 'destination_from_id', 'destination_to_id', 'status', 'is_deleted'], 'integer'],
            [['trip_no', 'remarks', 'date_issued', 'date_delivered', 'created_at', 'updated_at'], 'safe'],
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
        $query = Trips::find();

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
            'user_id' => $this->user_id,
            'client_id' => $this->client_id,
            'vehicle_id' => $this->vehicle_id,
            'destination_from_id' => $this->destination_from_id,
            'destination_to_id' => $this->destination_to_id,
            'status' => $this->status,
            'date_issued' => $this->date_issued,
            'date_delivered' => $this->date_delivered,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'is_deleted' => $this->is_deleted,
        ]);

        $query->andFilterWhere(['like', 'trip_no', $this->trip_no])
            ->andFilterWhere(['like', 'remarks', $this->remarks]);

        return $dataProvider;
    }
}
