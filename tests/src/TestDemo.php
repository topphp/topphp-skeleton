<?php
/**
 * 凯拓软件 [临渊羡鱼不如退而结网,凯拓与你一同成长]
 * Project: topphp-skeleton
 * Date: 2020/1/15 15:14
 * Author: sleep <sleep@kaituocn.com>
 */
declare(strict_types=1);

namespace Topphp\Test;

use Swoole\Coroutine;
use Topphp\TopphpTesting\TestCase;

class TestDemo extends TestCase
{
    public function testIndex()
    {
        $stack = new \SplStack();
        $stack->push('1');
        $stack->push('2');
        echo $stack->pop() . PHP_EOL;
        echo $stack->pop() . PHP_EOL;

        $queue = new \SplQueue();
        $queue->push(1);
        $queue->push(2);
        var_dump($queue->pop());
        $this->assertTrue(true);
    }

    public function testIntDiv()
    {
        $int = intdiv(10, 3);
        $this->assertEquals($int, 3);
    }

    public function testList()
    {
        Coroutine::create(function () {
            echo "gogogo1\n";
        });
        Coroutine::create(function () {
            echo "gogogo2\n";
        });
        $arr = [1, 2, 3];
        $d   = max($arr);
        [$a, $b, $c] = $arr;
        var_dump($arr);
        $this->assertEquals($a, 1);
        $this->assertEquals($b, 2);
        $this->assertEquals($c, 3);
    }

}
