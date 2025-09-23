<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ConsultationRequest extends Model
{
    protected $fillable = [
        'client_id', // какой клиент
        'employee_id', // какой сотрудник
        'status', // статус (запланирована, завершена)
        'description', // описание
        'data',
    ];

    protected $casts = [
        'date' => 'date'
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
}
