<?php

namespace App\Module\Customer\Services;

use App\Module\Cache\CacheHandlerInterface;
use App\Module\Customer\Entity\Customers;
use App\Module\Customer\Repository\CustomerRepository;
use Illuminate\Database\Eloquent\Collection;
use League\Event\Emitter;
use Psr\Container\ContainerInterface;

/**
 * Class CustomerServices
 *
 * @package App\Module\Customer\Services
 */
class CustomerServices
{
    /** @var CustomerRepository  */
    private $repository;

    /** @var  CustomerExtraInfoServices */
    private $extraInfoServices;

    /** @var  Emitter */
    private $emit;

    /** @var  CacheHandlerInterface */
    private $cache;

    /**
     * CustomerServices constructor.
     *
     * @param ContainerInterface $container
     * @param CustomerRepository $repository
     */
    public function __construct(ContainerInterface $container, CustomerRepository $repository)
    {
        $this->repository = $repository;
        $this->extraInfoServices = $container['customerExtraServices'];
        $this->emit = $container['eventEmitter'];
        $this->cache = $container['cache'];
    }

    /**
     * create customer
     *
     * @param array $data
     *
     * @return Customers
     */
    private function create(array $data)
    {
        $customer = $this->repository->create($data);
        return $customer;
    }

    /**
     * Update customer
     *
     * @param Customers $customer
     * @param array $data
     */
    private function update(Customers $customer, array $data)
    {
        $customer->update($data);
    }

    /**
     * Find One
     *
     * @param int $id
     *
     * @return Customers|null
     */
    public function findOne(int $id)
    {
        return $this->repository->findOne($id);
    }

    /**
     * FindAll
     *
     * @return Collection
     */
    public function findAll()
    {
        return $this->cache->handler('customers.list', [$this->repository, 'findAll']);
    }

    /**
     * Find one by field
     *
     * @param string $field
     * @param string $value
     *
     * @return Customers|null
     */
    public function findOneByField(string $field, string $value)
    {
        return $this->repository->findOneByField($field, $value);
    }

    /**
     * Create Customer with related field
     *
     * @param array $data
     *
     * @return Customers
     */
    public function createCustomer(array $data) : Customers
    {
        $customer = $this->create($data['customer']);
        $this->updateCustomerRelatedInfo($customer, $data);
        $this->emit->emit('customer.create', $customer);
        $this->clearCache();
        return $customer;
    }

    /**
     * Update Customer with related field
     *
     * @param Customers $customer
     * @param array $data
     */
    public function updateCustomer(Customers $customer, array $data)
    {
        $this->update($customer, $data['customer']);
        $this->updateCustomerRelatedInfo($customer, $data);
        $this->emit->emit('customer.update', $customer);
        $this->clearCache();
    }

    /**
     * Update Customer related field
     *
     * @param Customers $customer
     * @param array $data
     */
    private function updateCustomerRelatedInfo(Customers $customer, array $data)
    {
        $this->saveCustomerExtra($customer, $data);
        $this->addType($customer, $data);
        $this->syncStaff($customer, $data);
    }

    /**
     * Save Customer Extra Info
     *
     * @param Customers $customer
     * @param array $data
     */
    private function saveCustomerExtra(Customers $customer, array $data)
    {
        $extra = $data['extra'] ?? false;
        if ($extra) {
            $extraEntities = $this->extraInfoServices->processCustomerExtraInfo($extra);
            $customer->extra()->saveMany($extraEntities);
        }
    }

    /**
     * Sync Customer Type
     *
     * @param Customers $customer
     * @param array $data
     */
    private function addType(Customers $customer, array $data)
    {
        $type = $data['type'] ?? false;
        if ($type) {
            $customer->type()->sync($type);
        }
    }

    /**
     * Sync Staff
     *
     * @param Customers $customer
     * @param array $data
     */
    private function syncStaff(Customers $customer, array $data)
    {
        $sync = $data['staff'] ?? false;
        if ($sync) {
            $customer->staff()->sync($sync);
        }
    }

    /**
     * Check code is already Exist
     *
     * @param string $code
     *
     * @return bool
     */
    public function isCodeExist(string $code) : bool
    {
        if ($code === '') {
            return false;
        }

        $customer = $this->findOneByField('code', $code);
        return (bool) $customer;
    }

    /**
     * Clear Cache
     */
    public function clearCache()
    {
        $this->cache->delete('customers.list');
    }
}
