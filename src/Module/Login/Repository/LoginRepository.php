<?php

namespace App\Module\Login\Repository;

use App\Module\Login\Entity\UserLogin;

/**
 * Class LoginRepository
 *
 * @package App\Module\Login\Repository
 */
class LoginRepository
{

    /**
     * Factory UserLogin Entity
     *
     * @param array $data
     *
     * @return UserLogin
     */
    public function factory(array $data = []) : UserLogin
    {
        return new UserLogin($data);
    }
}
