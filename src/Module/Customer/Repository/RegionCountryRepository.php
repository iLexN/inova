<?php

namespace App\Module\Customer\Repository;

use App\Module\Customer\Entity\Countries;
use App\Module\Customer\Entity\Regions;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class RegionCountryRepository
 *
 * @package App\Module\Customer\Repository
 */
class RegionCountryRepository
{

    /**
     * Create Region
     *
     * @param array $data
     *
     * @return Regions
     */
    public function createRegion(array $data = []) : Regions
    {
        return Regions::create($data);
    }

    /**
     * Find one Region by id
     *
     * @param int $id
     *
     * @return Regions|null
     */
    public function findOneRegion(int $id)
    {
        return Regions::find($id);
    }

    /**
     * @return Collection
     */
    public function findAll()
    {
        return Regions::get();
    }

    /**
     * Find All Regions with Countries
     *
     * @return Collection
     */
    public function findAllWithLoad()
    {
        $regions = $this->findAll();
        $regions->load('countries');
        return $regions;
    }

    /**
     * @param int $id
     *
     * @return Countries|null
     */
    public function findOneCountry(int $id)
    {
        return Countries::find($id);
    }

    /**
     * Factory Country, not save yet
     *
     * @param array $data
     *
     * @return Countries
     */
    public function factoryCountry(array $data = []) : Countries
    {
        return new Countries($data);
    }
}
