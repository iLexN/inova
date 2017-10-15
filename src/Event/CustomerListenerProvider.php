<?php

namespace App\Event;

use App\Module\Customer\Event\CustomerListClearCache;
use League\Event\ListenerAcceptorInterface;
use League\Event\ListenerProviderInterface;
use Psr\Container\ContainerInterface;

class CustomerListenerProvider implements ListenerProviderInterface
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
        $listenerAcceptor->addListener('customer.type.update', new CustomerListClearCache($this->container));
        $listenerAcceptor->addListener('customer.region.update', new CustomerListClearCache($this->container));
        $listenerAcceptor->addListener('customer.country.update', new CustomerListClearCache($this->container));
        return $this;
    }
}
