<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Salary extends Model
{
    protected $table = 'salaries';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'employee_id',  // кому зп
        'payment_date', // когда зп
        'amount', // сколько
        'description' //описание
    ];

    protected $casts = [
        'payment_date' => 'date',
        'amount' => 'decimal:2'
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
}
