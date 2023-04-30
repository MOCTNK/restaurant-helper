<?php

namespace application\core;

use application\lib\DataBase;
use application\models\Account;

abstract class Module
{
    protected $name;
    protected $about;
    protected $version;
    protected $author;
    protected $descriptionMenuItemEmployee;
    private $db;

    protected $account;

    public function __construct() {
        $this->db = new DataBase();
        $this->account = new Account();
    }

    public function info() {
        return [
            'name' => $this->name,
            'about' => $this->about,
            'version' => $this->version,
            'author' => $this->author
        ];
    }
    public function init()
    {
        $sql = "INSERT INTO modules (name) VALUES (:name);";
        $params = [
            'name' => $this->name
        ];
        $this->db->query($sql, $params);
    }

    public function action($post) {
        exit(json_encode($post));
    }

    public function getDescriptionMenuItemEmployee($item) {
        return $this->descriptionMenuItemEmployee[$item];
    }

    private function getIdModule($name)
    {
        $sql = "SELECT id FROM modules WHERE name = :name;";
        $params = [
            'name' => $name
        ];
        return $this->db->queryFetch($sql, $params)[0]['id'];
    }

    protected function addMenuItemAdmin($name, $action)
    {
        $sql = "INSERT INTO menu_admin (id_module, name, action) VALUES (:id_module, :name, :action);";
        $params = [
            'id_module' => $this->getIdModule($this->name),
            'name' => $name,
            'action' => $action
        ];
        $this->db->query($sql, $params);
    }

    protected function addMenuItemEmployee($name, $action)
    {
        $sql = "INSERT INTO menu_employee (id_module, name, action) VALUES (:id_module, :name, :action);";
        $params = [
            'id_module' => $this->getIdModule($this->name),
            'name' => $name,
            'action' => $action
        ];
        $this->db->query($sql, $params);
    }

    public function select($dbName, $id = null)
    {
        if(!$this->checkTables($dbName)) {
            return [];
        }
        $sql = "SELECT * FROM ".$dbName;
        if($id != null) {
            $sql .= " WHERE id = ".(int)$id.";";
        }
        return $this->db->queryFetch($sql);
    }

    protected function insert($dbName, $params)
    {
        $columns = $this->showColumns($dbName);
        if(!empty($columns)) {
            $sql = "INSERT INTO ".$dbName." (";
            for ($i = 0; $i < count($columns); $i++) {
                if($i != 0) {
                    $sql .= ", ";
                }
                $sql .= $columns[$i]['Field'];
            }
            $sql .= ") VALUES (";
            for ($i = 0; $i < count($columns); $i++) {
                if($i != 0) {
                    $sql .= ", ";
                }
                $sql .= ":".$columns[$i]['Field'];
            }
            $sql .= ");";
            $this->db->query($sql, $params);
        }
    }

    protected function update($dbName, $params, $id)
    {
        $columns = $this->showColumns($dbName);
        if(!empty($columns)) {
            $sql = "UPDATE ".$dbName." SET ";
            $check = false;
            for ($i = 0; $i < count($columns); $i++) {
                if($columns[$i]['Field'] == 'id') {
                    continue;
                }
                if($check) {
                    $sql .= ", ";
                }
                $sql .= $columns[$i]['Field']." = :".$columns[$i]['Field'];
                $check = true;
            }
            $sql .= " WHERE id = ".$id.";";
            $this->db->query($sql, $params);
        }
    }

    protected function showTables()
    {
        $sql = "SHOW TABLES;";
        return $this->db->queryFetch($sql);
    }

    private function checkTables($name)
    {
        $tables = $this->showTables();
        for($i = 0; $i < count($tables); $i++) {
            if($tables[$i]['Tables_in_restaurant_helper'] == $name) {
                return true;
                break;
            }
        }
        return false;
    }

    protected function showColumns($dbName)
    {
        if(!$this->checkTables($dbName)) {
            return [];
        }
        $sql = "SHOW COLUMNS FROM ".$dbName.";";
        return $this->db->queryFetch($sql);
    }

    protected function getView($path, $vars = []) {
        extract($vars);
        ob_start();
        require 'application/modules/'.$this->name.'/views/'.$path;
        return ob_get_clean();
    }

    protected function createUser($name, ) {

    }

}