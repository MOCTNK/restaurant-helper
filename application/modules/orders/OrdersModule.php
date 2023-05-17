<?php

namespace application\modules\orders;

use application\core\Module;

class OrdersModule extends Module
{
    public function __construct() {
        parent::__construct();
        $this->name = 'orders';
        $this->about = 'Добавляет возможность формировать заказы.';
        $this->version = '0.1';
        $this->author = 'Мостовой Даниил';
    }

    public function init()
    {
        parent::init();
        $this->addMenuItemAdmin('Заказы', 'orders');
    }
}