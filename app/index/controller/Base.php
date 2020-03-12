<?php
/**
 * @copyright 凯拓软件 [临渊羡鱼不如退而结网,凯拓与你一同成长]
 * @author sleep <sleep@kaituocn.com>
 */

/**
 * Description - base.php
 *
 * 业务基类控制器
 */
declare(strict_types=1);

namespace app\index\controller;


use app\BaseController;

class Base extends BaseController
{
    /**
     * 定义业务中间件
     * @var array
     */
    protected $middleware = ['Check', 'Auth'];

    // Index应用基础业务逻辑（所有方法需定义protected关键词）

}