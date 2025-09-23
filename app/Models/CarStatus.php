<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CarStatus extends Model
{
    protected $table = 'car_statuses';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'name',
        'description'
    ];

    public function cars(): HasMany
    {
        return $this->hasMany(Cars::class, 'status_id');
    }
} 