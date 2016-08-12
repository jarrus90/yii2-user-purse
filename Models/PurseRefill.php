<?php

namespace jarrus90\UserPurse\Models;

use Yii;
use yii\db\ActiveRecord;

class PurseRefill extends ActiveRecord {

    /** @inheritdoc */
    public static function tableName() {
        return '{{%user_purse_refill}}';
    }

    public function rules() {
        return [
            'required' => [['user_id', 'amount', 'created_at'], 'required'],
            'safe' => [['source', 'description'], 'safe']
        ];
    }

    public function search($params) {
        $query = self::find();
        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC
                ]
            ]
        ]);
        if ($this->load($params) && $this->validate()) {
            
        }
        return $dataProvider;
    }

}
