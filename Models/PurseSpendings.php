<?php

namespace jarrus90\UserPurse\Models;

use Yii;
use yii\db\ActiveRecord;

class PurseSpendings extends ActiveRecord {

    const EVENT_AFTER_SPEND = 'userPurseSpendSuccess';
    
    /** @inheritdoc */
    public static function tableName() {
        return '{{%user_purse_spendings}}';
    }

    public function behaviors() {
        return [
            [
                'class' => \yii\behaviors\TimestampBehavior::className(),
            ],
        ];
    }

    public function scenarios() {
        $scenarios = parent::scenarios();
        $scenarios['search'] = ['user_id', 'amount', 'description'];
        return $scenarios;
    }

    public function rules() {
        return [
            'required' => [['user_id', 'amount'], 'required', 'on' => [self::SCENARIO_DEFAULT]],
            'number' => [['user_id', 'amount'], 'number'],
            'safe' => [['description'], 'safe']
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
            $query->andFilterWhere(['user_id' => $this->user_id]);
            $query->andFilterWhere(['like', 'description', $this->description]);
        }
        return $dataProvider;
    }

    public function getPurse() {
        return $this->hasOne(Purse::className(), ['user_id' => 'user_id']);
    }

    public function afterSave($insert, $changedAttributes) {
        $purse = $this->purse;
        $purse->purse_amount -= $this->amount;
        if($purse->save()) {
            $this->trigger(self::EVENT_AFTER_SPEND, new PurseEvent([
                'purse' => $purse
            ]));
        } else {
            throw new \yii\base\Exception('Error while updating purse amount');
        }
        parent::afterSave($insert, $changedAttributes);
    }

}
