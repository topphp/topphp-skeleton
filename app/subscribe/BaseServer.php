<?php
declare (strict_types=1);

namespace app\subscribe;

use think\Event;
use Topphp\TopphpSwoole\server\TopServerEvent;

class BaseServer
{
    /**
     * @param array $args =[
     *      'server' => $server,
     *      'taskId' => $taskId,
     *      'fromId' => $fromId,
     *      'data'   => $data
     * ]
     */
    public function onTask($args)
    {
        // 任务处理完成后需要调用finish方法
        // $args['server']->finish();
    }

    /**
     * @param array $args = [
     *      'server' => $server,
     *      'taskId' => $taskId,
     *      'data'   => $data
     * ]
     */
    public function onFinish($args)
    {
    }

    public function subscribe(Event $event)
    {
        $event->listen(TopServerEvent::ON_TASK, [$this, 'onTask']);
        $event->listen(TopServerEvent::ON_FINISH, [$this, 'onFinish']);
//        $event->listen(TopServerEvent::ON_CLOSE, [$this, '']);
//        $event->listen(TopServerEvent::ON_PIPE_MESSAGE, [$this, '']);
//        $event->listen(TopServerEvent::ON_WORKER_STOP, [$this, '']);
//        $event->listen(TopServerEvent::ON_WORKER_ERROR, [$this, '']);
//        $event->listen(TopServerEvent::ON_MANAGER_STOP, [$this, '']);
    }
}
