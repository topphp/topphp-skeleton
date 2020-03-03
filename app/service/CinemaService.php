<?php
declare (strict_types=1);

namespace app\service;

use Topphp\TopphpSwoole\annotation\Rpc;
use Topphp\TopphpSwoole\services\RpcService;

/**
 * @Rpc(id="cinemaService",protocol="jsonrpc",name="film-server")
 */
class CinemaService extends RpcService
{
    public static function test1($a, $b)
    {
        return $a - $b;
    }
}
