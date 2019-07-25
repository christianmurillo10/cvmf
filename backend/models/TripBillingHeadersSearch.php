<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\TripBillingHeaders;

/**
 * TripBillingHeadersSearch represents the model behind the search form of `backend\models\TripBillingHeaders`.
 */
class TripBillingHeadersSearch extends TripBillingHeaders
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'prepared_by', 'noted_by', 'user_id', 'client_id', 'status', 'is_with_others', 'is_deleted'], 'integer'],
            [['billing_no', 'created_at', 'updated_at'], 'safe'],
            [['total_amount'], 'number'],
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
        $query = TripBillingHeaders::find();

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
            'total_amount' => $this->total_amount,
            'prepared_by' => $this->prepared_by,
            'noted_by' => $this->noted_by,
            'user_id' => $this->user_id,
            'client_id' => $this->client_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'status' => $this->status,
            'is_with_others' => $this->is_with_others,
            'is_deleted' => $this->is_deleted,
        ]);

        $query->andFilterWhere(['like', 'billing_no', $this->billing_no]);

        return $dataProvider;
    }
}
