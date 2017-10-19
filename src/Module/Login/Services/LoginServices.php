<?php

namespace App\Module\Login\Services;

use App\Module\Login\Entity\UserLogin;
use App\Module\Login\Repository\LoginRepository;
use App\Module\User\Services\UserServices;
use League\Event\Emitter;
use Psr\Container\ContainerInterface;

/**
 * Class LoginServices
 *
 * @package App\Module\Login\Services
 */
class LoginServices
{
    /**
     * @var LoginRepository
     */
    private $repository;

    /** @var  Emitter */
    private $emit;

    /** @var  UserServices */
    private $userServices;

    /**
     * LoginServices constructor.
     *
     * @param ContainerInterface $container
     * @param LoginRepository $repository
     */
    public function __construct(ContainerInterface $container, LoginRepository $repository)
    {
        $this->repository = $repository;
        $this->emit = $container['eventEmitter'];
        $this->userServices = $container['userServices'];
    }

    /**
     * Create UserLogin - not save yet
     *
     * @param $data
     *
     * @return UserLogin
     */
    public function create($data) : UserLogin
    {
        return $this->repository->factory($data);
    }

    /**
     * Update UserLogin
     *
     * @param UserLogin $login
     * @param array $data
     */
    public function update(UserLogin $login, array $data)
    {
        $login->update($data);
        $this->emit->emit('login.update', $login);
    }

    /**
     * User Login
     *
     * @param string $email
     * @param string $pass
     *
     * @return bool
     */
    public function login(string $email, string $pass) :bool
    {
        $user = $this->userServices->findOneByField('email', $email);
        if (!$user) {
            return false;
        }
        if (!$user->isActive()) {
            return false;
        }
        $login = $user->login;
        return $login->isSamePass($pass);
    }

    /**
     * Generate Random string for password
     *
     * @param int $length
     *
     * @return string
     */
    public function generateRandomString($length = 9)
    {
        /** @noinspection SpellCheckingInspection */
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ_-%~';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
