<?php
declare(strict_types=1);

namespace app\controller;

use app\BaseController;
use Swoole\Server;
use test\Single;
use think\annotation\Route;
use think\facade\Filesystem;

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
        $file = request()->file('img');
        if (!is_null($file)) {
            return Filesystem::disk('public')->putFile('topic', $file);
        }
        return 'bucunzai';
    }
}
