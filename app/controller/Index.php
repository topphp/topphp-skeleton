<?php

namespace app\controller;

use app\BaseController;
use topphp\componentBuilder\SkeletonClass;

class Index extends BaseController
{
    public function index(SkeletonClass $skeletonClass)
    {
        return $skeletonClass->echoPhrase("哈哈😁");
    }
}
