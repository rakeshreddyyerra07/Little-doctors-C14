<?php

namespace Config;

use CodeIgniter\Cache\CacheInterface;
use CodeIgniter\Cache\Handlers\ApcuHandler;
use CodeIgniter\Cache\Handlers\DummyHandler;
use CodeIgniter\Cache\Handlers\FileHandler;
use CodeIgniter\Cache\Handlers\MemcachedHandler;
use CodeIgniter\Cache\Handlers\PredisHandler;
use CodeIgniter\Cache\Handlers\RedisHandler;
use CodeIgniter\Cache\Handlers\WincacheHandler;
use CodeIgniter\Config\BaseConfig;

class Cache extends BaseConfig
{
    public string $handler = 'file';

    public string $backupHandler = 'dummy';

    public string $prefix = '';

    public int $ttl = 60;

    public string $reservedCharacters = '{}()/\@:';

    /**
     * Cache stored in /tmp because the app folder is read-only on Wasmer.
     *
     * @var array{storePath?: string, mode?: int}
     */
    public array $file = [
        'storePath' => '/tmp/ci4-cache/',
        'mode'      => 0640,
    ];

    public array $memcached = [
        'host'   => '127.0.0.1',
        'port'   => 11211,
        'weight' => 1,
        'raw'    => false,
    ];

    public array $redis = [
        'host'       => '127.0.0.1',
        'password'   => null,
        'port'       => 6379,
        'timeout'    => 0,
        'async'      => false,
        'persistent' => false,
        'database'   => 0,
    ];

    /**
     * @var array<string, class-string<CacheInterface>>
     */
    public array $validHandlers = [
        'apcu'      => ApcuHandler::class,
        'dummy'     => DummyHandler::class,
        'file'      => FileHandler::class,
        'memcached' => MemcachedHandler::class,
        'predis'    => PredisHandler::class,
        'redis'     => RedisHandler::class,
        'wincache'  => WincacheHandler::class,
    ];

    public $cacheQueryString = false;

    /**
     * @var list<int>
     */
    public array $cacheStatusCodes = [];
}