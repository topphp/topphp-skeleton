<?php
declare (strict_types=1);

namespace app\service;

use Topphp\TopphpSwoole\annotation\Rpc;
use Topphp\TopphpSwoole\services\RpcProviderService;

/**
 * @Rpc(serviceName="cinemaService",serverName="cinema-server",protocol="jsonrpc")
 */
class CinemaService extends RpcProviderService
{
    public function test1($a, $b)
    {
        return $a - $b;
    }
}
