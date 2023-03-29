<?php

namespace application\controllers;

use application\core\Controller;

class InstallerController extends Controller
{

    public function setupAction() {
        if(!empty($_POST)) {
            if(isset($_POST['action']) && $_POST['action'] == "getView") {
                $this->model->getViewStep($_POST);
            } else {
                $this->model->checkStep($_POST);
            }
        }
        $vars = [
            'nameSteps' => $this->model->getNameSteps()
        ];
        $this->view->render('Установщик', $vars);
    }

}