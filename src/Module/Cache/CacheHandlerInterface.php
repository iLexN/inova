<?php
namespace App\Module\Cache;

/**
 * Interface CacheHandlerInterface
 *
 * @package App\Module\Cache
 */
interface CacheHandlerInterface
{

    /**
     * Cache Handler, return cache copy when have cache
     *
     * @param string $cacheKey
     * @param callable $callable
     *
     * @return mixed
     */
    public function handler(string $cacheKey, callable $callable);

    /**
     * delete cache by key
     *
     * @param string $key
     *
     * @return void
     */
    public function delete(string $key);
}