<?php

namespace application\modules\cook;

use application\core\Module;

class CookModule extends Module
{
    public function __construct() {
        parent::__construct();
        $this->name = 'cook';
        $this->about = 'Добавляет функционал для повара.';
        $this->version = '0.1';
        $this->author = 'Мостовой Даниил';
        $this->descriptionMenuItemEmployee = [
            'kitchen' => [
                'position' => 'cook'
            ]
        ];
    }

    public function init()
    {
        parent::init();
        $this->addMenuItemEmployee('Кухня', 'kitchen');
    }
}