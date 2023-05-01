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
                case 'deleteUser':
                    $this->actionDeleteUser($post['id']);
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
        $userList =  $this->getUsersList();
        $result['data'] = $userList;
        $vars = [
            'data' => $userList
        ];
        $result['view'] = $this->getView('employee/manager_users/table.php', $vars);
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
            && isset($form['login']) && $form['login'] != null
            && isset($form['password']) && $form['password'] != null
            && isset($form['password_repeat']) && $form['password_repeat'] != null
            && isset($form['is_admin']) && $form['is_admin'] != null
        ) {
            if($this->account->checkPassword($form['password'], $form['password_repeat'])) {
                if (!$this->account->existLogin($form['is_admin'])) {
                    $id_user = $this->account->createUser(
                        $form['name'],
                        $form['surname'],
                        $form['patronymic'],
                        $form['date_of_birth'],
                        (isset($form['avatar']) ? $form['avatar'] : 'avatar_default.png')
                    );
                    $id_account = $this->account->createAccount($id_user, $form['login'], $form['password']);
                    if($form['is_admin'] === true) {
                        $params = [
                            'id_user' => $id_user,
                            'id_position' => 2
                        ];
                        $this->insert('user_position', $params);
                    }
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

    private function actionDeleteUser($id) {
        $result = array();
        $this->deleteUser($id);
        $result['message'] = "Успешно!";
        $result['success'] = true;
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

    public function deleteUser($idUser) {
        $params = [
            'id' => $idUser
        ];
        $this->delete('users', 'id', $params);
    }

    public function getUserById($idUser) {
        $params = [
            'id' => $idUser
        ];
       return $this->select('users', 'id', $params)[0];
    }
    private function getUsersList() {
        $userList = $this->select('users');
        for ($i = 0; $i < count($userList); $i++) {
            $params = [
                'id_user' => $userList[$i]['id']
            ];
            $userList[$i]['is_admin'] = $this->account->isAdmin($userList[$i]['id']);
            $account = $this->select('accounts', 'id_user', $params)[0];
            $userList[$i]['login'] = $account['login'];
        }
        return $userList;
    }

}