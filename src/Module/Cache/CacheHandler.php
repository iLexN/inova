<?php

namespace App\Module\Cache;

use Psr\SimpleCache\CacheInterface;

/**
 * Class CacheHandler
 *
 * @package App\Module\Cache
 */
class CacheHandler implements CacheHandlerInterface
{

    /**
     * @var CacheInterface
     */
    private $cache;

    /**
     * CacheHandler constructor.
     *
     * @param CacheInterface $cache
     */
    public function __construct(CacheInterface $cache)
    {
        $this->cache = $cache;
    }

    /**
     * @param string $cacheKey
     * @param callable $callable
     *
     * @return mixed
     */
    public function handler(string $cacheKey, callable $callable)
    {
        if ($this->cache->has($cacheKey)) {
            return $this->cache->get($cacheKey);
        }
        $result = call_user_func($callable);
        $this->cache->set($cacheKey, $result);
        return $result;
    }

    /**
     * @param string $key
     */
    public function delete(string $key)
    {
        $this->cache->delete($key);
    }
}
