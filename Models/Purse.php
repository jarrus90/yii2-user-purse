<?php

namespace jarrus90\UserPurse\Models;

use Yii;
use yii\db\ActiveRecord;
use jarrus90\Currencies\Models\Currency;
use jarrus90\User\models\Profile;

class Purse extends Profile {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            'purseDecimal' => ['purse_amount', 'decimal'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios() {
        return [
            'default' => ['purse_amount'],
        ];
    }

    public function refill($amount, $currency, $source = '', $description = '') {
        $amountConverted = $this->currencyConvert($amount, $currency);
        $refill = new PurseRefill();
        $refill->setAttributes([
            'user_id' => $this->user_id,
            'refill_amount' => $amountConverted,
            'created_time' => time(),
            'source' => $source,
            'description' => $description,
        ]);
        if ($refill->save()) {
            $this->purse_amount += $amountConverted;
            return $this->save();
        }
    }

    public function spend($amount, $currency, $description = '') {
        $amountConverted = $this->currencyConvert($amount, $currency);
        $spend = new PurseSpendings();
        $spend->setAttributes([
            'user_id' => $this->user_id,
            'spent_amount' => $amountConverted,
            'created_time' => time(),
            'description' => $description,
        ]);
        if ($spend->save()) {
            $this->purse_amount -= $amountConverted;
            return $this->save();
        }
    }

    protected function currencyConvert($amount, $currency) {
        $currencyItem = Currency::getCurrency($currency);
        return $amount * $currencyItem->rate;
    }

}
