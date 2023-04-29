<?php

namespace application\controllers;

use application\core\Controller;
use application\modules\administrator\AdministratorModule;


class TestController extends Controller
{
    public function indexAction() {
        $administrator = new AdministratorModule();
        //$administrator->init();
        debug($administrator->insert('users', []));
        //$this->model->clearSettings();
        $this->view->render('Тест');
    }
}