<?php

namespace App\Module\Customer\Repository;

use App\Module\Customer\Entity\CustomerType;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class CustomerTypeRepository
 *
 * @package App\Module\Customer\Repository
 */
class CustomerTypeRepository
{

    /**
     * @param array $data
     *
     * @return CustomerType
     */
    public function create(array $data = []) : CustomerType
    {
        return CustomerType::create($data);
    }

    /**
     * @param int $id
     *
     * @return CustomerType|null
     */
    public function findOne(int $id)
    {
        return CustomerType::find($id);
    }

    /**
     * @return Collection
     */
    public function findAll()
    {
        return CustomerType::get();
    }
}
