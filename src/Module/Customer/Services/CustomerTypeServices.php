<?php

namespace App\Module\Customer\Services;

use App\Module\Customer\Entity\CustomerType;
use App\Module\Customer\Repository\CustomerTypeRepository;
use Illuminate\Database\Eloquent\Collection;
use League\Event\Emitter;
use Psr\Container\ContainerInterface;
use Symfony\Component\Cache\Simple\FilesystemCache;

/**
 * Class CustomerTypeServices
 *
 * @package App\Module\Customer\Services
 */
class CustomerTypeServices
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var CustomerTypeRepository
     */
    private $repository;

    /** @var  Emitter */
    private $emit;

    /** @var  FilesystemCache */
    private $cache;

    /**
     * CustomerTypeServices constructor.
     *
     * @param ContainerInterface $container
     * @param CustomerTypeRepository $repository
     */
    public function __construct(ContainerInterface $container, CustomerTypeRepository $repository)
    {
        $this->container = $container;
        $this->cache = $container['cache'];
        $this->emit = $container['eventEmitter'];
        $this->repository = $repository;
    }

    /**
     * @param array $data
     *
     * @return CustomerType
     */
    public function create(array $data)
    {
        $type = $this->repository->create($data);
        $this->emit->emit('customer.type.create', $type);
        $this->clearCache();
        return $type;
    }

    /**
     * @param CustomerType $type
     * @param array $data
     */
    public function update(CustomerType $type, array $data)
    {
        $type->update($data);
        $this->emit->emit('customer.type.update', $type);
        $this->clearCache();
    }

    /**
     * @param int $id
     *
     * @return CustomerType|null
     */
    public function findOne(int $id)
    {
        return $this->repository->findOne($id);
    }

    /**
     * @return CustomerType[]|Collection
     */
    public function findAll()
    {
        $cacheKey = 'customer.type.list';
        if ($this->cache->has($cacheKey)) {
            return $this->cache->get($cacheKey);
        }
        $result = $this->repository->findAll();
        $this->cache->set($cacheKey, $result);
        return $result;
    }

    /**
     * Clear Cache for customer.type.list
     */
    public function clearCache()
    {
        $this->cache->delete('customer.type.list');
    }
}
