<?php

namespace application\controllers;

use application\core\Controller;

class TestController extends Controller
{
    public function indexAction() {
        $this->model->clearSettings();
        $this->view->render('Тест');
    }
}