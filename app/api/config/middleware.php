<?php
// 多版本api中间件配置
return [
    // 别名或分组
    'alias'    => [
        "V1" => [
            app\api\middleware\V1::class,
            app\middleware\Check::class,
        ],
        "V2" => [
            app\api\middleware\V2::class,
            app\middleware\Check::class,
        ]
    ],
    // 优先级设置，此数组中的中间件会按照数组中的顺序优先执行
    'priority' => [
        app\middleware\Check::class,
        app\api\middleware\V1::class,
        app\api\middleware\V2::class,
    ],
];
