<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CarBrands extends Model
{
    use HasFactory;

    protected $table = 'car_brands';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'name', // наименнование
        'country' // страна производитель
    ];

    protected $guarded = [
        'id',
    ];


    public function models(): HasMany
    {
        return $this->hasMany(CarModels::class, 'car_brand_id');
    }
}
