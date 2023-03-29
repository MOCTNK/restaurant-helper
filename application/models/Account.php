<?php

namespace application\models;

use application\core\Model;

class Account extends Model
{
    public function __construct() {
        $this->connect();
    }

    public function createUser($name, $surname, $patronymic) {
        $sql = "INSERT INTO users (name, surname, patronymic, date) VALUES (:name, :surname, :patronymic, :date);";
        $params = [
            'name' => $name,
            'surname' => $surname,
            'patronymic' => $patronymic,
            'date' => date("Y-m-d H:i:s")
        ];
        $this->db->query($sql, $params);

        $sql = "SELECT id FROM users WHERE name = :name AND surname = :surname AND patronymic = :patronymic ORDER BY date DESC LIMIT 1;";
        $params = array_slice($params, 0, 3);
        return $this->db->queryFetch($sql, $params)[0]['id'];
    }

    public function createAccountByUser($id_user, $login, $password) {
        $sql = "INSERT INTO accounts (id_user, login, password, date) VALUES (:id_user, :login, :password, :date);";
        $params = [
            'id_user' => $id_user,
            'login' => $login,
            'password' => SHA1($password),
            'date' => date("Y-m-d H:i:s")
        ];
        $this->db->query($sql, $params);

        $sql = "SELECT id FROM accounts WHERE id_user = :id_user ORDER BY date DESC LIMIT 1;";
        $params = array_slice($params, 0, 1);
        return $this->db->queryFetch($sql, $params)[0]['id'];
    }

    public function createAccount($name, $surname, $patronymic, $login, $password) {
        $id_user = $this->createUser($name, $surname, $patronymic);
        $sql = "INSERT INTO accounts (id_user, login, password, date) VALUES (:id_user, :login, :password, :date);";
        $params = [
            'id_user' => $id_user,
            'login' => $login,
            'password' => SHA1($password),
            'date' => date("Y-m-d H:i:s")
        ];
        $this->db->query($sql, $params);

        $sql = "SELECT id FROM accounts WHERE id_user = :id_user ORDER BY date DESC LIMIT 1;";
        $params = array_slice($params, 0, 1);
        return $this->db->queryFetch($sql, $params)[0]['id'];
    }

    public function checkPassword($password, $passwordRepeat) {
        return $password === $passwordRepeat;
    }

    public function existLogin($login) {
        $sql = "SELECT id FROM accounts WHERE login = :login;";
        $params = [
            'login' => $login
        ];
        return $this->db->rowCount($sql, $params) > 0;
    }
}