<?php

namespace App\Module\Customer\Entity;

use App\Module\User\Entity\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $code
 * @property int $region_id
 * @property int $country_id
 * @property CustomerType $type
 * @property Regions $region
 * @property Countries $country
 * @property CustomerExtraInfo[]|Collection|null $extra
 * @property User[]|Collection|null $staff
 */
class Customers extends Model
{
    public $timestamps = false;
    protected $guarded = [];

    protected $casts =[
        'region_id' => 'integer',
        'country_id' => 'integer',
    ];

    public function type()
    {
        return $this->belongsToMany(CustomerType::class, 'customers_customer_type', 'customer_id', 'type_id');
    }

    public function region()
    {
        return $this->belongsTo(Regions::class)->withDefault([
            'name' => '',
        ]);
    }

    public function country()
    {
        return $this->belongsTo(Countries::class)->withDefault([
            'name' => '',
        ]);
    }

    public function extra()
    {
        return $this->hasMany(CustomerExtraInfo::class);
    }

    public function staff()
    {
        return $this->belongsToMany(User::class, 'customer_user', 'customers_id', 'user_id');
    }
}
