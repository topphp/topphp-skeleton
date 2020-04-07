<?php
/**
 * @copyright 凯拓软件 [临渊羡鱼不如退而结网,凯拓与你一同成长]
 * @author sleep <sleep@kaituocn.com>
 */

/**
 * Description - SendMsg.php
 *
 * Code Message 返回信息类
 */


namespace lib;


use app\common\enumerate\CommonCodeEnum;
use app\common\enumerate\HttpStatusEnum;

class SendMsg
{
    /**
     * 返回 code 数组
     * @param int $code
     * @param string $message
     * @param mixed $data
     * @param int $httpCode
     * @return array
     */
    private static function renderArray(
        $code = CommonCodeEnum::SUCCESS,
        $message = "",
        $data = [],
        $httpCode = HttpStatusEnum::SUCCESS
    ) {
        $data = $data !== null ? $data : [];
        if (is_array($message)) {
            $message = json_encode($message, JSON_UNESCAPED_UNICODE);
        } elseif (is_object($message)) {
            $message = json_encode(self::objectToArray($message), JSON_UNESCAPED_UNICODE);
        }
        $render = compact('code', 'message', 'data');
        if (config("app.show_http_status")) {
            $render['StatusCode'] = (int)$httpCode;
        }
        if (env("app_debug") && !empty(request()->controller())) {
            $render['operate'] = app('http')->getName() . '/' . request()->controller() . '/' . request()->action();
        }
        return $render;
    }

    private static function objectToArray($obj)
    {
        $obj = (array)$obj;
        foreach ($obj as $k => $v) {
            if (gettype($v) == 'resource') {
                return [];
            }
            if (gettype($v) == 'object' || gettype($v) == 'array') {
                $obj[$k] = (array)self::objectToArray($v);
            }
        }

        return $obj;
    }

    private static function checkArray($sendArray, $isList = false)
    {
        $returnArray = [];
        if (array_key_exists('code', $sendArray) && is_numeric($sendArray['code'])) {
            if ((int)$sendArray['code'] == 0) {
                $returnArray['code'] = CommonCodeEnum::FAIL;
            } else {
                $returnArray['code'] = (int)$sendArray['code'];
            }
        } else {
            $returnArray['code'] = CommonCodeEnum::SUCCESS;
        }
        if (array_key_exists('message', $sendArray)) {
            $returnArray['message'] = $sendArray['message'];
        } else {
            $returnArray['message'] = $returnArray['code'] == CommonCodeEnum::FAIL ? "fail" : "success";
        }
        if (array_key_exists('data', $sendArray)) {
            if (is_object($sendArray['data'])) {
                $returnArray['data'] = self::objectToArray($sendArray['data']);
                if ($isList) {
                    $returnArray['data']['list'] = $returnArray['data'];
                }
            } else {
                if ($isList && is_array($sendArray['data'])) {
                    $returnArray['data']['list'] = $sendArray['data'];
                } else {
                    $returnArray['data'] = $sendArray['data'];
                }
            }
        } else {
            $returnArray['data'] = [];
        }
        if (array_key_exists('StatusCode', $sendArray)) {
            $returnArray['httpCode'] = $sendArray['StatusCode'];
        } else {
            $returnArray['httpCode'] = HttpStatusEnum::SUCCESS;
        }
        return $returnArray;
    }

    //--------------------- code 数据返回（array类型） ---------------------//

    /**
     * 操作数据返回
     * @param mixed $data
     * @param int $httpCode
     * @return array
     */
    public static function arrayData($data = [], $httpCode = HttpStatusEnum::SUCCESS)
    {
        return self::renderArray(CommonCodeEnum::SUCCESS, "success", $data, (int)$httpCode);
    }

