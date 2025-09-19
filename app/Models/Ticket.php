<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    /** @use HasFactory<\Database\Factories\TicketFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'daily_quota',
        'active',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
