<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Salon extends Model
{
    protected $table = 'salons';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'name', // название
        'address', // адрес
        'phone' // номер телефона
    ];

    public function employees(): HasMany
    {
        return $this->hasMany(Employee::class, 'salon_id');
    }

    public function cars(): HasMany
    {
        return $this->hasMany(Cars::class, 'salon_id');
    }
} 