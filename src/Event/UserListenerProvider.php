<?php

namespace App\Event;

use App\Module\Login\Event\UserCreateGenPassword;
use App\Module\Login\Event\UserCreateSendPassword;
use League\Event\ListenerAcceptorInterface;
use League\Event\ListenerProviderInterface;
use Psr\Container\ContainerInterface;

/**
 * Class AccountListenerProvider
 * @package Tink\Event
 */
class UserListenerProvider implements ListenerProviderInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;


    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * Provide event
     *
     * @param ListenerAcceptorInterface $listenerAcceptor
     *
     * @return $this
     */
    public function provideListeners(ListenerAcceptorInterface $listenerAcceptor)
    {
        $listenerAcceptor->addListener('user.create', new UserCreateGenPassword($this->container));
        $listenerAcceptor->addListener('user.create', new UserCreateSendPassword($this->container));
        return $this;
    }
}
