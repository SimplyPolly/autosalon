<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cars extends Model
{
    protected $table = 'cars';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'salon_id', //в каком салоне
        'brand_id', //бренд
        'model_id', // какая модель (кроссовер, внедорожник и тд)
        'status_id', // статус (в наличии, продан, забронирован)
        'vin', // уникальный номер каждого авто от производителя
        'registration_number', //номер регистрации в Госавтоинспекции
        'year', //год выпуска
        'color', // цвет
        'price', //стоимость
        'mileage', //пробег
        'description', //описание
        'car_option', //доп опции к авто
    ];

    protected $casts = [
    'car_option' => 'array', 
];

    public function salon(): BelongsTo
    {
        return $this->belongsTo(Salon::class, 'salon_id');
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(CarBrands::class, 'brand_id');
    }

    public function model(): BelongsTo
    {
        return $this->belongsTo(CarModels::class, 'model_id');
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(CarStatus::class, 'status_id');
    }

    public function deals(): HasMany
    {
        return $this->hasMany(Deals::class, 'car_id');
    }
} 