<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Premium extends Model
{
    protected $table = 'premiums';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'employee_id', // кому
        'payment_date', // когда выпплата
        'amount', // сколько
        'description'
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