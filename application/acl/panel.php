<?php

return [
    'all'=> [

    ],
    'authorize'=> [
        'employee',
        'actionEmployee'
    ],
    'guest'=> [

    ],
    'admin'=> [
        'employee',
        'actionEmployee',
        'admin',
        'restaurants',
        'addRestaurant',
        'infoRestaurant',
        'actionRestaurant',
        'modules'
    ],
];