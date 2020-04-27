<?php
// 事件定义文件
return [
    'bind' => [
    ],

    'listen' => [
        'AppInit'     => [
            "Cache" => "app\behavior\\listener\\Cache"
        ],
        'HttpRun'     => [],
        'HttpEnd'     => [],
        'LogLevel'    => [],
        'LogWrite'    => [],
        'RouteLoaded' => [
            "Cache" => "app\behavior\\listener\\Cache"
        ],
    ],

    'subscribe' => [
    ],
];
