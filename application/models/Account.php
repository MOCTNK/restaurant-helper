<?php

namespace application\models;

use application\core\Model;

class Account extends Model
{
    public function __construct() {
        $this->connect();
    }

    public function login($post) {
        $result = array();
        if($post['action'] == "login") {
            if(isset($post['form']['login']) && $post['form']['login'] != null
             && isset($post['form']['password']) && $post['form']['password'] != null) {
                $login = $post['form']['login'];
                $password = $post['form']['password'];
                if($this->existUser($login, $password)) {
                    $id_user = $this->getUserId($login, $password);
                    $token = $this->createToken($login, $password);
                    $this->setToken($id_user, $token);
                    $this->setSession($token);
                    $result['message'] = $_SESSION['admin'];
                    $result['success'] = true;
                } else {
                    $result['message'] = "Неправильно введен логин или пароль!";
                    $result['success'] = false;
                }
            } else {
                $result['message'] = "Заполнены не все поля!";
                $result['success'] = false;
            }
        }
        exit(json_encode($result));
    }


    public function createToken($login, $password) {
        return SHA1(md5($login.date("Y-m-d H:i:s").$password));
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
        return $this->db->rowCount($sql, $params) == 1;
    }

    public function existUser($login, $password) {
        $sql = "SELECT id FROM accounts WHERE login = :login AND password = :password;";
        $params = [
            'login' => $login,
            'password' => SHA1($password)
        ];
        return $this->db->rowCount($sql, $params) == 1;
    }

    public function getUserId($login, $password) {
        $sql = "SELECT id FROM accounts WHERE login = :login AND password = :password;";
        $params = [
            'login' => $login,
            'password' => SHA1($password)
        ];
        return $this->db->queryFetch($sql, $params)[0]['id'];
    }

    public function setToken($id_user, $token) {
        $sql = "UPDATE accounts SET token = :token WHERE id_user = :id_user;";
        $params = [
            'id_user' => $id_user,
            'token' => $token
        ];
        $this->db->query($sql, $params);
    }

    public function setSession($token) {
        $_SESSION['admin'] = $token;
    }
}