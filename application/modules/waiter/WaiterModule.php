<?php

namespace application\modules\waiter;

use application\core\Module;

class WaiterModule extends Module
{
    public function __construct() {
        parent::__construct();
        $this->name = 'waiter';
        $this->about = 'Добавляет функционал для официанта.';
        $this->version = '0.1';
        $this->author = 'Мостовой Даниил';
        $this->descriptionMenuItemEmployee = [
            'waiter_orders' => [
                'position' => 'waiter'
            ]
        ];
    }

    public function init()
    {
        parent::init();
        $this->addMenuItemEmployee('Заказы', 'waiter_orders');
    }
}