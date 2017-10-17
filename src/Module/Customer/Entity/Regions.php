<?php

namespace App\Module\Customer\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property Regions|null $countries
 */
class Regions extends Model
{
    public $timestamps = false;
    protected $guarded = [];

    public function countries()
    {
        return $this->hasMany(Countries::class);
    }
}
