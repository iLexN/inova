<?php

namespace App\Module\Login\Event;

use App\Module\Login\Services\LoginServices;
use App\Module\User\Entity\User;
use League\Event\AbstractListener;
use League\Event\EventInterface;
use ParagonIE\Cookie\Session;
use Psr\Container\ContainerInterface;

/**
 * Class UserCreateGenPassword
 * Handle User Create Event - create password
 *
 * @package App\Module\Login\Event
 */
class UserCreateGenPassword extends AbstractListener
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * UserCreateGenPassword constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * Create User Password
     * @param EventInterface $event
     * @param User|null $user
     */
    public function handle(EventInterface $event, User $user = null)
    {
        if ($user){
            /** @var LoginServices $loginServices */
            $loginServices = $this->container['loginServices'];
            $pass = $loginServices->generateRandomString();
            $login = $loginServices->create(['password'=>$pass]);
            $user->login()->save($login);

            //save in session for send email
            Session::set('user.pass', $pass);
        }
    }
}
