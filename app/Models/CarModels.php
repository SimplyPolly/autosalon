<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
class CarModel extends Model
{
    use HasFactory;

    protected $table = 'car_models';
    protected $primaryKey = 'id';
    public $timestamps = false;


    protected $fillable = [
        'name',
        'brand_id', //бренд
        'carcass', // тип кузова 
        'engine', // двигатель (бензин и тд)
        'engine_capacity', // объём двигателя 
    ];
    public function brand(): BelongsTo
    {
        return $this->belongsTo(CarBrand::class, 'brand_id');
    }

    public function cars(): HasMany
    {
        return $this->hasMany(Car::class, 'model_id');
    }
}
