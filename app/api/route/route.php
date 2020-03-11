<?php
/**
 * @copyright 凯拓软件 [临渊羡鱼不如退而结网,凯拓与你一同成长]
 * @author sleep <sleep@kaituocn.com>
 */

/**
 * Description - route.php
 *
 * 多版本api路由
 */

use app\common\enumerate\CommonCodeEnum;
use think\facade\Route;

// api 版本路由【以下路由顺序不可更改】
// 请求URL实例：http://domain/api/v1/控制器/方法名(推荐) 或 http://domain/api/v1.控制器/方法名
Route::rule(':version/:controller/:action', ':version.:controller/:action', '*')
    ->pattern(['version' => 'v(\d+)', 'controller' => '\w+', 'action' => '\w+']);
Route::rule('v1/:controller', 'v1.:controller/index', '*');
Route::rule('v2/:controller', 'v2.:controller/index', '*');
Route::rule('v1', 'v1.Index/index', '*');
Route::rule('v2', 'v2.Index/index', '*');
Route::miss(function () {
    if (request()->isAjax() || request()->isPjax()) {
        return \lib\SendMsg::jsonAlert('404 Not Found!', CommonCodeEnum::FAIL, [], 404);
    } else {
        return response('404 Not Found!', 404);
    }
});