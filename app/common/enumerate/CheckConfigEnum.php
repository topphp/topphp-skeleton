<?php
/**
 * @copyright 凯拓软件 [临渊羡鱼不如退而结网,凯拓与你一同成长]
 * @author sleep <sleep@kaituocn.com>
 */

/**
 * Description - CheckConfigEnum.php
 *
 * 验证器配置枚举
 */


namespace app\common\enumerate;


class CheckConfigEnum
{
    // 设置验证器场景简化--接口版本【全小写】（key 应用名 value 接口版本）
    const API_VERSION_LIST = [
        "api" => [
            "v1",// 注意：接口版本请不要加 . 号，如果需要多级别的版本，可用 - 号替代，如：v1-0-0 即为 v1.0.0
            "v2"
        ]
    ];

    // 全局验证器Check白名单【全小写】（不参与验证的--应用名/控制器名/操作名，支持通配符设置全控制器不使用验证器--应用名/控制器名/*）
    const CHECK_WHITE_LIST = [

        // 注意：如果是多层级或多版本控制器，请务必按照规范填写全控制器，如 api/v1.index/index 或 index/layered.index/index，否则白名单将不会生效，以下为示例

        //--- api 应用 ---//
        "api/v1.index/index", // index
        "api/v2.index/index", // index


    ];
}