    /**
     * 操作弹层/提示/消息/警告返回
     * @param int $code
     * @param string $message
     * @param mixed $data
     * @param bool $throw 是否强制抛出，为true将会终止后面代码执行，直接返回信息
     * @param int $httpCode
     * @return array
     * @throws TopException
     */
    public static function arrayAlert(
        $code = CommonCodeEnum::FAIL,
        $message = "fail",
        $data = [],
        $throw = false,
        $httpCode = HttpStatusEnum::SUCCESS
    ) {
        //解析code文本
        if (empty($code) || (int)$code == 0) {
            $code = CommonCodeEnum::FAIL;
        } else {
            $code = (int)$code;
        }
        if ($throw) {
            $data  = $data !== null ? $data : [];
            $param = [
                'code'       => $code,
                'message'    => $message,
                'data'       => $data,
                'StatusCode' => $httpCode,
            ];
            // 注意：1、如果代码被try catch捕获，将不会强制终止代码向后执行
            //      2、这是基础php编程特性，一个好的编码习惯，业务逻辑就应该尽量不使用强制抛出，而是逐层返回
            throw new TopException($param);
        }
        return self::renderArray($code, $message, $data, (int)$httpCode);
    }

    //--------------------- 助手Json方法（支持全局xml返回，需配置 default_ajax_return 为 xml） ---------------------//

    /**
     * 发送响应数据（针对arrayData或arrayAlert方法返回的数组可以直接传给此方法进行response响应）
     * @param $sendArray
     * @param bool $isList 是否data数据返回list形式（仅data为对象或数组有效）
     * @param int $httpCode
     * @return \think\Response
     */
    public static function jsonSend($sendArray, $isList = false, $httpCode = HttpStatusEnum::SUCCESS)
    {
        if (!is_array($sendArray)) {
            return response(self::renderArray(), HttpStatusEnum::SUCCESS, [], "json");
        }
        $sendArray = self::checkArray($sendArray, $isList);
        if ((int)$sendArray['httpCode'] !== $httpCode && config("app.show_http_status")) {
            $httpCode = (int)$sendArray['httpCode'];
        }
        return response(self::renderArray($sendArray['code'], $sendArray['message'], $sendArray['data'],
            $sendArray['httpCode']), $httpCode, [], 'json');
    }

    /**
     * 操作数据返回
     * @param array $data
     * @param int $httpCode
     * @param array $headers
     * @return \think\Response
     */
    public static function jsonData($data = [], $httpCode = HttpStatusEnum::SUCCESS, $headers = [])
    {
        switch (strtolower(config("app.default_ajax_return"))) {
            case "jsonp":
                $type = "jsonp";
                break;
            case "xml":
                $type = "xml";
                break;
            default:
                $type = "json";
        }
        return response(self::arrayData($data, $httpCode), $httpCode, $headers, $type);
    }

    /**
     * 操作数据返回（data强制list形式）
     * @param array $data
     * @param int $httpCode
     * @param array $headers
     * @return \think\Response
     */
    public static function jsonList($data = [], $httpCode = HttpStatusEnum::SUCCESS, $headers = [])
    {
        if (is_array($data) || is_object($data)) {
            $dataList['list'] = $data;
        } else {
            $dataList = $data;
        }
        switch (strtolower(config("app.default_ajax_return"))) {
            case "jsonp":
                $type = "jsonp";
                break;
            case "xml":
                $type = "xml";
                break;
            default:
                $type = "json";
        }
        return response(self::arrayData($dataList, $httpCode), $httpCode, $headers, $type);
    }

    /**
     * 操作弹层/提示/消息/警告返回【简化使用，前置message】
     * @param int $code
     * @param string $message
     * @param array $data
     * @param int $httpCode
     * @param array $headers
     * @return \think\Response
     * @throws TopException
     */
    public static function jsonAlert(
        $message = "fail",
        $code = CommonCodeEnum::FAIL,
        $data = [],
        $httpCode = HttpStatusEnum::SUCCESS,
        $headers = []
    ) {
        switch (strtolower(config("app.default_ajax_return"))) {
            case "jsonp":
                $type = "jsonp";
                break;
            case "xml":
                $type = "xml";
                break;
            default:
                $type = "json";
        }
        return response(self::arrayAlert($code, $message, $data, false, $httpCode), $httpCode, $headers, $type);
    }

