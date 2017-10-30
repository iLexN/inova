<?php

namespace App\Module\Product\Entity;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * @var string
     */
    protected $table = 'product';

    protected $casts = [
        'product_input_current' => 'float',
        'tp_withvat_rmb' => 'float',
        'tp_novat_rmb' => 'float',
        'list_price_fobsh_usd' => 'float',
        'usd_tp_novat' => 'float',
        'price' => 'float'
    ];

    protected $appends = [
        'usd_tp_novat',
        'price'
    ];

    public function component()
    {
        return $this->belongsToMany(Component::class, 'product_n_component', 'product_id', 'component_id');
    }

    public function getTpNovatRmbAttribute($value)
    {
        return $this->numberFormat($this->calTpNovat());
    }

    public function getUsdTpNovatAttribute()
    {
        return  $this->numberFormat($this->calUsdTpNovat());
    }
    public function getPriceAttribute()
    {
        $cal = $this->calUsdTpNovat() * (1 + (2.5 / 100)) ;
        return $this->numberFormat($cal);
    }

    private function calTpNovat()
    {
        if ($this->attributes['tp_withvat_rmb'] == '0.0000') {
            return $this->attributes['tp_novat_rmb'];
        } else {
            return $this->attributes['tp_withvat_rmb'] / 1.17;
        }
    }

    public function calUsdTpNovat()
    {
        return $cal = $this->calTpNovat() / 6.7772;
    }

    public function numberFormat($value)
    {
        return \number_format($value, 2);
    }
}
