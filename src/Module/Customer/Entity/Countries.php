<?php

namespace App\Module\Customer\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $regions_id
 */
class Countries extends Model
{
    public $timestamps = false;
    protected $guarded = [];

    protected $casts =[
      'regions_id' => 'integer',
    ];
}
