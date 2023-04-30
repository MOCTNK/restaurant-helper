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
    'savefile/{directory:[a-zA-z]+}/{file_name:[a-zA-z0-9.]+}' => [
        'controller' => 'installer',
        'action' => 'saveFile'
    ],
    'account/login' => [
        'controller' => 'account',
        'action' => 'login'
    ],
    'account/logout' => [
        'controller' => 'account',
        'action' => 'logout'
    ],
    'panel/{panel:employee}' => [
        'controller' => 'panel',
        'action' => 'employee'
    ],
    'panel/{panel:employee}/action/{id_action:\d+}' => [
        'controller' => 'panel',
        'action' => 'actionEmployee'
    ],
    'panel/{panel:admin}' => [
        'controller' => 'panel',
        'action' => 'admin'
    ],
    'panel/{panel:admin}/{action_panel:restaurants}' => [
        'controller' => 'panel',
        'action' => 'restaurants'
    ],
    'panel/{panel:admin}/{action_panel:restaurants}/add' => [
        'controller' => 'panel',
        'action' => 'addRestaurant'
    ],
    'panel/{panel:admin}/{action_panel:restaurants}/{id_restaurant:\d+}' => [
        'controller' => 'panel',
        'action' => 'infoRestaurant'
    ],
    'panel/{panel:admin}/{action_panel:restaurants}/{id_restaurant:\d+}/action/{id_action:\d+}' => [
        'controller' => 'panel',
        'action' => 'actionRestaurant'
    ],
    'panel/{panel:admin}/{action_panel:modules}' => [
        'controller' => 'panel',
        'action' => 'modules'
    ],
    'test' => [
        'controller' => 'test',
        'action' => 'index'
    ]
];
