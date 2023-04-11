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
    'panel/{panel:employee}' => [
        'controller' => 'panel',
        'action' => 'employee'
    ],
    'panel/{panel:admin}' => [
        'controller' => 'panel',
        'action' => 'admin'
    ],
    'panel/{panel:admin}/{actionpanel:restaurants}' => [
        'controller' => 'panel',
        'action' => 'restaurants'
    ],
    'panel/{panel:admin}/{actionpanel:restaurants}/add' => [
        'controller' => 'panel',
        'action' => 'addRestaurant'
    ],
    'panel/{panel:admin}/{actionpanel:restaurants}/{id:\d+}' => [
        'controller' => 'panel',
        'action' => 'infoRestaurant'
    ],
    'panel/{panel:admin}/{actionpanel:modules}' => [
        'controller' => 'panel',
        'action' => 'modules'
    ],
    'test' => [
        'controller' => 'test',
        'action' => 'index'
    ]
];
