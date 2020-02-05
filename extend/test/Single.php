<?php
/**
 * 凯拓软件 [临渊羡鱼不如退而结网,凯拓与你一同成长]
 * Project: topphp-skeleton
 * Date: 2020/2/4 23:01
 * Author: sleep <sleep@kaituocn.com>
 */
declare(strict_types=1);

namespace test;

use Closure;

class Single
{
    /**
     * 单例实例
     * @var Single
     */
    private static $instance;

    private function __construct()
    {
    }

    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }

        if (self::$instance instanceof Closure) {
            return (self::$instance)();
        }

        return self::$instance;
    }

    public function abc()
    {
        return 'abcdef';
    }
}
