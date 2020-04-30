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
        return "<h1 style=\"margin: 4rem;\">:)<span style=\"margin-left: 2rem\">Hello Topphp Admin !</span></h1>
                <h3 style=\"margin: 0 0 0 22rem;\">@ 凯拓软件</h3>
                <h5 style=\"margin: 1rem 0 0 13rem;\">临渊羡鱼不如退而结网,凯拓与你一同成长</h5>";
    }
}
