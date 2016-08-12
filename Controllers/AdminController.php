<?php

namespace jarrus90\UserPurse\Controllers;

use Yii;
use jarrus90\User\UserFinder;
use jarrus90\UserPurse\Models\Purse;
use jarrus90\UserPurse\Models\PurseRefill;
use jarrus90\UserPurse\Models\PurseSpendings;
use jarrus90\UserPurse\Models\PurseRefillForm;
use jarrus90\UserPurse\Models\PurseSpendingsForm;

class AdminController extends \jarrus90\Admin\Web\Controllers\AdminController {

    use \jarrus90\Core\Traits\AjaxValidationTrait;
    /** @var UserFinder */
    protected $userFinder;

    /**
     * @param string  $id
     * @param BaseModule $module
     * @param UserFinder  $finder
     * @param array   $config
     */
    public function __construct($id, $module, UserFinder $finder, $config = []) {
        $this->userFinder = $finder;
        parent::__construct($id, $module, $config);
    }

    public function actionUser($id) {
        $user = $this->findModel($id);
        $purse = Purse::findOne(['user_id' => $id]);
        $form = Yii::createObject([
            'class' => PurseRefillForm::className(),
            'purse' => $purse
        ]);
        return $this->render('user', [
                    'user' => $user,
                    'purse' => $purse,
                    'formRefill' => $form
        ]);
    }

    public function actionRefill($id, $amount) {
        $user = $this->findModel($id);
        $purse = Purse::findOne(['user_id' => $id]);
        $this->performAjaxValidation();
        return $this->render('user', [
                    'user' => $user,
                    'purse' => $purse
        ]);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param int $id
     *
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        $user = $this->userFinder->findUserById($id);
        if ($user === null) {
            throw new NotFoundHttpException('The requested page does not exist');
        }

        return $user;
    }

}
