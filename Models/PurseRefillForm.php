<?php

namespace jarrus90\UserPurse\Models;

use Yii;
use jarrus90\Core\Models\Model;
use jarrus90\UserPurse\Models\PurseRefill;

class PurseRefillForm extends Model {

    protected $_purse;
    public $amount;
    public $currency;
    public $source = 'internal';
    public $description = '';
    public $status = PurseRefill::STATUS_NEW;

    public function formName() {
        return 'purse-refill';
    }

    public function attributeLabels() {
        return [
            'amount' => Yii::t('user-purse', 'Amount'),
            'currency' => Yii::t('user-purse', 'Currency'),
            'source' => Yii::t('user-purse', 'Refill source'),
            'description' => Yii::t('user-purse', 'Description'),
            'status' => Yii::t('user-purse', 'Status'),
        ];
    }

    public function rules() {
        return [
            'required' => [['amount', 'currency', 'status'], 'required'],
            'amountNumber' => ['amount', 'number', 'min' => 0],
            'safe' => [['source', 'description'], 'safe'],
            'statusRange' => ['status', 'in', 'range' => PurseRefill::$allStatuses],
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
            return $this->_purse->refill(str_replace(',', '.', $this->amount), $this->currency, $this->source, $this->description, $this->status);
        }
        return false;
    }

}
