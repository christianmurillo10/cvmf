<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Vehicles;

/**
 * VehiclesSearch represents the model behind the search form of `backend\models\Vehicles`.
 */
class VehiclesSearch extends Vehicles
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'year_model', 'user_id', 'global_brand_id', 'vehicle_type_id', 'vehicle_owner_id', 'owned_type', 'is_with_plate', 'is_brand_new', 'status', 'is_deleted'], 'integer'],
            [['plate_no', 'temporary_plate_no', 'model', 'created_at', 'updated_at'], 'safe'],
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
        $query = Vehicles::find();

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
            'year_model' => $this->year_model,
            'user_id' => $this->user_id,
            'global_brand_id' => $this->global_brand_id,
            'vehicle_type_id' => $this->vehicle_type_id,
            'vehicle_owner_id' => $this->vehicle_owner_id,
            'owned_type' => $this->owned_type,
            'is_with_plate' => $this->is_with_plate,
            'is_brand_new' => $this->is_brand_new,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'is_deleted' => $this->is_deleted,
        ]);

        $query->andFilterWhere(['like', 'plate_no', $this->plate_no])
            ->andFilterWhere(['like', 'temporary_plate_no', $this->temporary_plate_no])
            ->andFilterWhere(['like', 'model', $this->model]);

        return $dataProvider;
    }
}
