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
    }

    public function init()
    {
        parent::init();
        $this->addMenuItemAdmin('Должности', 'positions');
    }
}