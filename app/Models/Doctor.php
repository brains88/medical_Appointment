<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Doctor extends Model
{
    use HasFactory, SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'mobile',
        'email',
        'department',
        'availability',
        'user_id',
    ];

    /**
     * Define the relationship with the Department model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */

    /**
     * Define the relationship with the Patient model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
        public function patients()
        {
            return $this->hasMany(Patient::class, 'doctor_id');
        }

        public function user()
        {
            return $this->belongsTo(User::class);
            
        }

       public function appointments()
        {
            return $this->hasMany(Appointment::class, 'doctor_id');
        }

        public function activeAppointments()
        {
            return $this->appointments()
                ->where('status', 'confirmed')
                ->whereDate('appointment_date', '>=', now()->toDateString())
                ->count();
        }

        public function expiredAppointments()
        {
            return $this->appointments()
                ->where(function($query) {
                    $query->where('status', 'confirmed')
                        ->whereDate('appointment_date', '<', now()->toDateString());
                })
                ->orWhere('status', 'cancelled')
                ->count();
        }

        public function todaysAppointments()
        {
            return $this->appointments()
                ->whereDate('appointment_date', now()->toDateString())
                ->count();
        }

        protected $casts = [
        'availability' => 'string',
        ];
}