<?php
declare (strict_types=1);

namespace app\subscribe;

use think\Event;
use Topphp\TopphpSwoole\server\TopServerEvent;

class BaseServer
{
    public function subscribe(Event $event)
    {
//        $event->listen(TopServerEvent::ON_TASK, [$this, '']);
//        $event->listen(TopServerEvent::ON_CLOSE, [$this, '']);
//        $event->listen(TopServerEvent::ON_PIPE_MESSAGE, [$this, '']);
//        $event->listen(TopServerEvent::ON_WORKER_STOP, [$this, '']);
//        $event->listen(TopServerEvent::ON_WORKER_ERROR, [$this, '']);
//        $event->listen(TopServerEvent::ON_MANAGER_STOP, [$this, '']);
    }
}
