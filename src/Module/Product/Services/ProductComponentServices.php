<?php

namespace App\Module\Product\Services;

use App\Module\Cache\CacheHandlerInterface;
use App\Module\Product\Entity\Component;
use App\Module\Product\Repository\ProductComponentRepository;
use Illuminate\Database\Eloquent\Collection;
use Psr\Container\ContainerInterface;

/**
 * Class ProductComponentServices
 *
 * @package App\Module\Product\Services
 */
class ProductComponentServices
{
    /** @var ProductComponentRepository  */
    private $repository;

    /** @var  CacheHandlerInterface */
    private $cache;

    /**
     * ProductComponentServices constructor.
     *
     * @param ContainerInterface $container
     * @param ProductComponentRepository $repository
     */
    public function __construct(ContainerInterface $container, ProductComponentRepository $repository)
    {
        $this->repository = $repository;
        $this->cache = $container['cache'];
    }

    /**
     * @param array $data
     *
     * @return Component
     */
    public function create(array $data)
    {
        return $this->repository->create($data);
    }

    /**
     * @param Component $component
     * @param array $data
     */
    public function update(Component $component, array $data)
    {
        $component->update($data);
    }

    /**
     * @param int $id
     */
    public function delete(int $id)
    {
        $this->repository->delete($id);
    }

    /**
     * @param int $id
     *
     * @return Component|null
     */
    public function findOne(int $id)
    {
        return $this->repository->findOne($id);
    }

    /**
     * @return Collection
     */
    public function findAll() : Collection
    {
        return $this->repository->findAll();
    }

    /**
     * @return Collection
     */
    public function findAllGroupByKey() : Collection
    {
        return $this->findAll()->groupBy('type');
    }

    public function clearCache()
    {
        $this->cache->delete('PC');
    }
}
