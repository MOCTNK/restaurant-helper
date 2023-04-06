<?php

return [
    '' => [
        'controller' => 'main',
        'action' => 'index'
    ],
    'installer/setup' => [
        'controller' => 'installer',
        'action' => 'setup'
    ],
    'account/login' => [
        'controller' => 'account',
        'action' => 'login'
    ],
    'account/logout' => [
        'controller' => 'account',
        'action' => 'logout'
    ],
    'panel/employee' => [
        'controller' => 'panel',
        'action' => 'employee'
    ],
    'panel/admin' => [
        'controller' => 'panel',
        'action' => 'admin'
    ],
    'panel/admin/restaurants' => [
        'controller' => 'panel',
        'action' => 'restaurants'
    ],
    'panel/admin/restaurants/add' => [
        'controller' => 'panel',
        'action' => 'addRestaurant'
    ],
    'panel/admin/modules' => [
        'controller' => 'panel',
        'action' => 'modules'
    ],
    'test' => [
        'controller' => 'test',
        'action' => 'index'
    ]
];
