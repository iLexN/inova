<?php

namespace App\Module\Product\Entity;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Component
 *
 * @package App\Module\Product\Entity
 */
class Component extends Model
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
    protected $table = 'product_component_list';

    /**
     * get the type list
     */
    const TYPE_LIST = [
        'series',
        'type',
        'nature',
    ];
}
