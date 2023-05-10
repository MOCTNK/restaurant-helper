<?php

namespace application\modules\positionsPack;

use application\core\Module;

class PositionsPackModule extends Module
{
    public function __construct() {
        parent::__construct();
        $this->name = 'positionsPack';
        $this->about = 'Добавляет сборник должностей.';
        $this->version = '0.1';
        $this->author = 'Мостовой Даниил';
    }

    public function init()
    {
        parent::init();
        $this->addPosition('Официант', 'waiter');
        $this->addPosition('Повар', 'cook');
    }
}