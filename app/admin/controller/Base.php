<?php
/**
 * Description - base.php
 *
 * 业务基类控制器
 */
declare(strict_types=1);

namespace app\admin\controller;


use app\BaseController;

class Base extends BaseController
{
    /**
     * 定义业务中间件
     * @var array
     */
    protected $middleware = ['Check','Auth'];

    // Admin应用基础业务逻辑（所有方法需定义protected关键词）

}