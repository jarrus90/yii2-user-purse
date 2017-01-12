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

    public function refill($amount, $currency, $source = '', $description = '', $status = PurseRefill::STATUS_NEW) {
        $amountConverted = Currency::convert($amount, $currency);
        $refill = new PurseRefill();
        $refill->setAttributes([
            'user_id' => $this->user_id,
            'amount' => $amountConverted,
            'source' => $source,
            'description' => $description,
            'status' => $status
        ]);
        if($refill->save()) {
            return $refill;
        } else {
            return false;
        }
    }

    public function spend($amount, $currency, $description = '', $force = false) {
        if ($force || $this->canSpend($amount)) {
            $amountConverted = Currency::convert($amount, $currency);
            $spend = new PurseSpendings();
            $spend->setAttributes([
                'user_id' => $this->user_id,
                'amount' => $amountConverted,
                'description' => $description
            ]);
            if($spend->save()) {
                return $spend;
            }
        }
        return false;
    }

}
