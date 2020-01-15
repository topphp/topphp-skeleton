<?php
/**
 * 凯拓软件 [临渊羡鱼不如退而结网,凯拓与你一同成长]
 * Project: topphp-skeleton
 * Date: 2020/1/15 15:14
 * Author: sleep <sleep@kaituocn.com>
 */
declare(strict_types=1);

namespace test;

use PHPUnit\Framework\TestCase;

class TestDemo extends TestCase
{
    public function testIndex()
    {
        $stack = new \SplStack();
        $stack->push('1');
        $stack->push('2');
        echo $stack->pop() . PHP_EOL;
        echo $stack->pop() . PHP_EOL;
        $this->assertTrue(true);
    }
}
