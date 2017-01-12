<?php

namespace jarrus90\UserPurse\Models;

use Yii;
use yii\db\ActiveRecord;
use jarrus90\UserPurse\Models\Purse;
class PurseRefill extends ActiveRecord {

    const EVENT_AFTER_REFILL = 'userPurseRefillSuccess';

    const STATUS_NEW = 0;
    const STATUS_PENDING = 1;
    const STATUS_PROCESS = 2;
    const STATUS_CANCELED = 3;
    const STATUS_SUCCESS = 4;
    const STATUS_FAIL = 5;

    public static $statusesFinal = [
        self::STATUS_CANCELED,
        self::STATUS_SUCCESS,
        self::STATUS_FAIL
    ];
    /** @inheritdoc */
    public static function tableName() {
        return '{{%user_purse_refill}}';
    }

    public function rules() {
        return [
            'required' => [['user_id', 'amount', 'created_at'], 'required'],
            'safe' => [['source', 'description', 'status'], 'safe'],
            'statusRange' => ['status', 'in', 'range' => [
                self::STATUS_NEW,
                self::STATUS_PENDING,
                self::STATUS_PROCESS,
                self::STATUS_CANCELED,
                self::STATUS_SUCCESS,
                self::STATUS_FAIL
            ]],
            'statusActive' => ['status', function($attribute, $params){
                if(in_array($this->getOldAttribute($attribute), self::$statusesFinal)) {
                    $this->addError($attribute, Yii::t('user-purse', 'Payment is finished and locked for update'));
                }
            }]
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

    public function getPurse() {
        return $this->hasOne(Purse::className(), ['user_id' => 'user_id']);
    }

    public function getIsFinished() {
        return in_array($this->status, self::$statusesFinal);
    }

    public function afterSave($insert, $changedAttributes) {
        if($this->status == self::STATUS_SUCCESS) {
            $purse = $this->purse;
            $purse->purse_amount += $this->amount;
            if($purse->save()) {
                $this->trigger(self::EVENT_AFTER_REFILL, new PurseEvent([
                    'purse' => $purse
                ]));
            } else {
                throw new \yii\base\Exception('Error while updating purse amount');
            }
        }
        parent::afterSave($insert, $changedAttributes);
    }
}
