<?php

namespace App\Module\Product\Services;

use App\Module\Cache\CacheHandlerInterface;
use App\Module\Product\Entity\Product;
use Illuminate\Database\Eloquent\Collection;
use Psr\Container\ContainerInterface;
use App\Module\Product\Repository\ProductRepository;

/**
 * Class ProductServices
 *
 * @package App\Module\Product\Services
 */
class ProductServices
{
    /** @var ProductRepository  */
    private $repository;

    /** @var  CacheHandlerInterface */
    private $cache;

    /**
     * ProductServices constructor.
     *
     * @param ContainerInterface $container
     * @param ProductRepository $repository
     */
    public function __construct(ContainerInterface $container, ProductRepository $repository)
    {
        $this->repository = $repository;
        $this->cache = $container['cache'];
    }

    /**
     * @param int $id
     *
     * @return Product|null
     */
    public function findOne(int $id): ?Product
    {
        return $this->repository->findOne($id);
    }

    /**
     * @param string $field
     * @param string $value
     *
     * @return Product|null
     */
    public function findOneByField(string $field, string $value) : ?Product
    {
        return $this->repository->findOneByField($field, $value);
    }

    /**
     * @return Product[]|Collection
     */
    public function findAll() : Collection
    {
        return $this->repository->findAll();
    }

    /**
     * @param int $id
     *
     * @return Product[]|Collection
     */
    public function findCustomerNotHaveProduct(int $id) : Collection
    {
        return $this->repository->findCustomerNotHaveProduct($id);
    }

    /**
     * check Model is exist.
     *
     * @param $value string
     *
     * @return bool
     */
    public function isModelExist(string $value = '') : bool
    {
        return (bool) $this->findOneByField('model_no', $value);
    }

    /**
     * @param Product $product
     * @param array $data
     */
    public function update(Product $product, array $data)
    {
        $product->update($data);
    }

    /**
     * @param array $data
     *
     * @return Product
     */
    public function createProduct(array $data) : Product
    {
        $product = $this->repository->create($data['product_info']);
        $this->syncComponent($product, $data);
        return $product;
    }

    /**
     * @param Product $product
     * @param array $data
     */
    public function updateProduct(Product $product, array $data)
    {
        $this->update($product, $this->clearField($data['product_info']));
        $this->syncComponent($product, $data);
    }

    /**
     * @param array $data
     *
     * @return array
     */
    private function clearField(array $data) : array
    {
        unset($data['usd_tp_novat']);
        unset($data['price']);
        return $data;
    }

    /**
     * @param Product $product
     * @param array $data
     */
    private function syncComponent(Product $product, array $data)
    {
        $type = $data['pc_list'] ?? false;
        if ($type) {
            $product->component()->sync($type);
        }
    }

    /**
     * clear cache
     */
    public function clearCache()
    {
        $this->cache->delete('PC');
    }
}
