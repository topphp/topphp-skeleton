<?php
// +----------------------------------------------------------------------
// | 应用设置
// +----------------------------------------------------------------------

return [
    // 应用地址
    'app_host'            => env('app.host', ''),
    // 应用的命名空间
    'app_namespace'       => '',
    // 是否启用路由
    'with_route'          => true,
    // 是否启用事件
    'with_event'          => true,
    // 开启应用快速访问
    'app_express'         => true,
    // 默认应用
    'default_app'         => 'index',
    // 默认时区
    'default_timezone'    => 'Asia/Shanghai',

    // 应用映射（自动多应用模式有效）
    'app_map'             => [],
    // 域名绑定（自动多应用模式有效）
    'domain_bind'         => [],
    // 禁止URL访问的应用列表（自动多应用模式有效，common用于存放一些公共类文件）
    'deny_app_list'       => ['common'],

    // 异常处理，接口应用配置（配置了此参数的应用，将以json code码形式返回报错信息，不会再出现TP的异常报错Trace页面）
    'exception_app_list'  => ['api'],
    // 异常页面的模板文件
    'exception_tmpl'      => app()->getRootPath() . 'extend/lib/TopExceptionTmpl.php',

    // 错误显示信息,非调试模式有效
    'error_message'       => '系统异常！请稍后再试～',
    // 显示错误信息（正式进入生产环境，建议关闭）
    'show_error_msg'      => env('show_error', false),
    // SendMsg是否显示httpStatus（200，401，500...）
    'show_http_status'    => false,
    // 默认ajax请求返回类型（json jsonp xml）
    'default_ajax_return' => "json",
];
