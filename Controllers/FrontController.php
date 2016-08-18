<?php

namespace jarrus90\UserPurse\Controllers;

class FrontController extends \jarrus90\Core\Web\Controllers\FrontController {

    public function actionRefill($amount) {
        return $this->render('refill',[
            'amount' => $amount
        ]);
    }
}
