<?php

namespace application\models;

use application\core\Model;

class Test extends Model
{
    public function __construct()
    {
        $this->connect();
    }

    public function clearSettings() {
        $sql = "DROP DATABASE restaurant_helper;";
        $this->db->query($sql);
        file_put_contents('application/config/settings.json', '');
    }
}