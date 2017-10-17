<?php

namespace App\Module\User\Repository;

use App\Module\User\Entity\User;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class UserRepository
 *
 * @package App\Module\User\Repository
 */
class UserRepository
{

    /**
     * @param $data
     *
     * @return User
     */
    public function create($data) : User
    {
        return User::create($data);
    }

    /**
     * @param $id int
     *
     * @return User|null
     */
    public function findOne(int $id)
    {
        return User::find($id);
    }

    /**
     * @return Collection|User[]
     */
    public function findAll()
    {
        return User::get();
    }

    /**
     * @param $field
     * @param $value
     *
     * @return User|null
     */
    public function findOneByField($field, $value)
    {
        return User::where($field, '=', $value)->first();
    }
}
