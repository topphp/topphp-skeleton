<?php
/**
 * @copyright 凯拓软件 [临渊羡鱼不如退而结网,凯拓与你一同成长]
 * @author sleep <sleep@kaituocn.com>
 */

/**
 * Description - MethodEnum.php
 *
 * 方法枚举
 */

namespace app\common\enumerate;

class MethodEnum
{
    const POST = "post";
    const PUT = "put";
    const GET = "get";
    const DELETE = "delete";
    const PATCH = "patch";



    // 排除软删除
    const EXCLUDE_SOFT = "excludeSoft";
    // 包含软删除
    const WITH_SOFT = "withSoft";
    // 只查软删除
    const ONLY_SOFT = "onlySoft";
}
