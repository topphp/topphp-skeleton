<?php
declare(strict_types=1);

namespace app\annotation;

class MyAnnotation
{
    public $reader = 'default';

    public function dumpData($data)
    {
        return $data;
    }
}
