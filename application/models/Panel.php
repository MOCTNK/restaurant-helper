<?php

namespace application\models;

use application\core\Model;

class Panel extends Model
{
    public function __construct() {
        $this->connect();
    }

    public function getUserName($account) {
        return $account['surname']." ".$account['name']." ".$account['patronymic'];
    }

    public function getAction() {
        return explode('/', trim($_SERVER['REQUEST_URI'], '/'))[1];
    }
}