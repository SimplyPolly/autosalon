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

    public function products(): HasMany
    {
        return $this->hasMany(CarProduct::class, 'type_id');
    }
}