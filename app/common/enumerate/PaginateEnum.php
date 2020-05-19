<?php
/**
 * @copyright 凯拓软件 [临渊羡鱼不如退而结网,凯拓与你一同成长]
 * @author sleep <sleep@kaituocn.com>
 */

/**
 * Description - PaginateEnum.php
 *
 * 分页配置枚举
 */


namespace app\common\enumerate;

class PaginateEnum
{
    // 默认每页显示条数 default
    const ONE_PAGE_LIMIT = [
        "default"            => 15,// BaseModel全局默认分页每页显示条数

        // 注意：如果是多层级或多版本控制器，请务必按照规范填写全控制器，如 api/v1.index/index 或 index/layered.index/index，否则将不生效，会自动使用默认的

        // 应用名/控制器名/操作名 =》 每页显示条数（支持通配符设置全控制器通用--应用名/控制器名/*）

        //--- api 应用 ---//
        "api/v1.Index/index" => 10, // index
        "api/v2.Index/index" => 10, // index

    ];
}
