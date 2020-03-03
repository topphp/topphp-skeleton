<?php
declare (strict_types=1);

namespace app\subscribe;

use think\Event;
use Topphp\TopphpSwoole\server\TopServerEvent;

class HttpServer
{
    public function onRequest($event)
    {
        // todo 这里可以处理请求后的事件回调
    }

    public function subscribe(Event $event)
    {
        $event->listen(TopServerEvent::ON_REQUEST, [$this, 'onRequest']);
    }
}
