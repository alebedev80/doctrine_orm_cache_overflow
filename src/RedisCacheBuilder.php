<?php

declare(strict_types=1);

namespace App;

use Psr\Cache\CacheItemPoolInterface;
use Symfony\Component\Cache\Adapter\RedisAdapter;

readonly class RedisCacheBuilder
{

    public function __construct(private array $config)
    {
    }


    /**
     * @throws \RedisException
     */
    public function build(): CacheItemPoolInterface
    {
        return new RedisAdapter($this->buildRedis());
    }

    /**
     * @throws \RedisException
     */
    public function buildRedis(): \Redis
    {
        $socket = $this->config['redis']['socket'] ?? null;
        $prefix = $this->config['redis']['prefix'] ?? null;

        $redis = new \Redis();

        if ($socket) {
            $redis->pconnect($socket);
        } else {
            $host = $this->config['redis']['host'] ?? '127.0.0.1';
            $port = $this->config['redis']['port'] ?? 6379;
            $timeout = $this->config['redis']['timeout'] ?? 0;
            $redis->pconnect($host, $port, $timeout);
        }

        $database = $this->config['redis']['database'] ?? 0;
        $redis->select($database);

        $redis->setOption(\Redis::OPT_PREFIX, $prefix);
        $redis->setOption(\Redis::OPT_SERIALIZER, \Redis::SERIALIZER_PHP);

        return $redis;
    }
}
