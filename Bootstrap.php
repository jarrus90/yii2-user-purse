<?php

namespace jarrus90\UserPurse;

use Yii;
use yii\i18n\PhpMessageSource;
use yii\base\BootstrapInterface;
use yii\console\Application as ConsoleApplication;

/**
 * Bootstrap class registers module and application component
 */
class Bootstrap implements BootstrapInterface {

    /**
     * Bootstrap method to be called during application bootstrap stage.
     * @param \yii\base\Application $app the application currently running
     */
    public function bootstrap($app) {
        /**
         * @var $module Module 
         */
        $userModuleIsset = ($app->hasModule('user') && ($moduleUser = $app->getModule('user')) instanceof \jarrus90\User\Module);
        if ($userModuleIsset && $app->hasModule('user-purse') && ($module = $app->getModule('user-purse')) instanceof Module) {
            if (!isset($app->get('i18n')->translations['user-purse*'])) {
                $app->get('i18n')->translations['user-purse*'] = [
                    'class' => PhpMessageSource::className(),
                    'basePath' => __DIR__ . '/messages',
                    'sourceLanguage' => 'en-US'
                ];
            }
            if (!$app instanceof ConsoleApplication) {
                $module->controllerNamespace = 'jarrus90\UserPurse\Controllers';
                $rule = Yii::createObject([
                            'class' => 'yii\web\GroupUrlRule',
                            'prefix' => $module->urlPrefix,
                            'routePrefix' => 'user-purse',
                            'rules' => $module->urlRules,
                ]);
                $app->urlManager->addRules([$rule], false);
            }
            $app->params['yii.migrations'][] = '@jarrus90/UserPurse/migrations/';
        }
    }

}
