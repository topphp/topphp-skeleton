<?php

namespace app\controller;

use app\annotation\MyAnnotation;
use app\BaseController;
use think\annotation\Inject;
use think\annotation\Route;

/**
 * Class Index
 * @package app\controller
 */
class Index extends BaseController
{
    /**
     * @Inject()
     * @var MyAnnotation
     */
    public $reader;

    /**
     * @author sleep
     * @Route("index/index",method="GET")
     */
    public function index()
    {
        return $this->reader->dumpData("hello TOPphp");
    }
}
