<?php

namespace App\Module\Customer\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 */
class Countries extends Model
{
    public $timestamps = false;
    protected $guarded = [];
}
