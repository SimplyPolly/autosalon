<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CarProductType extends Model
{
    protected $table = 'car_product_types';
    protected $primaryKey = 'id';
    public $timestamps = false; 
    protected $fillable = [
        'name'
    ];

    public function getRouteKeyName()
    {
        return 'id';
    }

    public function getRouteKey()
    {
        return $this->{$this->getRouteKeyName()};
    }

    public function products(): HasMany
    {
        return $this->hasMany(CarProducts::class, 'type_id');
    }
}