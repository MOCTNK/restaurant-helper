<?php

namespace application\models;
use application\core\Model;
use application\lib\Loader;
use PDO;
use PDOException;

class Installer extends Model 
{
    private $link;
	private $nameSteps;
    private $settings = array();
	public $step;

	public function __construct() {
		$this->nameSteps = [
			'Подключение к базе данных',
			'Создание базы данных',
			'Создание главного Админа'
		];

	}

	public function getNameSteps() {
		return $this->nameSteps;
	}

	public function getView() {
        $path = 'application/views/installer/';
        switch ($this->step) {
            case 1:
                return file_get_contents($path.'windowFormDB.php');
                break;
            case 2:
                return file_get_contents($path.'windowCreateDB.php');
                break;
            case 3:
                return file_get_contents($path.'windowFormAdmin.php');
                break;
        }
    }

    public function getViewStep($post) {
        $this->step = $post['step'];
        $result = array();
        $result['message'] = 'Успешно!';
        $result['success'] = true;
        if($this->step == 1 && Loader::checkSettings()) {
            $result['next'] = true;
        } elseif ($this->step == 2 && Loader::checkDB()) {
            $result['next'] = true;
        } elseif ($this->step == 3 && Loader::checkHeadAdmin()) {
            $result['next'] = true;
        } else {
            $result['view'] = $this->getView();
        }
        exit(json_encode($result));
    }

    public function checkStep($post) {
        $this->step = $post['step'];
    	switch ($this->step) {
            case 1:
                $this->checkFormDB($post);
                //exit(json_encode($post));
                break;
            case 2:
                $this->checkCreateDB($post);
                //exit("step2");
                break;
            case 3:
                $this->checkFormAdmin($post);
                //exit("step3");
                break;
        }
    }

    private function checkFormDB($post) {
    	$result = array();
    	if($post['action'] == 'formBD') {
            if(isset($post['form']['db_host']) && $post['form']['db_host'] != null
                && isset($post['form']['db_user']) && $post['form']['db_user'] != null
                && isset($post['form']['db_password']) && $post['form']['db_password'] != null) {
                try{  
                    $this->link = new PDO('mysql:host='.$post['form']['db_host'], $post['form']['db_user'], $post['form']['db_password']);
                    $this->settings['db']['host'] = $post['form']['db_host'];
                    $this->settings['db']['user'] = $post['form']['db_user'];
                    $this->settings['db']['password'] = $post['form']['db_password'];
                    $this->settings['db']['db_name'] = "";
                    Loader::setSettings($this->settings);
                    $result['message'] = 'Успешно!';
                    $result['success'] = true;
                }
                catch(PDOException $e)
                {
                    $result['message'] = $e->getMessage();
                    $result['success'] = false;
                }
            } else {
                $result['message'] = "Заполнены не все поля!";
                $result['success'] = false;
            }
        }
        exit(json_encode($result));
    }

    private function checkCreateDB($post) {
        $result = array();
        if($post['action'] == 'createBD') {
            $this->settings = Loader::getSettings();
            $this->connect();
            try{
                $this->db->queryFile('application/lib/restaurant_helper.sql');
                $this->settings['db']['db_name'] = "restaurant_helper";
                Loader::setSettings($this->settings);
                $result['message'] = 'Успешно!';
                $result['success'] = true;
            }
            catch(PDOException $e)
            {
                $result['message'] = $e->getMessage();
                $result['success'] = false;
            }
        }
        exit(json_encode($result));
    }

    private function checkFormAdmin($post) {
        $result = array();
        if($post['action'] == 'formAdmin') {
            $this->settings = Loader::getSettings();
            $this->connect();
            if(isset($post['form']['admin_name']) && $post['form']['admin_name'] != null
                && isset($post['form']['admin_surname']) && $post['form']['admin_surname'] != null
                && isset($post['form']['admin_patronymic']) && $post['form']['admin_patronymic'] != null
                && isset($post['form']['admin_date_of_birth']) && $post['form']['admin_date_of_birth'] != null
                && isset($post['form']['admin_login']) && $post['form']['admin_login'] != null
                && isset($post['form']['admin_password']) && $post['form']['admin_password'] != null
                && isset($post['form']['admin_password_repeat']) && $post['form']['admin_password_repeat'] != null
            ) {
                $account = new Account();
                if($account->checkPassword($post['form']['admin_password'], $post['form']['admin_password_repeat'])) {
                    if(!$account->existLogin($post['form']['admin_login'])) {
                        $id_user = $account->createUser(
                            $post['form']['admin_name'],
                            $post['form']['admin_surname'],
                            $post['form']['admin_patronymic'],
                            $post['form']['admin_date_of_birth']
                        );
                        $id_account = $account->createAccount($id_user, $post['form']['admin_login'], $post['form']['admin_password']);
                        $sql = "INSERT INTO user_position (id_user, id_position) VALUES (:id_user, :id_position);";
                        $params = [
                            'id_user' => $id_user,
                            'id_position' => 1
                        ];
                        $this->db->query($sql, $params);
                        $result['message'] = "Успешно!";
                        $result['success'] = true;
                    } else {
                        $result['message'] = "Логин занят!";
                        $result['success'] = false;
                    }
                } else {
                    $result['message'] = "Пароль должен совпадать!";
                    $result['success'] = false;
                }
            } else {
                $result['message'] = "Заполнены не все поля!";
                $result['success'] = false;
            }
        }
        exit(json_encode($result));
    }
} 