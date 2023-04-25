<?php

namespace application\core;

use application\lib\DataBase;

abstract class Module
{
    protected $name;
    protected $about;
    protected $version;
    protected $author;
    protected $descriptionMenuItemEmployee;
    private $db;

    public function __construct() {
        $this->db = new DataBase();
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


}