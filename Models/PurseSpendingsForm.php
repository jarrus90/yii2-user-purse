<?php

namespace jarrus90\UserPurse\Models;

use Yii;
use jarrus90\Core\Models\Model;

class PurseSpendingsForm extends Model {

    protected $_purse;
    public $amount;
    public $currency;
    public $description = '';

    public function formName() {
        return 'purse-spend';
    }

    public function attributeLabels() {
        return [
            'amount' => Yii::t('user-purse', 'Amount'),
            'currency' => Yii::t('currency', 'Currency'),
            'description' => Yii::t('user-purse', 'Description'),
        ];
    }

    public function rules() {
        return [
            'required' => [['amount', 'currency'], 'required'],
            'safe' => [['description'], 'safe']
        ];
    }

    public function setPurse($purse) {
        $this->_purse = $purse;
    }

    public function init() {
        parent::init();
        if (!$this->_purse) {
            throw new \yii\base\InvalidConfigException('Purse must be set');
        }
    }

    public function save() {
        if ($this->validate()) {
            return $this->_purse->spend($this->amount, $this->currency, $this->description);
        }
        return false;
    }

}
