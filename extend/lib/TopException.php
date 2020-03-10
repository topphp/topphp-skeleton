<?php
/**
 * Description - TopException.php
 *
 * Topphp异常处理前置类
 */


namespace lib;


use app\common\enumerate\CommonCodeEnum;
use app\common\enumerate\HttpStatusEnum;

class TopException extends \Exception
{
    public $code = CommonCodeEnum::FAIL;
    public $message = 'System exception';
    public $httpCode = HttpStatusEnum::SERVER_ERROR;
    public $topData = [];

    public function __construct($params = [])
    {
        if (is_array($params)) {
            if (array_key_exists('code', $params) && is_numeric($params['code'])) {
                if ((int)$params['code'] == 0) {
                    $this->code = CommonCodeEnum::FAIL;
                } else {
                    $this->code = (int)$params['code'];
                }
            }
            if (array_key_exists('message', $params)) {
                if (is_array($params['message'])) {
                    $this->message = json_encode($params['message'], JSON_UNESCAPED_UNICODE);
                } elseif (is_object($params['message'])) {
                    $this->message = json_encode($this->objectToArray($params['message']), JSON_UNESCAPED_UNICODE);
                } else {
                    $this->message = $params['message'];
                }
            }
            if (array_key_exists('data', $params)) {
                if (is_object($params['data'])) {
                    $this->topData = $this->objectToArray($params['data']);
                } else {
                    $this->topData = $params['data'];
                }
            }
            if (array_key_exists('StatusCode', $params)) {
                $this->httpCode = $params['StatusCode'];
            }
        }
        parent::__construct($this->message, $this->code);
    }

    private function objectToArray($obj)
    {
        $obj = (array)$obj;
        foreach ($obj as $k => $v) {
            if (gettype($v) == 'resource') {
                return [];
            }
            if (gettype($v) == 'object' || gettype($v) == 'array') {
                $obj[$k] = (array)$this->objectToArray($v);
            }
        }

        return $obj;
    }
}