<?php

namespace application\controllers;

use application\core\Controller;
use application\core\View;

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

    public function saveFileAction() {
        if(isset($_FILES['avatar'])) {
            if(move_uploaded_file($_FILES['avatar']['tmp_name'], realpath(dirname(__FILE__)).'/../../public/resources/'.$this->route['directory'].'/'.$this->route['file_name'])) {
                exit(true);
            } else {
                exit(false);
            }
        } else {
            View::errorCode(404);
        }
    }

}