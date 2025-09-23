<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JobTitle extends Model
{
    protected $table = 'job_titles';
    protected $primaryKey = 'id';
    public $timestamps = false; 

    protected $fillable = [
        'title', // наименование 
        'description', //описание
        'daily_salary' // оклад на этой должности
    ];

    public function employees(): HasMany
    {
        return $this->hasMany(Employee::class, 'employee_id');
    }
}
