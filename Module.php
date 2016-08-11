<?php

namespace jarrus90\UserPurse;

use Yii;
use yii\base\Module as BaseModule;

class Module extends BaseModule {

    /**
     * @var string The prefix for user module URL.
     *
     * @See [[GroupUrlRule::prefix]]
     */
    public $urlPrefix = 'user/purse';

    /** @var array The rules to be used in URL management. */
    public $urlRules = [
        '<action:[A-Za-z0-9_-]+>' => 'front/set'
    ];

}
