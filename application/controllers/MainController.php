<?php

namespace application\controllers;

use application\core\Controller;
use application\core\View;
use application\lib\Loader;

class MainController extends Controller
{
    public function indexAction() {
        if(Loader::check()) {
            View::redirect('/account/login');
        } else {
            View::redirect('/installer/setup');
        }
    }
}