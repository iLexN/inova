<?php

namespace App\Module\Customer\Services;

use App\Module\Customer\Entity\Customers;
use App\Module\Customer\Repository\CustomerRepository;
use League\Event\Emitter;
use Psr\Container\ContainerInterface;
use Symfony\Component\Cache\Simple\FilesystemCache;

class CustomerServices
{
    /** @var CustomerRepository  */
    private $repository;

    /** @var  CustomerExtraInfoServices */
    private $extraInfoServices;

    /** @var  Emitter */
    private $emit;

    /** @var  FilesystemCache */
    private $cache;

    public function __construct(ContainerInterface $container, CustomerRepository $repository)
    {
        $this->repository = $repository;
        $this->extraInfoServices = $container['customerExtraServices'];
        $this->emit = $container['eventEmitter'];
        $this->cache = $container['cache'];
    }

    private function create(array $data)
    {
        $customer = $this->repository->create($data);
        return $customer;
    }

    private function update(Customers $customer, array $data)
    {
        $customer->update($data);
    }

    /**
     * @param int $id
     *
     * @return Customers|null|static|static[]
     */
    public function findOne(int $id)
    {
        return $this->repository->findOne($id);
    }

    public function findAll()
    {
        $cacheKey = 'customers.list';
        if ($this->cache->has($cacheKey)) {
            return $this->cache->get($cacheKey);
        }
        $result = $this->repository->findAll();
        $this->cache->set($cacheKey, $result);
        return $result;
    }

    public function findOneByField(string $field, string $value)
    {
        return $this->repository->findOneByField($field, $value);
    }

    public function createCustomer(array $data)
    {
        $customer = $this->create($data['customer']);
        $this->updateCustomerRelatedInfo($customer, $data);
        $this->emit->emit('customer.create', $customer);
        $this->clearCache();
        return $customer;
    }

    public function updateCustomer(Customers $customer, array $data)
    {
        $this->update($customer, $data['customer']);
        $this->updateCustomerRelatedInfo($customer, $data);
        $this->emit->emit('customer.update', $customer);
        $this->clearCache();
    }

    private function updateCustomerRelatedInfo(Customers $customer, array $data)
    {
        $this->saveCustomerExtra($customer, $data);
        $this->addType($customer, $data);
        $this->syncStaff($customer, $data);
    }

    private function saveCustomerExtra(Customers $customer, array $data)
    {
        $extra = $data['extra'] ?? false;
        if ($extra) {
            $extraEntities = $this->extraInfoServices->processCustomerExtraInfo($extra);
            $customer->extra()->saveMany($extraEntities);
        }
    }

    private function addType(Customers $customer, array $data)
    {
        $type = $data['type'] ?? false;
        if ($type) {
            $customer->type()->sync($type);
        }
    }

    private function syncStaff(Customers $customer, array $data)
    {
        $sync = $data['staff'] ?? false;
        if ($sync) {
            $customer->staff()->sync($sync);
        }
    }

    public function isCodeExist(string $code)
    {
        if ($code === '') {
            return false;
        }

        $customer = $this->findOneByField('code', $code);
        if ($customer) {
            return true;
        }
        return false;
    }

    public function clearCache()
    {
        $this->cache->delete('customers.list');
    }
}
