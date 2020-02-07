<?php
declare(strict_types=1);

namespace app\controller;

use app\BaseController;
use test\Single;
use think\annotation\Route;
use think\facade\Filesystem;
use think\response\Json;
use think\swoole\middleware\ResetVarDumper;

class Index extends BaseController
{
    /**
     * @return Json
     * @Route("index/index",method="GET")
     * @author sleep
     */
    public function index()
    {
        go(function () {
            $r = new ResetVarDumper();
            $r->handle($this->request, function () {
                var_dump('haha');
            });
        });
        return json(['a' => Single::getInstance()->abc()])->code(404);
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
