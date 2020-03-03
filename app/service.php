<?php

use app\AppService;
use app\service\CinemaService;
use app\service\FilmService;

// 系统服务定义文件
// 服务在完成全局初始化之后执行
return [
    AppService::class,
    FilmService::class,
    CinemaService::class,
];
