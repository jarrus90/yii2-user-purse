<?php

namespace jarrus90\UserPurse\Widgets;

use Yii;
use yii\base\Widget;
use yii\helpers\Url;
use yii\base\InvalidConfigException;

use jarrus90\UserPurse\Models\PurseRefillForm;

class SmallForm extends Widget {

    public $purse;

    public function init() {
        parent::init();
        if ($this->purse === null) {
            throw new InvalidConfigException('You should set ' . __CLASS__ . '::$purse');
        }
    }

    public function run() {
        $formRefill = Yii::createObject([
                    'class' => PurseRefillForm::className(),
                    'purse' => $this->purse
        ]);
        return $this->render('@jarrus90/UserPurse/views/widgets/small-form', [
                    'formRefill' => $formRefill,
                    'purse' => $this->purse
        ]);
    }

}
