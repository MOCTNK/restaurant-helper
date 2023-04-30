<?php
namespace application\modules\administrator;
use application\core\Module;
class AdministratorModule extends Module
{
    public function __construct() {
        parent::__construct();
        $this->name = 'administrator';
        $this->about = 'Добавляет функционал для администратора.';
        $this->version = '0.1';
        $this->author = 'Мостовой Даниил';
        $this->descriptionMenuItemEmployee = [
            'manager_users' => [
                'color' => 'white',
                'is_admin' => true
            ],
            'manager_accounts' => [
                'color' => 'white',
                'is_admin' => true
            ]
        ];
    }

    public function init()
    {
        parent::init();
        $this->addMenuItemAdmin('Сотрудники', 'employees');
        $this->addMenuItemEmployee('Менеджер пользователей', 'manager_users');
        $this->addMenuItemEmployee('Менеджер аккаунтов', 'manager_accounts');
    }

    public function action($post)
    {
        if(isset($post['action'])) {
            switch ($post['action']) {
                case 'getUsersList':
                    $this->actionGetUserList();
                    break;
                case 'getWindowFormAddUser':
                    $this->actionGetWindowForm('windowForm');
                    break;
                case 'getWindowFormEditUser':
                    $this->actionGetWindowForm('windowFormEditUser', $post['vars']);
                    break;
                case 'getWindowFormDeleteUser':
                    $this->actionGetWindowForm('windowFormDeleteUser', $post['vars']);
                    break;
                case 'createUser':
                    $this->actionCreateUser($post['form']);
                    break;
                case 'editUser':
                    $this->actionEditUser($post['form']);
                    break;
                default:
                    $result = array();
                    $result['message'] = "Неуказано действие!";
                    $result['success'] = false;
                    exit(json_encode($result));
            }
        }
    }

    private function actionGetUserList() {
        $result = array();
        $result['message'] = "Успешно!";
        $result['success'] = true;
        $result['data'] = $this->getUsersList();
        exit(json_encode($result));
    }

    private function actionGetWindowForm($action, $data = []) {
        $result = array();
        $result['message'] = "Успешно!";
        $result['success'] = true;
        $vars = [
            'data' => $data
        ];
        $result['view'] = $this->getView('employee/manager_users/'.$action.'.php', $vars);
        exit(json_encode($result));
    }

    private function actionCreateUser($form) {
        $result = array();
        if(isset($form['name']) && $form['name'] != null
            && isset($form['surname']) && $form['surname'] != null
            && isset($form['patronymic']) && $form['patronymic'] != null
            && isset($form['date_of_birth']) && $form['date_of_birth'] != null
        ) {
            $this->account->createUser(
                $form['name'],
                $form['surname'],
                $form['patronymic'],
                $form['date_of_birth'],
                (isset($form['avatar']) ? $form['avatar'] : 'avatar_default.png')
            );
            $result['message'] = "Успешно!";
            $result['success'] = true;
        } else {
            $result['message'] = "Заполнены не все поля!";
            $result['success'] = false;
        }
        exit(json_encode($result));
    }

    private function actionEditUser($form) {
        $result = array();
        if(isset($form['name']) && $form['name'] != null
            && isset($form['surname']) && $form['surname'] != null
            && isset($form['patronymic']) && $form['patronymic'] != null
            && isset($form['date_of_birth']) && $form['date_of_birth'] != null
        ) {
            $this->editUser(
                $form['id'],
                $form['name'],
                $form['surname'],
                $form['patronymic'],
                $form['date_of_birth'],
                (isset($form['avatar']) ? $form['avatar'] : 'avatar_default.png')
            );
            $result['message'] = "Успешно!";
            $result['success'] = true;
        } else {
            $result['message'] = "Заполнены не все поля!";
            $result['success'] = false;
        }
        exit(json_encode($result));
    }

    public function editUser($idUser, $name, $surname, $patronymic, $date_of_birth, $avatar) {
        $user = $this->getUserById($idUser);
        $params = [
            'name' => ($name != $user['name'] ? $name : $user['name']),
            'surname' => ($surname != $user['surname'] ? $surname : $user['surname']),
            'patronymic' => ($patronymic != $user['patronymic'] ? $patronymic : $user['patronymic']),
            'date_of_birth' => ($date_of_birth != $user['date_of_birth'] ? $date_of_birth : $user['date_of_birth']),
            'avatar' => ($avatar != 'avatar_default.png' && $avatar != $user['avatar'] ? $avatar : $user['avatar']),
            'date' => $user['date']
        ];
        $this->update('users', $params, $idUser);
    }

    public function getUserById($idUser) {;
       return $this->select('users', $idUser)[0];
    }
    private function getUsersList() {
        return $this->select('users');
    }

}