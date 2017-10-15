<?php

namespace App\Module\Login\Event;

use App\Module\User\Entity\User;
use League\Event\AbstractListener;
use League\Event\EventInterface;
use ParagonIE\Cookie\Session;
use Psr\Container\ContainerInterface;

/**
 * Class UserCreateSendPassword
 * Handle User event - send Email
 *
 * @package App\Module\Login\Event
 */
class UserCreateSendPassword extends AbstractListener
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * UserCreateSendPassword constructor.
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * Send Password Email to User
     *
     * @param EventInterface $event
     * @param User|null $user
     */
    public function handle(EventInterface $event, User $user = null)
    {
        $pass = Session::take('user.pass');
        //todo: handle send email
        $this->container['logger']->info('Event User Create send', ['password'=>$pass]);
    }
}
