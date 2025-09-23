<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RepairWork extends Model
{
    protected $table = 'repair_works';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'employee_id', // какой сотрудник чинит
        'start_date', // дата начала
        'end_date', // дата конца
        'status', // статус (запланирован, в ремонте, завершен)
        'sum', // стоимость
        'description', // описание
        'client_id' // чей авто на ремонте
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function client(): HasMany
    {
        return $this->hasMany(Client::class, 'client_id');
    }
} 