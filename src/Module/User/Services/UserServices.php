<?php

namespace App\Module\User\Services;

use App\Module\User\Entity\User;
use App\Module\User\Repository\UserRepository;
use Illuminate\Database\Eloquent\Collection;
use League\Event\Emitter;
use Psr\Container\ContainerInterface;
use Symfony\Component\Cache\Simple\FilesystemCache;

/**
 * Class UserServices
 *
 * @package App\Module\User\Services
 */
class UserServices
{

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var UserRepository
     */
    private $repository;

    /** @var  Emitter */
    private $emit;

    /** @var  FilesystemCache */
    private $cache;

    /**
     * UserServices constructor.
     *
     * @param ContainerInterface $container
     * @param UserRepository $repository
     */
    public function __construct(ContainerInterface $container, UserRepository $repository)
    {
        $this->container = $container;
        $this->cache = $container['cache'];
        $this->emit = $container['eventEmitter'];
        $this->repository = $repository;
    }

    /**
     * Create User
     *
     * @param array $data
     *
     * @return User
     */
    public function create(array $data) : User
    {
        $user = $this->repository->create($data);
        $this->emit->emit('user.create', $user);
        $this->clearCache();
        return $user;
    }

    /**
     * Update User
     *
     * @param User $user
     * @param array $data
     */
    public function update(User $user, array $data)
    {
        $user->update($data);
        $this->emit->emit('user.update', $user);
        $this->clearCache();
    }

    /**
     * Find User By id
     *
     * @param $id
     *
     * @return User|null
     */
    public function findOne($id)
    {
        return $this->repository->findOne($id);
    }

    /**
     * @return User[]|Collection
     */
    public function getAll() : Collection
    {
        $cacheKey = 'user.list';
        if ($this->cache->has($cacheKey)) {
            return $this->cache->get($cacheKey);
        }
        $result = $this->repository->getAll();
        $this->cache->set($cacheKey, $result);
        return $result;
    }


    /**
     * @param $field
     * @param $value
     *
     * @return User|null
     */
    public function findOneByField($field, $value)
    {
        return $this->repository->findOneByField($field, $value);
    }

    /**
     * @param $email string
     *
     * @return bool
     */
    public function isEmailExist($email) : bool
    {
        $user = $this->findOneByField('email', $email);
        if ($user) {
            return true;
        }
        return false;
    }

    public function isUserExist(int $id):bool
    {
        $user = $this->findOne($id);
        if ($user) {
            return true;
        }
        return false;
    }

    /**
     * Clear Cache for user.list
     */
    public function clearCache()
    {
        $this->cache->delete('user.list');
    }
}
