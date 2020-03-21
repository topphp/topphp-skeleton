<?php
// 全局应用公共文件
use app\common\enumerate\CheckConfigEnum;

define('DS', DIRECTORY_SEPARATOR);// 自定义目录"/"常量


//************************************ --- 数据验证 --- ****************************************//


/**
 * 验证器-单独验证某个请求字段（返回true证明通过，失败会自动返回提示信息）
 * @param string $paramName 要验证的字段名称
 * @param string $method 来自哪种请求方式的参数
 * @return bool|\think\Response
 * @throws \lib\TopException
 */
function checkOneRequestParam(string $paramName, string $method = "")
{
    $fieldValue = null;
    $data       = [];
    switch (strtolower($method)) {
        case 'get':
            $fieldValue = request()->get($paramName);
            break;
        case 'post':
            $fieldValue = request()->post($paramName);
            break;
        case 'put':
            $fieldValue = request()->put($paramName);
            break;
        case 'patch':
            $fieldValue = request()->patch($paramName);
            break;
        case 'delete':
            $fieldValue = request()->delete($paramName);
            break;
        default :
            $fieldValue = request()->param($paramName);
    }
    $data[$paramName] = $fieldValue;
    if (preg_match("/\./", request()->controller())) {
        $controllerArray = @explode(".", request()->controller());
        // 获取控制器名
        $controllerName = ucfirst(array_pop($controllerArray));
        // 获取层级名
        $checkVersion = $controllerArray[0] = lcfirst($controllerArray[0]);
        $layeredName  = implode(".", $controllerArray);
        // 获取验证类命名空间
        $validateDir = implode("\\", $controllerArray) . "\\";
    } else {
        $controllerArray = [];
        $controllerName  = request()->controller();
        $checkVersion    = "";
        $layeredName     = "";
        $validateDir     = "";
    }
    $module       = app('http')->getName();
    $validateName = '\app\\' . $module . '\validate\\' . $validateDir . $controllerName . "Check";
    if (class_exists($validateName)) {
        // 此处忽略验证器白名单，直接强制验证
        $validate = new $validateName();
        if (empty($layeredName)) {
            $scene = strtolower(request()->action()) . "@" . $paramName;
            if (!$validate->hasScene($scene)) {
                return \lib\SendMsg::jsonThrow("Validation scene( {$scene} ) does not exist, Please configure");
            }
            $validateRes = $validate->scene(strtolower(request()->action()) . "@" . $paramName)->check($data);
        } else {
            $versionArr = isset(CheckConfigEnum::API_VERSION_LIST[$module]) ? CheckConfigEnum::API_VERSION_LIST[$module] : [];
            if (!empty($versionArr) && is_array($versionArr)) {
                if (in_array($checkVersion, $versionArr)) {
                    array_shift($controllerArray);
                    if (!empty($controllerArray)) {
                        $scene = strtolower(implode(".",
                                $controllerArray) . "." . request()->action() . "@" . $paramName);
                    } else {
                        $scene = strtolower(request()->action() . "@" . $paramName);
                    }
                } else {
                    $scene = strtolower($layeredName . "." . request()->action()) . "@" . $paramName;
                }
            } else {
                $scene = strtolower($layeredName . "." . request()->action()) . "@" . $paramName;
            }
            if (!$validate->hasScene($scene)) {
                return \lib\SendMsg::jsonThrow("Validation scene( {$scene} ) does not exist, Please configure");
            }
            $validateRes = $validate->scene($scene)->check($data);
        }
        if ($validateRes !== true) {
            $errorMsg    = $validate->getError();
            $returnError = [
                "code" => \app\common\enumerate\CommonCodeEnum::FAIL,
                "msg"  => "fail"
            ];
            if (is_array($errorMsg)) {
                $returnError = array_merge($returnError, $errorMsg);
            } else {
                $returnError['msg'] = $errorMsg;
            }
            // code码形式的返回
            return \lib\SendMsg::jsonThrow($returnError['msg'], $returnError['code']);
        }
    } else {
        // 验证类不存在
        return \lib\SendMsg::jsonThrow("Validation Class does not exist, Please configure");
    }
    return true;
}


//************************************ --- 其他公共方法 --- ****************************************//


/**
 * 生成全局唯一ID（17位）【每秒能够产生26万ID左右】
 * @param int $number 指定一次性生成多少个
 * @param int $datacenterId 数据中心ID，非分布式系统默认1即可
 * @param int $workerId 工作机器ID（0-1023），非分布式系统默认1即可
 * @return array|mixed|null
 */
function genUuid(int $number = 1, int $datacenterId = 1, int $workerId = 1)
{
    try {
        $uuid      = [];
        $snowflake = new \Godruoyi\Snowflake\Snowflake($datacenterId, $workerId);
        for ($i = 0;$i < $number;$i++) {
            $uuid[] = $snowflake->id();
        }
        return count($uuid) > 1 ? $uuid : $uuid[0];
    } catch (\Exception $e) {
        return null;
    }
}