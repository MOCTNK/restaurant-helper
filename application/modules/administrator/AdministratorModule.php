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
                'is_admin' => true
            ]
        ];
    }

    public function init()
    {
        parent::init();
        $this->addMenuItemAdmin('Сотрудники', 'employees');
        $this->addMenuItemEmployee('Менеджер пользователей', 'manager_users');
    }

    public function action($post, $accountData, $restaurantData = [])
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
                    $this->actionDeleteUser($post['id'], $accountData);
                    break;
                case 'getEmployeesList':
                    $this->actionGetEmployeesList($restaurantData['id']);
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
        $userList = $this->getUsersList();
        $result['data'] = $userList;
        $vars = [
            'data' => $userList
        ];
        $result['view'] = $this->getView('employee/manager_users/table.php', $vars);
        exit(json_encode($result));
    }

    private function actionGetEmployeesList($idRestaurant) {
        $result = array();
        $result['message'] = "Успешно!";
        $result['success'] = true;
        $employeesList = $this->getEmployeesList($idRestaurant);
        $result['data'] = $employeesList;
        $vars = [
            'data' => $employeesList
        ];
        $result['view'] = $this->getView('admin/employees/table.php', $vars);
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
                if (!$this->account->existLogin($form['login'])) {
                    $id_user = $this->account->createUser(
                        $form['name'],
                        $form['surname'],
                        $form['patronymic'],
                        $form['date_of_birth'],
                        (isset($form['avatar']) ? $form['avatar'] : 'avatar_default.png')
                    );
                    $id_account = $this->account->createAccount($id_user, $form['login'], $form['password']);
                    if($form['is_admin'] == "true") {
                        $params = [
                            'id_user' => $id_user,
                            'id_position' => $this->account->getPositionByName('admin')['id']
                        ];
                        $this->insert('user_position', ['id_user', 'id_position'], $params);
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
            && isset($form['login']) && $form['login'] != null
            && isset($form['is_admin']) && $form['is_admin'] != null
        ) {
            if($form['password'] != null  && ($form['password'] == null || !$this->account->checkPassword($form['password'], $form['password_repeat']))) {
                $result['message'] = "Пароль должен совпадать!";
                $result['success'] = false;
                exit(json_encode($result));
            }
            $accountUser = $this->getAccountByUser($form['id']);
            if ($accountUser['login'] != $form['login'] && $this->account->existLogin($form['login'])) {
                $result['message'] = "Логин занят!";
                $result['success'] = false;
                exit(json_encode($result));
            }
            $this->editUser(
                $form['id'],
                $form['name'],
                $form['surname'],
                $form['patronymic'],
                $form['date_of_birth'],
                (isset($form['avatar']) ? $form['avatar'] : 'avatar_default.png')
            );
            $this->account->updateLogin($form['id'], $form['login']);
            if(($form['is_admin'] == "true") != $this->account->isAdmin($form['id'])) {
                if($form['is_admin'] == "true") {
                    $params = [
                        'id_user' => $form['id'],
                        'id_position' => $this->account->getPositionByName('admin')['id']
                    ];
                    $this->insert('user_position', ['id_user', 'id_position'], $params);
                } else {
                    $this->account->depriveUserAdmin($form['id']);
                }
            }
            if($form['password'] != null) {
                $this->account->updatePassword($form['id'], $form['password']);
            }
            $result['message'] = "Успешно!";
            $result['success'] = true;
        } else {
            $result['message'] = "Заполнены не все поля!";
            $result['success'] = false;
        }
        exit(json_encode($result));
    }

    private function actionDeleteUser($id, $accountData) {
        $result = array();
        if($id != $accountData['id_user']) {
            if(!$this->account->isHeadAdmin($id)) {
                $this->deleteUser($id);
                $result['message'] = "Успешно!";
                $result['success'] = true;
            } else {
                $result['message'] = "Вы не можете удалить Главного администратора!";
                $result['success'] = false;
            }
        } else {
            $result['message'] = "Вы не можете удалить себя!";
            $result['success'] = false;
        }
        exit(json_encode($result));
    }

    private function editUser($idUser, $name, $surname, $patronymic, $date_of_birth, $avatar) {
        $user = $this->getUserById($idUser);
        $columns = [
            'name',
            'surname',
            'patronymic',
            'date_of_birth',
            'avatar',
            'date'
        ];
        $params = [
            'name' => ($name != $user['name'] ? $name : $user['name']),
            'surname' => ($surname != $user['surname'] ? $surname : $user['surname']),
            'patronymic' => ($patronymic != $user['patronymic'] ? $patronymic : $user['patronymic']),
            'date_of_birth' => ($date_of_birth != $user['date_of_birth'] ? $date_of_birth : $user['date_of_birth']),
            'avatar' => ($avatar != 'avatar_default.png' && $avatar != $user['avatar'] ? $avatar : $user['avatar']),
            'date' => $user['date']
        ];
        $this->update('users', $idUser, $columns, $params);
    }

    private function deleteUser($idUser) {
        $params = [
            'id' => $idUser
        ];
        $this->delete('users', ['id'], $params);
    }

    private function getUserById($idUser) {
        $params = [
            'id' => $idUser
        ];
       return $this->select('users', ['id'], $params)[0];
    }

    private function getAccountByUser($idUser) {
        $params = [
            'id_user' => $idUser
        ];
        return $this->select('accounts', ['id_user'], $params)[0];
    }

    private function getUsersList() {
        $userList = $this->select('users');
        for ($i = 0; $i < count($userList); $i++) {
            $params = [
                'id_user' => $userList[$i]['id']
            ];
            $userList[$i]['is_admin'] = $this->account->isAdmin($userList[$i]['id']);
            $account = $this->select('accounts', ['id_user'], $params)[0];
            $userList[$i]['login'] = $account['login'];
        }
        return $userList;
    }

    private function getUserPositionList($idUserPosition) {
        return $this->select(
            'user_position',
            ['id'],
            ['id' => $idUserPosition]
        )[0];
    }

    private function getPositionById($id) {
        return $this->select(
            'positions',
            ['id'],
            ['id' => $id]
        )[0];
    }

    private function getEmployeesList($idRestaurant) {
        $result = array();
        $employeesList = $this->select(
            'restaurant_employees',
            ['id_restaurant'],
            ['id_restaurant' => $idRestaurant]
        );
        for($i = 0; $i < count($employeesList); $i++) {
            $userData = [];
            $userPositionList = $this->getUserPositionList($employeesList[$i]['id_user_position']);
            $check = false;
            for($j = 0; $j < count($result); $j++) {
                if($userPositionList['id_user'] == $result[$j]['user']['id']) {
                    $check = true;
                    break;
                }
            }
            if($check) {
                continue;
            }
            $userData['user'] = $this->getUserById($userPositionList['id_user']);
            $arrayPositions = array();
            for($j = 0; $j < count($employeesList); $j++) {
                $userPositionListOther= $this->getUserPositionList($employeesList[$j]['id_user_position']);
                if($userData['user']['id'] == $userPositionListOther['id_user']) {
                    array_push($arrayPositions, $this->getPositionById($userPositionListOther['id_position']));
                }
            }
            $userData['positions'] = $arrayPositions;
            array_push($result, $userData);
        }
        return $result;
    }

}