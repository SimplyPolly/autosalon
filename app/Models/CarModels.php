<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
class CarModels extends Model
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
        return $this->belongsTo(CarBrands::class, 'brand_id', 'id');
    }

    public function cars(): HasMany
    {
        return $this->hasMany(Cars::class, 'model_id');
    }
}
