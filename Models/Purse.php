<?php

namespace jarrus90\UserPurse\Models;

use Yii;
use jarrus90\Currencies\Models\Currency;
use jarrus90\User\models\Profile;

class Purse extends Profile {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            'purseDecimal' => ['purse_amount', 'number'],
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

    public function getAmount() {
        return Yii::$app->formatter->asDecimal($this->purse_amount, 2);
    }

    public function canSpend($amount) {
        return floatval($this->purse_amount) >= floatval($amount);
    }

    public function refill($amount, $currency, $source = '', $description = '') {
        $amountConverted = Currency::convert($amount, $currency);
        $refill = new PurseRefill();
        $refill->setAttributes([
            'user_id' => $this->user_id,
            'amount' => $amountConverted,
            'created_at' => time(),
            'source' => $source,
            'description' => $description,
        ]);
        if ($refill->save()) {
            $this->purse_amount += $amountConverted;
            return $this->save();
        }
    }

    public function spend($amount, $currency, $description = '', $force = false) {
        if ($force || $this->canSpend($amount)) {
            $amountConverted = Currency::convert($amount, $currency);
            $spend = new PurseSpendings();
            $spend->setAttributes([
                'user_id' => $this->user_id,
                'amount' => $amountConverted,
                'created_at' => time(),
                'description' => $description,
            ]);
            if ($spend->save()) {
                $this->purse_amount -= $amountConverted;
                return $this->save();
            }
        }
        return false;
    }

}
