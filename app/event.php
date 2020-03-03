<?php
// 事件定义文件
use app\subscribe\BaseServer;
use app\subscribe\HttpServer;
use app\subscribe\RpcServer;
use app\subscribe\TcpServer;
use app\subscribe\WebSocketServer;

return [
    'bind' => [
    ],

    'listen' => [
        'AppInit'  => [],
        'HttpRun'  => [],
        'HttpEnd'  => [],
        'LogLevel' => [],
        'LogWrite' => [],
    ],

    'subscribe' => [
        BaseServer::class,
        HttpServer::class,
        RpcServer::class,
        TcpServer::class,
        WebSocketServer::class
    ],
];
