<?php

namespace App\Module\Product\Repository;

use App\Module\Product\Entity\Product;

class ProductRepository
{
    public function create(array $data) : Product
    {
        return Product::create($data);
    }

    public function findOne(int $id)
    {
        return Product::find($id);
    }

    public function findAll()
    {
        return Product::get();
    }
}
