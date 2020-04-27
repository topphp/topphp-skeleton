<?php
declare (strict_types=1);

namespace app\behavior\listener;

use think\Event;
use think\facade\Config;
use Topphp\TopphpLog\Log;

class Cache
{
    /**
     * 事件监听处理
     *
     * @param Event $event
     * @return mixed
     */
    public function handle(Event $event)
    {
        $driver = config("cache.default");
        if ($driver === 'redis' && extension_loaded('redis')) {
            // redis配置信息
            $redisConfig = self::getRedisConfig();
            // 检查redis是否连接正常
            try {
                $redis = new \Redis();
                $redis->connect($redisConfig['host'], (int)$redisConfig['port'], (int)$redisConfig['timeout']);
                if ($redisConfig['password']) {
                    $redis->auth($redisConfig['password']);
                }
                $res = $redis->ping();
                if ($res === '+PONG') {
                    Config::set($redisConfig, "cache.stores.redis");
                }
            } catch (\Exception $e) {
                // 不正常自动切换成文件缓存
                $error = iconv("GBK", "UTF-8", $e->getMessage());
                $error = str_replace(PHP_EOL, '', $error);
                Log::write('Redis die...（ ' . $error . ' ）', 'error');
                $driver        = 'file';
                $defaultConfig = [
                    'default' => $driver
                ];
                Config::set($defaultConfig, "cache");
            }
        }
        // 其他处理
    }

    /**
     * redis缓存配置
     * @return array
     */
    private function getRedisConfig()
    {
        $redisConfig = [
            // 连接超时1s自动切换文件缓存，
            'timeout' => 1
        ];
        return array_merge($redisConfig, config('cache.stores.redis'));
    }
}
