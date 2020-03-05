<?php
declare (strict_types=1);

namespace app\service;

use think\App;
use Topphp\TopphpSwoole\annotation\Rpc;
use Topphp\TopphpSwoole\services\RpcProviderService;

/**
 * @Rpc(serviceName="filmService",protocol="jsonrpc",serverName="film-server")
 */
class FilmService extends RpcProviderService
{
    public function test($a, $b)
    {
        return $a + $b;
    }
}
