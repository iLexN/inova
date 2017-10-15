<?php

namespace App\Module\Customer\Event;

use App\Module\Customer\Services\CustomerServices;
use League\Event\AbstractListener;
use League\Event\EventInterface;
use Psr\Container\ContainerInterface;

/**
 * Class CustomerListClearCache
 * Clear Customer List Cache
 *
 * @package App\Module\Customer\Event
 */
class CustomerListClearCache extends AbstractListener
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
     * Clear Customer list cache.
     *
     * @param EventInterface $event
     */
    public function handle(EventInterface $event)
    {
        /** @var CustomerServices $services */
        $services = $this->container['customerService'];
        $services->clearCache();
    }
}
