<?php

namespace App\Module\User\Entity;

use App\Module\Login\Entity\UserLogin;
use App\Module\Login\EntityTrait\LoginEntityTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property UserLogin $login
 * @property string $email
 * @property int|null $head_id
 */
class User extends Model
{
    protected $guarded = [];

    use LoginEntityTrait;

    protected $casts = [
        'head_id' => 'integer',
    ];

    /**
     * Check User is Action or Not
     * @return bool
     */
    public function isActive() : bool
    {
        return $this->attributes['active'] === 1;
    }
}
