<?php
declare (strict_types=1);

namespace app\middleware;

use app\common\enumerate\CheckConfigEnum;
use app\common\enumerate\CommonCodeEnum;
use app\Request;
use lib\SendMsg;

class Check
{
    /**
     * 验证器中间件【全局中间件】（验证器命名规范--控制器名称拼接Check）
     * @param Request $request
     * @param \Closure $next
     * @return mixed
     * @throws \lib\TopException
     */
    public function handle(Request $request, \Closure $next)
    {
        // 校验操作是否存在
        $module       = app('http')->getName();
        $controller   = $request->controller();
        $operateClass = 'app\\' . $module . "\\controller\\" . preg_replace(
            "/\./",
            "\\",
            $controller
        );
        $checkBool    = true;
        if (!method_exists($operateClass, $request->action())) {
            if ($request->isAjax() || $request->isPjax()) {
                return SendMsg::jsonThrow('404 Not Found!', CommonCodeEnum::FAIL, [], 404);
            } else {
                // 验证空控制器是否存在
                if (preg_match("/\./", $controller)) {
                    $operateArray = @explode(".", $controller);
                    if (!empty($operateArray) && count($operateArray) > 1) {
                        array_pop($operateArray);
                    } else {
                        return response('404 Not Found!', 404);
                    }
                    $emptyClass = 'app\\' . $module . "\\controller\\" . @implode("\\", $operateArray);
                } else {
                    $emptyClass = 'app\\' . $module . "\\controller\\Error";
                }
                if (!class_exists($emptyClass)) {
                    return response('404 Not Found!', 404);
                }
                // 托管给空控制器
                $checkBool = false;
            }
        }
        if ($checkBool) {
            // 开始验证
            $data = [];
            if ($request->isPost()) {
                $data = $request->post();
            }
            if ($request->isPut()) {
                $data = $request->put();
            }
            if ($request->isPatch()) {
                $data = $request->patch();
            }
            if ($request->isDelete()) {
                $data = $request->delete();
            }
            if ($request->isGet()) {
                if (!empty($request->get())) {
                    $data = $request->get();
                } else {
                    $data = $request->param();
                }
            }
            if (preg_match("/\./", $controller)) {
                $controllerArray = @explode(".", $controller);
                // 获取控制器名
                $controllerName = ucfirst(array_pop($controllerArray));
                // 获取层级名
                $checkVersion = $controllerArray[0] = lcfirst($controllerArray[0]);
                $layeredName  = implode(".", $controllerArray);
                // 获取验证类命名空间
                $validateDir = implode("\\", $controllerArray) . "\\";
            } else {
                $controllerArray = [];
                $controllerName  = $controller;
                $checkVersion    = "";
                $layeredName     = "";
                $validateDir     = "";
            }
            $validateName = '\app\\' . $module . '\validate\\' . $validateDir . $controllerName . "Check";
            if (class_exists($validateName)) {
                // 验证器白名单校验（支持通配符设置）
                $operateToModule     = $module . "/*/*";
                $operateToController = $module . "/" . $controller . "/*";
                $operateToAction     = $module . "/" . $controller . "/" . $request->action();
                if (!in_array($operateToModule, CheckConfigEnum::CHECK_WHITE_LIST)
                    && !in_array($operateToController, CheckConfigEnum::CHECK_WHITE_LIST)
                    && !in_array($operateToAction, CheckConfigEnum::CHECK_WHITE_LIST)) {
                    // 开始验证
                    $validate = new $validateName();
                    if (empty($layeredName)) {
                        // 非多层级控制器验证
                        $validateRes = $validate->scene($request->action())->check($data);
                    } else {
                        // 多层级控制器验证（层级简化判断）
                        $versionArr = isset(CheckConfigEnum::API_VERSION_LIST[$module]) ? CheckConfigEnum::API_VERSION_LIST[$module] : [];
                        if (!empty($versionArr) && is_array($versionArr)) {
                            if (in_array($checkVersion, $versionArr)) {
                                array_shift($controllerArray);
                                if (!empty($controllerArray)) {
                                    $scene = implode(".", $controllerArray) . "." . $request->action();
                                } else {
                                    $scene = $request->action();
                                }
                                $validateRes = $validate->scene($scene)->check($data);
                            } else {
                                $validateRes = $validate->scene($layeredName . "." . $request->action())->check($data);
                            }
                        } else {
                            $validateRes = $validate->scene($layeredName . "." . $request->action())->check($data);
                        }
                    }
                    if ($validateRes !== true) {
                        $errorMsg = $validate->getError();
                        $errorMsg = $this->checkCode($errorMsg);
                        return SendMsg::jsonThrow($errorMsg['message'], $errorMsg['code']);
                    }
                }
            }
        }

        return $next($request);
    }

    private function checkCode($errorMsg)
    {
        $returnError = [
            "code"    => CommonCodeEnum::FAIL,
            "message" => "fail"
        ];
        if (is_array($errorMsg)) {
            $returnError = array_merge($returnError, $errorMsg);
        } else {
            $returnError['message'] = $errorMsg;
        }
        return $returnError;
    }
}
