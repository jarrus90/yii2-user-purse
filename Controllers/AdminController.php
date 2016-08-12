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

    public $defaultAction = 'refills';
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

    public function actionRefills($id) {
        $user = $this->findModel($id);
        $purse = Purse::findOne(['user_id' => $id]);
        $formRefill = Yii::createObject([
            'class' => PurseRefillForm::className(),
            'purse' => $purse
        ]);
        $filterRefillsModel = new PurseRefill();
        return $this->render('refills', [
                    'user' => $user,
                    'purse' => $purse,
                    'formRefill' => $formRefill,
                    'filterRefillsModel' => $filterRefillsModel,
                    'dataRefillsProvider' => $filterRefillsModel->search(Yii::$app->request->get()),
        ]);
    }

    public function actionSpents($id) {
        $user = $this->findModel($id);
        $purse = Purse::findOne(['user_id' => $id]);
        $formSpent = Yii::createObject([
            'class' => PurseSpendingsForm::className(),
            'purse' => $purse
        ]);
        $filterSpentsModel = new PurseSpendings();
        return $this->render('spents', [
                    'user' => $user,
                    'purse' => $purse,
                    'formSpent' => $formSpent,
                    'filterSpentsModel' => $filterSpentsModel,
                    'dataSpentsProvider' => $filterSpentsModel->search(Yii::$app->request->get()),
        ]);
    }

    public function actionRefill($id) {
        $formRefill = Yii::createObject([
            'class' => PurseRefillForm::className(),
            'purse' => $this->findPurse($id)
        ]);
        $this->performAjaxValidation($formRefill);
        if ($formRefill->load(Yii::$app->request->post()) && $formRefill->save()) {
            Yii::$app->getSession()->setFlash('success', Yii::t('user-purse', 'Refill has been created'));
        }
        return $this->redirect(['refills', 'id' => $id]);
    }

    public function actionSpend($id) {
        $formSpend = Yii::createObject([
            'class' => PurseSpendingsForm::className(),
            'purse' => $this->findPurse($id)
        ]);
        $this->performAjaxValidation($formSpend);
        if ($formSpend->load(Yii::$app->request->post()) && $formSpend->save()) {
            Yii::$app->getSession()->setFlash('success', Yii::t('user-purse', 'Spend has been created'));
        }
        return $this->redirect(['spents', 'id' => $id]);
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

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param int $id
     *
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findPurse($id) {
        $purse = Purse::findOne(['user_id' => $id]);
        if ($purse === null) {
            throw new NotFoundHttpException('The requested purse does not exist');
        }
        return $purse;
    }

}
