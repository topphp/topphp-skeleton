<?php
declare(strict_types=1);

namespace app\controller;

use app\BaseController;
use app\service\FilmService;
use test\Single;
use think\annotation\Route;
use think\App;
use think\facade\Filesystem;
use think\response\Json;
use Topphp\TopphpSwoole\services\RpcConsumerService;
use Topphp\TopphpWechat\WeChat;

class Index extends BaseController
{
    /**
     * @Route("index/index",method="GET")
     * @return Json
     * @author sleep
     */
    public function index()
    {
        $we     = $this->app->get(WeChat::class);
        $config = $this->app->config->get('wechat');
        $app    = $we::officialAccount($config);
        try {
            $res     = $app->server->serve();
            $success = $res->send()->getContent();
            return json([
                'a'  => Single::getInstance()->abc(),
                '3c' => $success,
                'd'  => sys_get_temp_dir()
            ]);
        } catch (\Exception $e) {
        }
        return json([]);
    }

    /**
     * @return string
     * @Route("index/test",method="POST")
     * @author sleep
     */
    public function test()
    {
        $files = $this->request->file('img');
        $save  = [];
        if (is_array($files)) {
            foreach ($files as $file) {
                $save[] = Filesystem::disk('public')->putFile('topic', $file);
            }
        } else {
            $save[] = Filesystem::disk('public')->putFile('topic', $files);
        }
        return json($save);
    }


    /**
     * @return Json
     * @Route("index/db",method="GET")
     * @author sleep
     */
    public function db()
    {
//        $f    = $this->app->make(FilmService::class);
//        $data = $f->test(1, 1);

        $a = new RpcConsumerService();
        $d = $a->request(
            time(),
            'cinema-server',
            'cinemaService',
            'test1',
            [9, 13]
        );
        return json($d);
    }

    public function down()
    {
//        return Response::create('public/favicon.ico', 'file');
        return download(public_path('public') . 'favicon.ico', 'file');
    }
}
