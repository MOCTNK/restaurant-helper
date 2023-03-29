<?php

namespace application\core;

use application\lib\DataBase;

abstract class Model
{
    public $db;

    public function __construct() {
        
    }

    public function connect() {
        $this->db = new DataBase();
    }
}