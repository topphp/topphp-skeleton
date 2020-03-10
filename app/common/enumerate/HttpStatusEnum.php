<?php
/**
 * Description - HttpStatusEnum.php
 *
 * Http 状态码枚举类
 */


namespace app\common\enumerate;


class HttpStatusEnum
{
    //success 成功
    const SUCCESS = 200;
    //no message 无内容
    const NO_CONTENT = 204;
    //redirect 重定向
    const REDIRECT = 302;
    //服务器异常
    const SERVER_ERROR = 500;
    //系统参数错误
    const SYSTEM_INVALID = 400;
    //接口参数错误
    const PARAMS_ERROR = 401;
    //禁止访问（黑名单）
    const FORBIDDEN = 403;
    //页面不存在
    const NOT_FOUND = 404;
    //参数验证错误
    const VALIDATE_ERROR = 422;

    //4xx系列参数组
    const SYSTEM_INVALID_SET = [
        self::SYSTEM_INVALID,//400
        self::PARAMS_ERROR,//401
        self::FORBIDDEN,//403
        self::NOT_FOUND,//404
        self::VALIDATE_ERROR,//422
    ];

    //5xx系列参数组
    const SERVER_ERROR_SET = [
        self::SERVER_ERROR,//500
    ];
}