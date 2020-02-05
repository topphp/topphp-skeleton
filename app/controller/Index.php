<?php
declare(strict_types=1);

namespace app\controller;

use app\BaseController;
use test\Single;
use think\annotation\Route;

class Index extends BaseController
{
    /**
     * @return string
     * @author sleep
     * @Route("index/index",method="GET")
     */
    public function index(): string
    {
        return Single::getInstance()->abc();
    }

    /**
     * @return string
     * @Route("index/test",method="GET")
     * @author sleep
     */
    public function test()
    {
        dump(123);
        return "hello";
    }
}
