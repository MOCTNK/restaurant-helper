<?php

namespace application\controllers;

use application\core\Controller;
use application\core\View;
use application\lib\Loader;
use application\models\Account;

class MainController extends Controller
{
    private $account;

    public function indexAction() {
        if(!Loader::check()) {
            View::redirect('/installer/setup');
        }
        $this->account = new Account();
        if(!$this->account->isLogin()) {
            View::redirect('/account/login');
        } else {
            View::redirect('/panel/employee');
        }
    }
}