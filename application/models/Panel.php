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

    public function getRestaurantById($id) {
        $sql = "SELECT * FROM restaurants WHERE id = :id;";
        $params = [
            'id' => $id
        ];
        return $this->db->queryFetch($sql, $params)[0];
    }

    public function getUserName($account) {
        return $account['surname']." ".$account['name']." ".$account['patronymic'];
    }

}