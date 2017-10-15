<?php

namespace App\Module\Customer\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property Customers $customers
 */
class CustomerType extends Model
{
    public $timestamps = false;
    protected $guarded = [];

    public function customers()
    {
        return $this->belongsToMany(Customers::class, 'customers_customer_type', 'customer_id', 'type_id');
    }
}
