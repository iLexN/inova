<?php

namespace App\Module\Login\EntityTrait;

use App\Module\Login\Entity\UserLogin;

/**
 * Trait LoginEntityTrait
 *
 * @package App\Module\Login\EntityTrait
 */
trait LoginEntityTrait
{

    /**
     * @return UserLogin|null
     */
    public function login()
    {
        return $this->hasOne(UserLogin::class);
    }
}
