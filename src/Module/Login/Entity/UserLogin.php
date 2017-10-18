<?php

namespace App\Module\Login\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $user_id
 * @property string password
 */
class UserLogin extends Model
{
    protected $table = 'users_login';
    public $timestamps = false;

    protected $guarded = [];

    protected $casts = [
        'user_id' => 'integer',
    ];

    /**
     * hash password
     *
     * @param string $value
     */
    public function setPasswordAttribute(string $value)
    {
        $this->attributes['password'] = \password_hash($value, \PASSWORD_DEFAULT);
    }

    /**
     * @param string $pass
     *
     * @return bool
     */
    public function isSamePass(string $pass) : bool
    {
        return \password_verify($pass, $this->attributes['password']);
    }
}
