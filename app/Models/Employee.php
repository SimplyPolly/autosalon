<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Employee extends Authenticatable
{
    use Notifiable;

    protected $table = 'employees';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'salon_id', // в каком салоне работает
        'job_title_id', // на какой должности
        'last_name', 
        'first_name',
        'middle_name',
        'phone',
        'email', // почта для авторизации
        'password' //пароль для авторизации
    ];

    protected $hidden = [
        'password',
    ];

    public function salon(): BelongsTo
    {
        return $this->belongsTo(Salon::class, 'salon_id');
    }

    public function jobTitle(): BelongsTo
    {
        return $this->belongsTo(JobTitle::class, 'job_title_id');
    }

    public function consultation(): HasMany
    {
        return $this->hasMany(ConsultationRequest::class, 'consultation_id');
    }

    public function deals(): HasMany
    {
        return $this->hasMany(Deals::class, 'employee_id');
    }

    public function repairWorks(): HasMany
    {
        return $this->hasMany(RepairWork::class, 'employee_id');
    }

    public function salaries(): HasMany
    {
        return $this->hasMany(Salary::class, 'employee_id');
    }

    public function premiums(): HasMany
    {
        return $this->hasMany(Premium::class, 'employee_id');
    }

    /**
     * Get the name of the unique identifier for the user.
     *
     * @return string
     */
    public function getAuthIdentifierName()
    {
        return $this->getKeyName();
    }

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->password;
    }

    /**
     * Get the column name for the "remember me" token.
     *
     * @return string
     */
    public function getRememberTokenName()
    {
        return 'remember_token';
    }

    public function hasRole($role)
    {
        if ($this->jobTitle) {
            return $this->jobTitle->title === $role;
        }
        return false;
    }
} 