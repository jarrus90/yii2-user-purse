<?php

namespace jarrus90\UserPurse\Widgets;

use Yii;
use yii\base\Widget;
use yii\base\InvalidConfigException;
use jarrus90\UserPurse\Models\PurseRefillFormSmall;

class SmallForm extends Widget {

    public $purse;
    public $action = ['/user-purse/front/refill'];

    public function init() {
        parent::init();
        if ($this->purse === null) {
            throw new InvalidConfigException('You should set ' . __CLASS__ . '::$purse');
        }
    }

    public function run() {
        $formRefill = Yii::createObject([
                    'class' => PurseRefillFormSmall::className(),
                    'purse' => $this->purse
        ]);
        return $this->render('@jarrus90/UserPurse/views/widgets/small-form', [
                    'formRefill' => $formRefill,
                    'purse' => $this->purse,
                    'action' => $this->action
        ]);
    }

}
