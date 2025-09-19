<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    /** @use HasFactory<\Database\Factories\VisitorFactory> */
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'full_name',
        'nationality',
        'id_number',
        'email',
        'phone',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
