<?php

namespace application\controllers;
use application\core\Controller;
use application\core\View;
use application\lib\DataBase;
use application\lib\Loader;

class AccountController extends Controller
{
    public function loginAction() {
        if(!Loader::check()) {
            View::redirect('/installer/setup');
        }
        if(!empty($_POST)) {
            if(isset($_POST['action']) && $_POST['action'] == "login") {
                $this->model->login($_POST);
            }
        }
        $this->view->render('Авторизация');
    }

    public function logoutAction() {
        if(!Loader::check()) {
            View::redirect('/installer/setup');
        }
        $this->model->logout();
        View::redirect('/');
    }
}