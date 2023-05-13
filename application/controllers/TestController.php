<?php

namespace application\controllers;

use application\core\Controller;
use application\models\Account;
use application\modules\administrator\AdministratorModule;


class TestController extends Controller
{
    public function indexAction() {
        //$administrator = new AdministratorModule();
        //$administrator->init();
        //$account = new Account();
        //debug($administrator->getNotRestaurantEmployees(1));
        $this->model->clearSettings();
        //$this->view->render('Тест');
    }
}