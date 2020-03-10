<?php
// +----------------------------------------------------------------------
// | Trace设置 开启调试模式后有效
// +----------------------------------------------------------------------
return [
    // 内置Html和Console两种方式 支持扩展
    'type'    => 'Console',
    // 读取的日志通道名（仅支持file）
    'channel' => 'file',
    // 自定义选项卡
    'tabs'    => [
        'base'                                          => '基本',
        'file'                                          => '文件',
        'error|notice|warning|critical|alert|emergency' => '错误',
        'sql'                                           => 'SQL',
        'debug|info'                                    => '调试',
    ],
];
