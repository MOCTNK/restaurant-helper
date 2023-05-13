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

    public function disable()
    {
        $sql = "DELETE positions FROM positions JOIN module_position ON positions.id = module_position.id_position WHERE module_position.id_module = :id_module;";
        $params = [
            'id_module' => $this->getIdModule($this->name)
        ];
        $this->db->query($sql, $params);
        $sql = "DELETE FROM modules WHERE id = :id_module;";
        $this->db->query($sql, $params);
    }

    public function action($post, $accountData, $restaurantData = []) {
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

    protected function addPosition($name, $codeName)
    {
        $sql = "INSERT INTO positions (name, code_name, is_admin) VALUES (:name, :code_name, :is_admin);";
        $params = [
            'name' => $name,
            'code_name' => $codeName,
            'is_admin' => 0
        ];
        $this->db->query($sql, $params);
        $sql = "SELECT id FROM positions WHERE code_name = :code_name;";
        $params = [
            'code_name' => $codeName
        ];
        $idPosition = $this->db->queryFetch($sql, $params)[0]['id'];
        $sql = "INSERT INTO module_position (id_module, id_position) VALUES (:id_module, :id_position);";
        $params = [
            'id_module' => $this->getIdModule($this->name),
            'id_position' => $idPosition
        ];
        $this->db->query($sql, $params);
    }

    public function select($dbName, $columns = [], $params = [], $equality = true, $isOR = true)
    {
        if(!$this->checkTables($dbName)) {
            return [];
        }
        $sql = "SELECT * FROM ".$dbName;
        if(!empty($columns) && !empty($params)) {
            $sql .= " WHERE ";
            for($i = 0; $i < count($columns); $i++) {
                if($i != 0) {
                    $sql .= $isOR ? " OR " : " AND ";
                }
                if($this->checkColumns($dbName, $columns[$i])) {
                    if(array_key_exists($columns[$i], $params)) {
                        if(is_array($params[$columns[$i]])) {
                            for($j = 0; $j < count($params[$columns[$i]]); $j++) {
                                if($i == 0 && $j != 0) {
                                    $sql .= $isOR ? " OR " : " AND ";
                                } elseif ($j != 0) {
                                    $sql .= $isOR ? " OR " : " AND ";
                                }
                                $params[$columns[$i].($j+1)] = $params[$columns[$i]][$columns[$i].($j+1)];
                                $sql .= $columns[$i]." ".($equality ? "=" : "<>")." :".$columns[$i].($j+1);
                            }
                            unset($params[$columns[$i]]);
                        } else {
                            $sql .= $columns[$i]." ".($equality ? "=" : "<>")." :".$columns[$i];
                        }
                    } else {
                        return [];
                    }
                } else {
                    return [];
                }
            }
            $sql .= ";";
            return $this->db->queryFetch($sql, $params);
        }
        $sql .= ";";
        return $this->db->queryFetch($sql);
    }

    protected function insert($dbName, $columns, $params)
    {
        if(!empty($columns) && !empty($params)) {
            if(!$this->checkTables($dbName)) {
                return;
            }
            $sql = "INSERT INTO ".$dbName." (";
            for ($i = 0; $i < count($columns); $i++) {
                if($i != 0) {
                    $sql .= ", ";
                }
                if($this->checkColumns($dbName, $columns[$i])) {
                    $sql .= $columns[$i];
                } else {
                    return;
                }
            }
            $sql .= ") VALUES (";
            for ($i = 0; $i < count($columns); $i++) {
                if($i != 0) {
                    $sql .= ", ";
                }
                $sql .= ":".$columns[$i];
            }
            $sql .= ");";
            $this->db->query($sql, $params);
        }
        $sql = "SELECT id FROM ".$dbName." WHERE ";
        for ($i = 0; $i < count($columns); $i++) {
            if($i != 0) {
                $sql .= " AND ";
            }
            $sql .= $columns[$i]." = :".$columns[$i];
        }
        $sql .= " ORDER BY id DESC LIMIT 1;";
        return $this->db->queryFetch($sql, $params)[0]['id'];
    }

    protected function update($dbName, $id, $columns, $params)
    {
        if(!empty($columns) && !empty($params)) {
            if(!$this->checkTables($dbName)) {
                return [];
            }
            $sql = "UPDATE ".$dbName." SET ";
            for ($i = 0; $i < count($columns); $i++) {
                if($i != 0) {
                    $sql .= ", ";
                }
                if($this->checkColumns($dbName, $columns[$i])) {
                    $sql .= $columns[$i]." = :".$columns[$i];
                } else {
                    return;
                }
            }
            $sql .= " WHERE id = ".(int)$id.";";
            $this->db->query($sql, $params);
        }
    }

    protected function delete($dbName, $columns, $params, $equality = true, $isOR = true)
    {
        if(!empty($columns)) {
            if(!$this->checkTables($dbName)) {
                return [];
            }
            $sql = "DELETE FROM ".$dbName." WHERE ";
            for ($i = 0; $i < count($columns); $i++) {
                if($i != 0) {
                    $sql .= $isOR ? " OR " : " AND ";
                }
                if($this->checkColumns($dbName, $columns[$i])) {
                    if(array_key_exists($columns[$i], $params)) {
                        if(is_array($params[$columns[$i]])) {
                            for($j = 0; $j < count($params[$columns[$i]]); $j++) {
                                if($i == 0 && $j != 0) {
                                    $sql .= $isOR ? " OR " : " AND ";
                                } elseif ($j != 0) {
                                    $sql .= $isOR ? " OR " : " AND ";
                                }
                                $params[$columns[$i].($j+1)] = $params[$columns[$i]][$columns[$i].($j+1)];
                                $sql .= $columns[$i]." ".($equality ? "=" : "<>")." :".$columns[$i].($j+1);
                            }
                            unset($params[$columns[$i]]);
                        } else {
                            $sql .= $columns[$i]." ".($equality ? "=" : "<>")." :".$columns[$i];
                        }
                    } else {
                        return;
                    }
                } else {
                    return;
                }
            }
            $sql .= ";";
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

    private function checkColumns($dbName, $name)
    {
        $columns = $this->showColumns($dbName);
        for($i = 0; $i < count($columns); $i++) {
            if($columns[$i]['Field'] == $name) {
                return true;
                break;
            }
        }
        return false;
    }

    protected function getView($path, $vars = []) {
        extract($vars);
        ob_start();
        require 'application/modules/'.$this->name.'/views/'.$path;
        return ob_get_clean();
    }


}