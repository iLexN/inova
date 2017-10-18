<?php

namespace App\Module\Customer\Entity;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $customers_id
 * @property Customers[]|Collection $customer
 */
class CustomerExtraInfo extends Model
{
    public $timestamps = false;
    protected $guarded = [];

    protected $table = 'customer_extra_info';

    protected $casts = [
        'customers_id' => 'integer',
    ];

    public function customer()
    {
        return $this->belongsToMany(Customers::class);
    }
}
