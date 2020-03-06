<?php
/**
 * Description - index.php
 *
 * Index控制器
 */
declare(strict_types=1);

namespace app\index\controller;


class Index extends Base
{
    /**
     * index
     * @return string
     * @author bai
     */
    public function index()
    {
        return "Hello Index";
    }
}
