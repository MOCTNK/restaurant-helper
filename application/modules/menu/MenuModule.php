<?php

namespace application\modules\menu;

use application\core\Module;

class MenuModule extends Module
{
    public function __construct() {
        parent::__construct();
        $this->name = 'menu';
        $this->about = 'Добавляет возможность создания меню для ресторана.';
        $this->version = '0.1';
        $this->author = 'Мостовой Даниил';
    }

    public function init()
    {
        parent::init();
        $this->addMenuItemAdmin('Меню', 'menu');
    }
}