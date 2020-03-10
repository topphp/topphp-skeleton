<?php
declare (strict_types = 1);

namespace app\admin\middleware;

class Auth
{
    /**
     * 后台管理接口权限中间件【admin应用中间件】
     * @param $request
     * @param \Closure $next
     * @return mixed
     * @author bai
     */
    public function handle($request, \Closure $next)
    {
        // todo 前后端分离模式 api_token admin_token 等校验 或者 非分离模式 管理员用户信息，权限等
        return $next($request);
    }

    /**
     * 结束调度（请求结束前的回调）
     * @param \think\Response $response
     * @author bai
     */
    public function end(\think\Response $response)
    {
        // 回调行为，如记录响应日志等，注意，在end方法里面不能有任何的响应输出。因为回调触发的时候请求响应输出已经完成了。
    }
}
