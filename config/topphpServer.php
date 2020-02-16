<?php
/**
 * 凯拓软件 [临渊羡鱼不如退而结网,凯拓与你一同成长]
 * Project: topphp-skeleton
 * Date: 2020/2/4 16:13
 * Author: sleep <sleep@kaituocn.com>
 */

use Topphp\TopphpSwoole\server\RpcServer;
use Topphp\TopphpSwoole\server\HttpServer;
use Topphp\TopphpSwoole\server\WebSocketServer;

return [
    'mode'    => SWOOLE_PROCESS,                  // 运行模式 默认为SWOOLE_PROCESS
    'servers' => [
        [
            'type'      => HttpServer::class,
            'name'      => 'top-server1',
            'host'      => env('SWOOLE_HOST', '127.0.0.1'), // 监听地址
            'port'      => 9501,                            // 监听端口
            'sock_type' => SWOOLE_SOCK_TCP,
            'options'   => [
                // 开启websocket服务时设为true
                'open_websocket_protocol' => true
            ]
        ],
        [
            'type'      => RpcServer::class,
            'name'      => 'top-server2',
            'host'      => env('SWOOLE_HOST', '127.0.0.1'), // 监听地址
            'port'      => 9502,                            // 监听端口
            'sock_type' => SWOOLE_SOCK_TCP,
            'options'   => []
        ],
        [
            'type'      => WebSocketServer::class,
            'name'      => 'top-server3',
            'host'      => env('SWOOLE_HOST', '127.0.0.1'), // 监听地址
            'port'      => 9503,                            // 监听端口
            'sock_type' => SWOOLE_SOCK_TCP,
            'options'   => []
        ],
    ],
    'options' => [
        'pid_file'              => runtime_path() . 'topphp_swoole.pid',
        'log_file'              => runtime_path() . 'topphp_swoole.log',
        'daemonize'             => false,   // 是否开启守护进程
        // Normally this value should be 1~4 times larger according to your cpu cores.
        'reactor_num'           => swoole_cpu_num(),
        'worker_num'            => swoole_cpu_num(),
        'task_worker_num'       => swoole_cpu_num(),
        'task_enable_coroutine' => true,
        'task_max_request'      => 3000,
        'enable_static_handler' => true,
        'document_root'         => root_path('public'),
        'package_max_length'    => 20 * 1024 * 1024,
        'buffer_output_size'    => 10 * 1024 * 1024,
        'socket_buffer_size'    => 128 * 1024 * 1024,
        'max_request'           => 3000,
        'send_yield'            => true,
        // 设置异步重启开关。设置为true时，将启用异步安全重启特性，Worker进程会等待异步事件完成后再退出。
        'reload_async'          => true,
    ],
];
