<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Deals extends Model
{
    protected $table = 'deals';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'car_id', // что за машину купил
        'car_product_id', // может! купил товар какой то
        'car_product_amount', // кол-во товара
        'client_id', // что за клиент купил
        'employee_id', // какой сотрудник оформлял сделку
        'date', // когда сделка свершилась
        'sum' // сумма всей сделки
    ];

    protected $casts = [
        'date' => 'date', // поле date в модели будет автоматически преобразовываться в объект Carbon (класс для работы с датами в Laravel)
        'sum' => 'decimal:2' // поле sum будет преобразовываться в число с точностью до 2 знаков после запятой.
    ];

    public function car(): BelongsTo
    {
        return $this->belongsTo(Cars::class, 'car_id');
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function car_product() : HasMany
    {
        return $this->HasMany(Deals::class, 'car_product_id');
    }
} 