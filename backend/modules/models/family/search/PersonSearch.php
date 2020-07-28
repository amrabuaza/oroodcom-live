<?php

namespace backend\modules\family\search;

use backend\modules\family\Person;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class PersonSearch extends Person
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'is_live', 'is_root', 'parent_id'], 'integer'],
            [['mother_name', 'name', 'nickname', 'birth_date',], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Person::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
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
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'mother_name', $this->mother_name])
            ->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}