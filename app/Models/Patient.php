<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Patient extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
   // app/Models/Patient.php

protected $fillable = [
    'name',
    'mobile',
    'email',
    'image',
    'user_id'
];



    /**
     * Define the relationship with the User model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Define the relationship with the Appointment model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
  // Relationship with appointments
            public function appointments()
            {
                return $this->hasMany(Appointment::class);
            }

            // Get the latest appointment (for backward compatibility)
            public function latestAppointment()
            {
                return $this->hasOne(Appointment::class)->latestOfMany();
            }

            public function totalAppointments()
        {
            return $this->appointments()->count();
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
}