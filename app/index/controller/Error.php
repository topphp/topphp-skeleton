<?php
/**
 * @copyright 凯拓软件 [临渊羡鱼不如退而结网,凯拓与你一同成长]
 * @author sleep <sleep@kaituocn.com>
 */

/**
 * Description - Error.php
 *
 * 空操作Error类
 */
declare(strict_types=1);

namespace app\index\controller;

class Error extends Base
{
    /**
     * @param string $method 请求方法名
     * @param array $args 请求参数数组
     * @return string
     * @author bai
     */
    public function __call($method, $args)
    {
        return 'error request!';
    }
}
