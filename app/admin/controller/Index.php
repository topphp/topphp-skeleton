<?php
/**
 * @copyright 凯拓软件 [临渊羡鱼不如退而结网,凯拓与你一同成长]
 * @author sleep <sleep@kaituocn.com>
 */

/**
 * Description - index.php
 *
 * Index控制器
 */
declare(strict_types=1);

namespace app\admin\controller;


class Index extends Base
{
    /**
     * index
     * @return string
     * @author bai
     */
    public function index()
    {
        return "Hello Topphp Admin !";
    }
}
