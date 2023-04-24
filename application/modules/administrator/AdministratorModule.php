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
            'manager_employee' => [
                'color' => 'white',
                'is_admin' => true
            ]
        ];
    }

    public function init()
    {
        parent::init();
        $this->addMenuItemAdmin('Сотрудники', 'employees');
        $this->addMenuItemEmployee('Менеджер пользователей', 'manager_employee');
        $this->addMenuItemEmployee('Менеджер аккаунтов', 'manager_accounts');
    }
}