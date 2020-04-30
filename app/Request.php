<?php

namespace app;

// 应用请求对象类
class Request extends \think\Request
{
    /**
     * 重写获取当前的控制器名【注解中间件兼容性处理】
     * @access public
     * @param bool $convert 转换为小写
     * @return string
     */
    public function controller(bool $convert = false): string
    {
        $name = $this->controller ?: '';
        if (empty($name) && !empty($this->pathinfo())) {
            $pathinfo      = $this->pathinfo();
            $pathinfoArray = @explode("/", $pathinfo);
            if (count($pathinfoArray) > 1) {
                $name = current($pathinfoArray);
            } else {
                $name = "Index";
            }
            $this->setController($name);
        }
        return $convert ? strtolower($name) : $name;
    }

    /**
     * 重写获取当前的操作名【注解中间件兼容性处理】
     * @access public
     * @param bool $convert 转换为小写
     * @return string
     */
    public function action(bool $convert = false): string
    {
        $name = $this->action ?: '';
        if (empty($name) && !empty($this->pathinfo())) {
            $pathinfo      = $this->pathinfo();
            $pathinfoArray = @explode("/", $pathinfo);
            $action        = end($pathinfoArray);
            if (preg_match("/\./", $action)) {
                $name = current(@explode(".", $action));
            } else {
                $name = $action;
            }
            $this->setAction($name);
        }
        return $convert ? strtolower($name) : $name;
    }
}
