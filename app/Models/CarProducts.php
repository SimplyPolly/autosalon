<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CarProduct extends Model
{
    protected $table = 'car_products';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [
        'name',
        'description',
        'price',
        'quantity', // количество в наличии
        'salon_id', // в каком салоне
        'product_type_id' // тип продукта
    ];


    public function getRouteKeyName()
    {
        return 'id';
    }

    /* 
    связь многие ко многим неколько продуктов может хранится в разных салонах
    наличие в разных салонах!!!
    */
    public function salon(): BelongsToMany
    {
        return $this->belongsToMany(Salon::class, 'salon_car_product');
    }

    public function productType(): BelongsTo
    {
        return $this->belongsTo(CarProductType::class, 'product_type_id');
    }

    public function deal(): HasMany
    {
        return $this->hasMany(Deals::class, 'salon_car_product');
    }
}
