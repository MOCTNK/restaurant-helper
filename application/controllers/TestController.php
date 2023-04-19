<?php

namespace application\controllers;

use application\core\Controller;
use application\modules\template\AdministratorModule;


class TestController extends Controller
{
    public function indexAction() {
        //$administrator = new AdministratorModule();
        //$administrator->init();
        $this->model->clearSettings();
        //$this->view->render('Тест');
    }
}