<?php

namespace jarrus90\UserPurse\controllers;

class FrontController extends \yii\web\Controller {

    public function actionRefill($amount) {
        return $this->render('refill',[
            'amount' => $amount
        ]);
    }
}
