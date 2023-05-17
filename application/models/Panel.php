<?php

namespace application\models;

use application\core\Model;

class Panel extends Model
{
    public function __construct() {
        $this->connect();
    }

    public function addRestaurant($post) {
        $result = array();
        if(isset($post['form']['name']) && $post['form']['name'] != null) {
            $sql = "INSERT INTO restaurants (name, address, about, logo) VALUES (:name, :address, :about, :logo);";
            $params = [
                'name' => $post['form']['name'],
                'address' => $post['form']['address'] != null ? $post['form']['address'] : "",
                'about' => $post['form']['about'] != null ? $post['form']['about'] : "",
                'logo' => "logo_default.png"
            ];
            $this->db->query($sql, $params);
            $result['message'] = "Успешно!";
            $result['success'] = true;
        } else {
            $result['message'] = "Заполнены не все поля!";
            $result['success'] = false;
        }
        exit(json_encode($result));
    }

    public function getModulesListAction($post, $list, $view) {
        $result = array();
        $result['message'] = "Успешно!";
        $result['success'] = true;
        $result['list'] = $list;
        $result['view'] = $view;
        exit(json_encode($result));
    }

    public function initModule($post) {
        $result = array();
        $path = '\application\modules\\'.$_POST['module'].'\\'.ucfirst($_POST['module']).'Module';
        $module = new $path();
        $module->init();
        $result['message'] = "Успешно!";
        $result['success'] = true;
        exit(json_encode($result));
    }

    public function disableModule($post) {
        $result = array();
        $path = '\application\modules\\'.$_POST['module'].'\\'.ucfirst($_POST['module']).'Module';
        $module = new $path();
        $module->disable();
        $result['message'] = "Успешно!";
        $result['success'] = true;
        exit(json_encode($result));
    }

    public function getRestaurantsList() {
        $sql = "SELECT * FROM restaurants;";
        return $this->db->queryFetch($sql);
    }

    public function existRestaurant($id) {
        $sql = "SELECT id FROM restaurants WHERE id = :id;";
        $params = [
            'id' => $id
        ];
        return $this->db->rowCount($sql, $params) == 1;
    }

    public function existActionRestaurant($id) {
        $sql = "SELECT id FROM menu_admin WHERE id = :id;";
        $params = [
            'id' => $id
        ];
        return $this->db->rowCount($sql, $params) == 1;
    }

    public function existActionEmployee($id) {
        $sql = "SELECT id FROM menu_employee WHERE id = :id;";
        $params = [
            'id' => $id
        ];
        return $this->db->rowCount($sql, $params) == 1;
    }

    public function getRestaurantById($id) {
        $sql = "SELECT * FROM restaurants WHERE id = :id;";
        $params = [
            'id' => $id
        ];
        return $this->db->queryFetch($sql, $params)[0];
    }

    public function getModulesList() {
        $sql = "SELECT * FROM modules;";
        return $this->db->queryFetch($sql);
    }

    public function getModule($id) {
        $sql = "SELECT * FROM modules WHERE id = :id;";
        $params = [
            'id' => $id
        ];
        return $this->db->queryFetch($sql, $params)[0];
    }

    public function getModulesListDir() {
        $result = array();
        $moduleList = $this->getModulesList();
        $dir = opendir('application/modules');
        while($file = readdir($dir)) {
            if (is_dir('application/modules/'.$file) && $file != '.' && $file != '..') {
                $path = '\application\modules\\'.$file.'\\'.ucfirst($file).'Module';
                $module = new $path();
                $moduleInfo = $module->info();
                $moduleInfo['init'] = false;
                if(!empty($moduleList)) {
                    for($i = 0; $i < count($moduleList); $i++) {
                        if($moduleList[$i]['name'] == $file) {
                            $moduleInfo['init'] = true;
                            break;
                        }
                    }
                }
                array_push($result, $moduleInfo);

            }
        }
        return $result;
    }

    public function getMenuAdmin() {
        $sql = "SELECT * FROM menu_admin;";
        return $this->db->queryFetch($sql);
    }

    public function getMenuAdminById($id) {
        $sql = "SELECT * FROM menu_admin WHERE id = :id;";
        $params = [
            'id' => $id
        ];
        return $this->db->queryFetch($sql, $params)[0];
    }

    public function getUserName($account) {
        return $account['surname']." ".$account['name']." ".$account['patronymic'];
    }

    public function getMenuEmployee() {
        $sql = "SELECT menu_employee.id, menu_employee.name, menu_employee.action, menu_employee.id_module, modules.name AS module_name FROM menu_employee JOIN modules ON modules.id = menu_employee.id_module;";
        return $this->db->queryFetch($sql);
    }

    public function getMenuEmployeeById($id) {
        $sql = "SELECT * FROM menu_employee WHERE id = :id;";
        $params = [
            'id' => $id
        ];
        return $this->db->queryFetch($sql, $params)[0];
    }

    public function getMenuItemEmployee($is_admin, $positions) {
        $result = array();
        $menuEmployee = $this->getMenuEmployee();
        foreach ($menuEmployee as $item) {
            $path = '\application\modules\\'.$item['module_name'].'\\'.ucfirst($item['module_name']).'Module';
            $module = new $path();
            $description = $module->getDescriptionMenuItemEmployee($item['action']);
            if(isset($description['is_admin'])) {
                if($description['is_admin'] != $is_admin) {
                    continue;
                }
            }

            if(isset($description['position'])) {
                $tempResult = false;
                foreach ($positions as $position) {
                    if($description['position'] == $position['code_name']) {
                        $tempResult = true;
                        break;
                    }
                }
                if(!$tempResult) {
                    continue;
                }
            }
            array_push($result, $item);
        }
        return $result;
    }

    public function getWindowFormAddRestaurant($view) {
        $result = array();
        $result['message'] = "Успешно!";
        $result['success'] = true;
        $result['view'] = $view;
        exit(json_encode($result));
    }
}