<?php

namespace app;

use app\common\enumerate\CommonCodeEnum;
use app\common\enumerate\HttpStatusEnum;
use think\db\exception\DataNotFoundException;
use think\db\exception\ModelNotFoundException;
use think\db\exception\PDOException;
use think\exception\ClassNotFoundException;
use think\exception\ErrorException;
use think\exception\FileException;
use think\exception\FuncNotFoundException;
use think\exception\Handle;
use think\exception\HttpException;
use think\exception\HttpResponseException;
use think\exception\RouteNotFoundException;
use think\exception\ValidateException;
use think\facade\Config;
use think\Response;
use Throwable;
use Topphp\TopphpLog\Log;

/**
 * 应用异常处理类
 */
class ExceptionHandle extends Handle
{
    /**
     * 不需要记录信息（日志）的异常类列表
     * @var array
     */
    protected $ignoreReport = [
        HttpException::class,
        HttpResponseException::class,
        ModelNotFoundException::class,
        DataNotFoundException::class,
        ValidateException::class,
    ];

    /**
     * 记录异常信息（包括日志或者其它方式记录）
     *
     * @access public
     * @param Throwable $exception
     * @return void
     */
    public function report(Throwable $exception): void
    {
        $defaultLog = config("log.default");
        $channels   = config("log.channels");
        if (isset($channels[$defaultLog]['type']) && $channels[$defaultLog]['type'] == "Aliyun") {
            // 使用阿里云日志记录异常信息
            if (!$this->isIgnoreReport($exception)) {
                // 收集异常数据
                $data = [
                    'file'    => $exception->getFile(),
                    'line'    => $exception->getLine(),
                    'message' => $this->getMessage($exception),
                    'code'    => $this->getCode($exception),
                ];
                $log  = "[{$data['code']}]{$data['message']}[{$data['file']}:{$data['line']}]";

                if ($this->app->config->get('log.record_trace') && $this->app->isDebug()) {
                    $log .= PHP_EOL . $exception->getTraceAsString();
                }

                try {
                    Log::write($log, "error", "系统错误");
                } catch (\Exception $e) {
                }
            }
        } else {
            // 使用内置的方式记录异常日志
            parent::report($exception);
        }
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @access public
     * @param \think\Request $request
     * @param Throwable $e
     * @return Response
     */
    public function render($request, Throwable $e): Response
    {
        // 添加自定义异常处理机制
        if (!empty(env("app_debug")) && config("app.show_error_msg")) {
            $tmpl = app()->getThinkPath() . 'tpl/think_exception.tpl';
            Config::set(['exception_tmpl' => $tmpl], 'app');
        }
        $abnormity = false;
        $code      = $e->getCode();
        $message   = $e->getMessage();
        $httpCode  = isset($e->httpCode) ? $e->httpCode : HttpStatusEnum::SERVER_ERROR;
        $topData   = isset($e->topData) ? $e->topData : [];
        // 参数验证错误
        if ($e instanceof ValidateException) {
            $message  = $e->getError();
            $httpCode = HttpStatusEnum::VALIDATE_ERROR;
        }
        //代码异常
        if ($e instanceof \ParseError || $e instanceof \Error || $e instanceof PDOException
            || $e instanceof HttpException || $e instanceof HttpResponseException
            || $e instanceof RouteNotFoundException || $e instanceof ErrorException
            || $e instanceof FileException || $e instanceof ClassNotFoundException
            || $e instanceof FuncNotFoundException || $e instanceof \InvalidArgumentException) {
            $code = CommonCodeEnum::FAIL;
            if (!empty(env("app_debug"))) {
                $message = $e->getMessage() . ". && Wrong file: in " . $e->getFile() . " at " . $e->getLine() . " line";
            } elseif (config("app.show_error_msg")) {
                $message = $e->getMessage();
            } else {
                $message = "System exception";
            }
            $abnormity = true;
        }
        if ($code === 0) {
            $code = CommonCodeEnum::FAIL;
        }
        if ($request->isAjax() || $request->isPjax()) {
            $returnData = $this->createReturn($request, $code, $message, $topData, $httpCode, $abnormity);
            return json($returnData, $httpCode);
        }
        // 其他错误交给系统处理
        return parent::render($request, $e);
    }

    /**
     * 创建返回数组
     * @param \think\Request $request
     * @param $code
     * @param $message
     * @param $data
     * @param $statusCode
     * @param bool $abnormity
     * @return array
     */
    private function createReturn($request, $code, $message, $data, $statusCode, $abnormity = false)
    {
        $returnData = [
            "code"    => $code,
            "message" => $message,
            "data"    => $data,
        ];
        if (config("app.show_http_status")) {
            $returnData['StatusCode'] = (int)$statusCode;
        }
        if (!empty(env("app_debug")) && !$abnormity) {
            $returnData['operate'] = app('http')->getName() . '/' . $request->controller() . '/' . $request->action();
        }
        return $returnData;
    }
}
