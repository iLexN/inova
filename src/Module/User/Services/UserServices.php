<?php

namespace App\Module\User\Services;

use App\Module\Cache\CacheHandlerInterface;
use App\Module\User\Entity\User;
use App\Module\User\Repository\UserRepository;
use Illuminate\Database\Eloquent\Collection;
use League\Event\Emitter;
use Psr\Container\ContainerInterface;

/**
 * Class UserServices
 *
 * @package App\Module\User\Services
 */
class UserServices
{
    /**
     * @var UserRepository
     */
    private $repository;

    /** @var  Emitter */
    private $emit;

    /** @var  CacheHandlerInterface */
    private $cache;

    /**
     * UserServices constructor.
     *
     * @param ContainerInterface $container
     * @param UserRepository $repository
     */
    public function __construct(ContainerInterface $container, UserRepository $repository)
    {
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
     * @param integer $id
     *
     * @return User|null
     */
    public function findOne(int $id)
    {
        return $this->repository->findOne($id);
    }

    /**
     * @return User[]|Collection
     */
    public function findAll() : Collection
    {
        return $this->cache->handler('user.list', [$this->repository, 'findAll']);
    }


    /**
     * @param string $field
     * @param string $value
     *
     * @return User|null
     */
    public function findOneByField(string $field, string $value)
    {
        return $this->repository->findOneByField($field, $value);
    }

    /**
     * check user email is exist.
     *
     * @param $email string
     *
     * @return bool
     */
    public function isEmailExist(string $email) : bool
    {
        $user = $this->findOneByField('email', $email);
        return (bool) $user;
    }

    /**
     * check user exist by id
     *
     * @param int $id
     *
     * @return bool
     */
    public function isUserExist(int $id):bool
    {
        $user = $this->findOne($id);
        return (bool) $user;
    }

    /**
     * Clear Cache for user.list
     */
    public function clearCache()
    {
        $this->cache->delete('user.list');
    }
}
