<?php

namespace application\controllers;
use application\core\Controller;
use application\lib\DataBase;

class AccountController extends Controller
{
    public function loginAction() {
        if(!empty($_POST)) {
            if(isset($_POST['action']) && $_POST['action'] == "login") {
                $this->model->login($_POST);
            }
        }
        $this->view->render('Авторизация');
    }

}