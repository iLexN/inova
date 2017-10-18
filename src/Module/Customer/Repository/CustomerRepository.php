<?php

namespace App\Module\Customer\Repository;

use App\Module\Customer\Entity\Customers;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class CustomerRepository
 *
 * @package App\Module\Customer\Repository
 */
class CustomerRepository
{

    /**
     * @param array $data
     *
     * @return Customers
     */
    public function create(array $data) : Customers
    {
        return Customers::create($data);
    }

    /**
     * @param int $id
     *
     * @return Customers|null
     */
    public function findOne(int $id)
    {
        return Customers::find($id);
    }

    /**
     * @return Collection
     */
    public function findAll()
    {
        return Customers::get();
    }

    /**
     * @param string $field
     * @param string $value
     *
     * @return Customers|null
     */
    public function findOneByField(string $field, string $value)
    {
        return Customers::where($field, '=', $value)->first();
    }
}
