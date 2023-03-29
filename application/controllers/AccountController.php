<?php

namespace application\controllers;
use application\core\Controller;
use application\lib\DataBase;

class AccountController extends Controller
{
    public function loginAction() {
        $this->view->render('Авторизация');
    }

}