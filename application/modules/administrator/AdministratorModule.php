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
                    $this->actionGetWindowFormAddUser();
                    break;
                case 'createUser':
                    $this->actionCreateUser($post['form']);
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

    private function actionGetWindowFormAddUser() {
        $result = array();
        $result['message'] = "Успешно!";
        $result['success'] = true;
        $result['view'] = $this->getView('employee/manager_users/windowForm.php');
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
                $form['date_of_birth']
            );
            $result['message'] = "Успешно!";
            $result['success'] = true;
        } else {
            $result['message'] = "Заполнены не все поля!";
            $result['success'] = false;
        }
        exit(json_encode($result));
    }
    private function getUsersList() {
        return $this->select('users');
    }

}