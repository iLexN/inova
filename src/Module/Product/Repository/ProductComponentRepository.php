<?php

namespace App\Module\Product\Repository;

use App\Module\Product\Entity\Component;

/**
 * Class ProductComponentRepository
 *
 * @package App\Module\Product\Repository
 */
class ProductComponentRepository
{

    /**
     * @param array $data
     *
     * @return Component
     */
    public function create(array $data) : Component
    {
        return Component::create($data);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function findAll()
    {
        return Component::get();
    }

    /**
     * @param integer $id
     *
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null|static|static[]
     */
    public function findOne($id)
    {
        return Component::find($id);
    }

    /**
     * @param int $id
     */
    public function delete(int $id)
    {
        Component::destroy($id);
    }
}
