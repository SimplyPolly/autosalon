<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends Model
{
    protected $table = 'clients';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'last_name',
        'first_name',
        'middle_name',
        'passport',
        'phone',
        'address',
        'email', // почта для авторизации
        'password' // пароль для авторизации
    ];

    // поле password не будет показываться при сериализации модели
    protected $hidden = [
        'password'
    ];

    public function deals(): HasMany
    {
        return $this->hasMany(Deals::class, 'client_id');
    }

    public function consultations(): HasMany
    {
        return $this->hasMany(ConsultationRequest::class, 'client_id');
    }
} 