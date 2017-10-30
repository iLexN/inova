<?php

namespace App\Module\Product\Services;

use App\Module\Cache\CacheHandlerInterface;
use App\Module\Product\Entity\Product;
use Illuminate\Database\Eloquent\Collection;
use Psr\Container\ContainerInterface;
use App\Module\Product\Repository\ProductRepository;

class ProductServices
{
    /** @var ProductRepository  */
    private $repository;

    /** @var  CacheHandlerInterface */
    private $cache;

    public function __construct(ContainerInterface $container, ProductRepository $repository)
    {
        $this->repository = $repository;
        $this->cache = $container['cache'];
    }

    public function findOne(int $id)
    {
        return $this->repository->findOne($id);
    }

    public function findAll() : Collection
    {
        return $this->repository->findAll();
    }

    public function update(Product $product, array $data)
    {
        $product->update($data);
    }

    public function createPrudoct(array $data)
    {
        $product = $this->repository->create($data['product_info']);
        $this->syncComponent($product, $data);
        return $product;
    }

    public function updateProduct(Product $product, array $data)
    {
        $this->update($product, $data['product_info']);
        $this->syncComponent($product, $data);
    }

    public function syncComponent(Product $product, array $data)
    {
        $type = $data['pc_list'] ?? false;
        if ($type) {
            $product->component()->sync($type);
        }
    }

    public function clearCache()
    {
        $this->cache->delete('PC');
    }
}
