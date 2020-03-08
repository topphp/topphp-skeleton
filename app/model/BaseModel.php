<?php

/**
 * @copyright 凯拓软件 [临渊羡鱼不如退而结网,凯拓与你一同成长]
 * @author sleep <sleep@kaituocn.com>
 */

declare(strict_types=1);

namespace app\model;

trait BaseModel
{
    protected $modelError = "";

    /**
     * 获取模型抛出的异常报错
     * @return mixed|string
     * @author bai
     */
    public function getModelError()
    {
        return $this->modelError;
    }
}
