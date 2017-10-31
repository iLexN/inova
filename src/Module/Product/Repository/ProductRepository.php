<?php

namespace App\Module\Product\Repository;

use App\Module\Product\Entity\Product;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class ProductRepository
 *
 * @package App\Module\Product\Repository
 */
class ProductRepository
{

    /**
     * @param array $data
     *
     * @return Product
     */
    public function create(array $data) : Product
    {
        return Product::create($data);
    }

    /**
     * @param int $id
     *
     * @return Product|null
     */
    public function findOne(int $id)
    {
        return Product::find($id);
    }

    /**
     * @return Collection|Product[]
     */
    public function findAll()
    {
        return Product::get();
    }
}
