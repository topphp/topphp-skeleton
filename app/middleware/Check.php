<?php
declare (strict_types = 1);

namespace app\middleware;

class Check
{
    /**
     * 验证器中间件【全局中间件】
     * @param $request
     * @param \Closure $next
     * @return mixed
     * @author bai
     */
    public function handle($request, \Closure $next)
    {
        return $next($request);
    }
}
