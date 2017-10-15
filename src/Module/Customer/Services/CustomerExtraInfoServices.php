<?php

namespace App\Module\Customer\Services;

use App\Module\Customer\Entity\CustomerExtraInfo;
use App\Module\Customer\Repository\CustomerExtraInfoRepository;
use Psr\Container\ContainerInterface;
use Symfony\Component\Cache\Simple\FilesystemCache;

/**
 * Class CustomerExtraInfoServices
 *
 * @package App\Module\Customer\Services
 */
class CustomerExtraInfoServices
{
    /**
     * @var CustomerExtraInfoRepository
     */
    private $repository;

    /** @var  FilesystemCache */
    private $cache;

    /**
     * CustomerExtraInfoServices constructor.
     *
     * @param ContainerInterface $container
     * @param CustomerExtraInfoRepository $repository
     */
    public function __construct(ContainerInterface $container, CustomerExtraInfoRepository $repository)
    {
        $this->repository = $repository;
        $this->cache = $container['cache'];
    }

    /**
     * @param int $id
     *
     * @return CustomerExtraInfo|null
     */
    public function findOne(int $id)
    {
        return $this->repository->findOne($id);
    }

    /**
     * @param array $data
     *
     * @return CustomerExtraInfo
     */
    private function create(array $data)
    {
        $extra = $this->repository->create($data);
        return $extra;
    }

    /**
     * @param CustomerExtraInfo $entity
     * @param array $data
     */
    private function update(CustomerExtraInfo $entity, array $data)
    {
        $entity->save($data);
    }

    /**
     * @param int $id
     */
    public function delete(int $id)
    {
        $this->repository->delete($id);
    }

    /**
     * @param array $data
     *
     * @return array
     */
    public function processCustomerExtraInfo(array $data)
    {
        $extraEntities = [];
        foreach ($data as $extra) {
            $extraEntities[] = $this->createOrUpdate($extra);
        }
        return $extraEntities;
    }

    /**
     * @param array $data
     *
     * @return CustomerExtraInfo|null
     */
    private function createOrUpdate(array $data)
    {
        $id = $data['id']??false;
        if ($id) {
            $extra = $this->findOne($id);
            $this->update($extra, $data);
            return $extra;
        }

        return $this->create($data);
    }
}
