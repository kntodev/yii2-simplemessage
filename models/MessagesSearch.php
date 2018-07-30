<?php

namespace common\modules\simplemessage\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use kntodev\simplemessage\models\Messages;

/**
 * MessageSearch represents the model behind the search form about `common\models\Message`.
 */
class MessagesSearch extends Messages
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'readed', 'sender', 'receiver', 'created_at'], 'integer'],
            [['subject', 'content', 'route'], 'safe'],
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
        $query = Messages::find();

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
            'sender' => $this->sender,
            'receiver' => $this->receiver,
            'created_at' => $this->created_at,
            'readed' => $this->readed,
        ]);

        $query->andFilterWhere(['like', 'subject', $this->subject])
            ->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'route', $this->route]);

        return $dataProvider;
    }
}
