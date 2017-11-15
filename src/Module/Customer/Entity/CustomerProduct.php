<?php

namespace App\Module\Customer\Entity;

use Illuminate\Database\Eloquent\Relations\Pivot;

class CustomerProduct extends Pivot
{
    protected $table = 'customer_product';

    protected $appends = [
        'cal'
    ];

    public function getCalAttribute() : float
    {
        $cal = $this->attributes['selling_price'] * 6.7772;
        return $this->numberFormat($cal);
    }

    /**
     * format number for output
     *
     * @param float $value
     *
     * @return float
     */
    private function numberFormat($value) : float
    {
        return round($value, 2);
    }
}
