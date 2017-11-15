<?php

namespace App\Module\Product\Entity;

use App\Module\Customer\Entity\Customers;
use App\Module\User\Entity\User;
use App\Module\User\Entity\UserProduct;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Product
 *
 * @package App\Module\Product\Entity
 */
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

    /**
     * @var array
     */
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

    public function customers()
    {
        return $this->belongsToMany(Customers::class, 'customer_product', 'product_id', 'customer_id')
            ->using(UserProduct::class);
    }

    /**
     * Field for rmb tp novat
     *
     * @return float
     */
    public function getTpNovatRmbAttribute() : float
    {
        return $this->numberFormat($this->calTpNovat());
    }

    /**
     * Field for usd tp novat
     *
     * @return float
     */
    public function getUsdTpNovatAttribute() : float
    {
        return  $this->numberFormat($this->calUsdTpNovat());
    }

    /**
     * Field for price
     * todo: 2.5
     *
     * @return float
     */
    public function getPriceAttribute() : float
    {
        $cal = $this->calUsdTpNovat() * (1 + (2.5 / 100)) ;
        return $this->numberFormat($cal);
    }

    /**
     * Cal tp novat when tp withvat rmb is 0.0000
     * todo: 1.17
     *
     * @return float
     */
    private function calTpNovat() : float
    {
        if ($this->attributes['tp_withvat_rmb'] == '0.0000') {
            return (float)$this->attributes['tp_novat_rmb'];
        } else {
            return (float)$this->attributes['tp_withvat_rmb'] / 1.17;
        }
    }

    /**
     * Cal USD from tp novat
     * todo: 6.7772
     *
     * @return float
     */
    private function calUsdTpNovat() : float
    {
        return $this->calTpNovat() / 6.7772;
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
