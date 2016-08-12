<?php

namespace jarrus90\UserPurse\Models;

use Yii;
use jarrus90\Core\Models\Model;

class PurseRefillForm extends Model {

    protected $_purse;
    public $amount;
    public $currency;
    public $source = 'internal';
    public $description = '';

    public function formName() {
        return 'purse-refill';
    }

    public function attributeLabels() {
        return [
            'amount' => Yii::t('user-purse', 'Amount'),
            'currency' => Yii::t('user-purse', 'Currency'),
            'source' => Yii::t('user-purse', 'Refill source'),
            'description' => Yii::t('user-purse', 'Description'),
        ];
    }

    public function rules() {
        return [
            'required' => [['amount', 'currency'], 'required'],
            'safe' => [['source', 'description'], 'safe']
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
        $defaultCurrency = \jarrus90\Currencies\Models\Currency::findOne(['is_default' => true]);
        if ($defaultCurrency) {
            $this->currency = $defaultCurrency->code;
        }
    }

    public function save() {
        if ($this->validate()) {
            return $this->_purse->refill($this->amount, $this->currency, $this->source, $this->description);
        }
        return false;
    }

}
