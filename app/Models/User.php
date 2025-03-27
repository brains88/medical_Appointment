<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes; // Import SoftDeletes trait

class User extends Authenticatable // Extend Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes; // Add SoftDeletes trait

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Define the relationship with the Patient model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function patient()
    {
        return $this->hasOne(Patient::class, 'user_id', 'id'); // Correct foreign and local keys
    }

    public function doctor()
    {
     return $this->hasOne(Doctor::class, 'user_id', 'id');
    }
}