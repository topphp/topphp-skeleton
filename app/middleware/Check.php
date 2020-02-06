<?php
declare (strict_types = 1);

namespace app\middleware;

use think\Response;

class Check
{
    /**
     * 处理请求
     *
     * @param \think\Request $request
     * @param \Closure       $next
     * @return Response
     */
    public function handle($request, \Closure $next)
    {
//        var_dump("req");
        return $next($request);
    }
}
