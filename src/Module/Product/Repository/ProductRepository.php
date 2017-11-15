<?php

namespace App\Module\Product\Repository;

use App\Module\Product\Entity\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Builder;

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
    public function findOne(int $id) : ?Product
    {
        return Product::find($id);
    }

    /**
     * @return Collection|Product[]
     */
    public function findAll() : Collection
    {
        return Product::get();
    }

    /**
     * @param string $field
     * @param string $value
     *
     * @return Product|null
     */
    public function findOneByField(string $field, string $value): ?Product
    {
        return Product::where($field, '=', $value)->first();
    }

    /**
     * @return Collection|Product[]
     */
    public function findCustomerNotHaveProduct(int $id) : Collection
    {
        $products = Product::whereDoesntHave('customers', function (Builder $query) use ($id) {
            $query->where('customer_id', $id);
        })->get();

        return $products;
    }
}
