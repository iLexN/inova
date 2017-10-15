<?php

namespace App\Module\Customer\Services;

use App\Module\Customer\Entity\Countries;
use App\Module\Customer\Entity\Regions;
use App\Module\Customer\Repository\RegionCountryRepository;
use Illuminate\Database\Eloquent\Collection;
use League\Event\Emitter;
use Psr\Container\ContainerInterface;
use Symfony\Component\Cache\Simple\FilesystemCache;

/**
 * Class RegionCountryServices
 *
 * @package App\Module\Customer\Services
 */
class RegionCountryServices
{
    /**
     * @var RegionCountryRepository
     */
    private $repository;

    /** @var  Emitter */
    private $emit;

    /** @var  FilesystemCache */
    private $cache;

    /**
     * RegionCountryServices constructor.
     *
     * @param ContainerInterface $container
     * @param RegionCountryRepository $repository
     */
    public function __construct(ContainerInterface $container, RegionCountryRepository $repository)
    {
        $this->cache = $container['cache'];
        $this->emit = $container['eventEmitter'];
        $this->repository = $repository;
    }

    /**
     * @param array $data
     *
     * @return Regions
     */
    public function createRegion(array $data) : Regions
    {
        $region =$this->repository->createRegion($data);
        $this->emit->emit('customer.region.create', $region);
        $this->clearCache();
        return $region;
    }

    /**
     * @param Regions $region
     * @param array $data
     */
    public function updateRegion(Regions $region, array $data)
    {
        $region->update($data);
        $this->emit->emit('customer.region.update', $region);
        $this->clearCache();
    }

    /**
     * @param int $id
     *
     * @return Regions|null
     */
    public function findOneRegion(int $id)
    {
        return $this->repository->findOneRegion($id);
    }

    /**
     * @return Regions[]|Collection
     */
    public function findAll()
    {
        return $this->repository->findAll();
    }

    /**
     * @return Regions[]|Collection
     */
    public function findAllWithLoad()
    {
        $cacheKey = 'region.withCountry.list';
        if ($this->cache->has($cacheKey)) {
            return $this->cache->get($cacheKey);
        }
        $result = $this->repository->findAllWithLoad();
        $this->cache->set($cacheKey, $result);
        return $result;
    }

    /**
     * @param int $id
     *
     * @return Countries|null
     */
    public function findOneCountry(int $id)
    {
        return $this->repository->findOneCountry($id);
    }

    /**
     * @param Regions $region
     * @param array $data
     *
     * @return Countries
     */
    public function createCountry(Regions $region, array $data) : Countries
    {
        $country = $this->repository->factoryCountry($data);
        $region->countries()->save($country);
        $this->emit->emit('customer.country.create', $country);
        $this->clearCache();
        return $country;
    }

    /**
     * @param Countries $countries
     * @param array $data
     */
    public function updateCountry(Countries $countries, array $data)
    {
        $countries->update($data);
        $this->emit->emit('customer.country.update', $countries);
        $this->clearCache();
    }

    /**
     * Clear Cache for region.withCountry.list
     */
    public function clearCache()
    {
        $this->cache->delete('region.withCountry.list');
    }
}
