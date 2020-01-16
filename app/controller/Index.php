<?php
declare(strict_types=1);

namespace app\controller;

use app\BaseController;
use think\annotation\Route;
use topphp\componentTest\SkeletonClass;

class Index extends BaseController
{

    /**
     * @param SkeletonClass $skeletonClass
     * @return string
     * @author sleep
     * @Route("index/index",method="GET")
     */
    public function index(SkeletonClass $skeletonClass): string
    {
        testhaha();
        return $skeletonClass->echoPhrase(__FILE__);
    }
}
