<?php
declare (strict_types=1);

namespace app\service;

use Topphp\TopphpSwoole\annotation\Rpc;
use Topphp\TopphpSwoole\services\RpcService;

/**
 * @Rpc(id="filmService",protocol="jsonrpc",name="film-server")
 */
class FilmService extends RpcService
{
    public static function test($a, $b)
    {
        return $a + $b;
    }
}
