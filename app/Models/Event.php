<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'organiser_id',
        'title', 'description',
        'starts_at','ends_at',
        'location', 'is_online','online_url',
        'capacity', 'price_cents','currency',
        'image_path',
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'is_online' => 'boolean'
    ];

    protected $appends = [
        'starts_at_formatted',
        'ends_at_formatted',
    ];

    public function getStartsAtFormattedAttribute()
    {
        return $this->starts_at
            ? Carbon::parse($this->starts_at)->format('D, j M Y g:ia')
            : null;
    }

    public function getEndsAtFormattedAttribute()
    {
        return $this->ends_at
            ? Carbon::parse($this->ends_at)->format('D, j M Y g:ia')
            : null;
    }

    public function organiser() {
        return $this -> belongsTo(User::class, 'organiser_id');
    }
    public function bookings() {
        return $this -> hasMany(Booking::class);
    }
    public function waitlists() {
        return $this -> hasMany(Waitlist::class)->orderBy('position');
    }

    public function confirmedBookings() {
        return $this->bookings()->where('status', 'confirmed');
    }

    public function isFull(): bool {
        return $this->confirmedBookings()->count() >= (int)$this->capacity;
    }

    public function userHasConfirmedBooking(?int $userId): bool {
        if (!$userId) return false;
        return $this->confirmedBookings()->where('user_id', $userId)->exists();
    }
}