    /**
     * 操作弹层/提示/消息/警告返回【强制抛出模式】【简化使用，前置message】
     * @param int $code
     * @param string $message
     * @param array $data
     * @param int $httpCode
     * @param array $headers
     * @return \think\Response
     * @throws TopException
     */
    public static function jsonThrow(
        $message = "fail",
        $code = CommonCodeEnum::FAIL,
        $data = [],
        $httpCode = HttpStatusEnum::SUCCESS,
        $headers = []
    ) {
        switch (strtolower(config("app.default_ajax_return"))) {
            case "jsonp":
                $type = "jsonp";
                break;
            case "xml":
                $type = "xml";
                break;
            default:
                $type = "json";
        }
        return response(self::arrayAlert($code, $message, $data, true, $httpCode), $httpCode, $headers, $type);
    }

    //--------------------- 助手xml方法 ---------------------//

    /**
     * 发送响应数据（针对arrayData或arrayAlert方法返回的数组可以直接传给此方法进行response响应）
     * @param $sendArray
     * @param bool $isList 是否data数据返回list形式
     * @param int $httpCode
     * @return \think\Response
     */
    public static function xmlSend($sendArray, $isList = false, $httpCode = HttpStatusEnum::SUCCESS)
    {
        if (!is_array($sendArray)) {
            return response(self::renderArray(), HttpStatusEnum::SUCCESS, [], "xml");
        }
        $sendArray = self::checkArray($sendArray, $isList);
        if ((int)$sendArray['httpCode'] !== $httpCode && config("app.show_http_status")) {
            $httpCode = (int)$sendArray['httpCode'];
        }
        return response(self::renderArray($sendArray['code'], $sendArray['message'], $sendArray['data'],
            $sendArray['httpCode']), $httpCode, [], 'xml');
    }

    /**
     * 操作数据返回
     * @param mixed $data
     * @param int $httpCode
     * @param array $headers
     * @return string
     */
    public static function xmlData($data = [], $httpCode = HttpStatusEnum::SUCCESS, $headers = [])
    {
        return response(self::arrayData($data, $httpCode), $httpCode, $headers, 'xml');
    }

    /**
     * 操作数据返回（data强制list形式）
     * @param mixed $data
     * @param int $httpCode
     * @param array $headers
     * @return string
     */
    public static function xmlList($data = [], $httpCode = HttpStatusEnum::SUCCESS, $headers = [])
    {
        if (is_array($data) || is_object($data)) {
            $dataList['list'] = $data;
        } else {
            $dataList = $data;
        }
        return response(self::arrayData($dataList, $httpCode), $httpCode, $headers, 'xml');
    }

    /**
     * 操作弹层/提示/消息/警告返回【简化使用，前置message】
     * @param int $code
     * @param string $message
     * @param array $data
     * @param int $httpCode
     * @param array $headers
     * @return \think\Response
     * @throws TopException
     */
    public static function xmlAlert(
        $message = "fail",
        $code = CommonCodeEnum::FAIL,
        $data = [],
        $httpCode = HttpStatusEnum::SUCCESS,
        $headers = []
    ) {
        return response(self::arrayAlert($code, $message, $data, false, $httpCode), $httpCode, $headers, 'xml');
    }

    /**
     * 操作弹层/提示/消息/警告返回【强制抛出模式】【简化使用，前置message】
     * @param int $code
     * @param string $message
     * @param array $data
     * @param int $httpCode
     * @param array $headers
     * @return \think\Response
     * @throws TopException
     */
    public static function xmlThrow(
        $message = "fail",
        $code = CommonCodeEnum::FAIL,
        $data = [],
        $httpCode = HttpStatusEnum::SUCCESS,
        $headers = []
    ) {
        return response(self::arrayAlert($code, $message, $data, true, $httpCode), $httpCode, $headers, 'xml');
    }
}