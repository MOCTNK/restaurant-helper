<?php

namespace application\lib;

use PDO;
class DataBase
{
    protected $link;
    public function __construct() {
        $settings = Loader::getSettings();
        $this->link = new PDO('mysql:host='.$settings['db']['host'].';dbname='.$settings['db']['db_name'], $settings['db']['user'], $settings['db']['password']);
    }

    public function query($sql, $params = []) {
        $stmt = $this->link->prepare($sql);
        if(!empty($params)) {
            foreach($params as $key => $val) {
                $stmt->bindValue(':'.$key, $val);
            }
        }
        $stmt->execute();
        return $stmt;
    }

    public function queryFetch($sql, $params = []) {
        return $this->query($sql, $params)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function queryFile($file) {
        if(file_exists($file)) {
            return $this->link->exec(file_get_contents($file));
        }
        return null;
    }

    public function rowCount($sql, $params = []) {
        return $this->query($sql, $params)->rowCount();
    }

}