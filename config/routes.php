<?php

return [
    'login'=>'site/login',
    ''=>'site/index',
    ''=>'site',
    'setting' => '/setting/default',
    'setting/icon' => '/setting/default/icon',
    'setting/tipe' => '/setting/tipe/index',
    '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
    ['class' => 'app\config\UrlRule', 'connectionID' => 'db'],
];
