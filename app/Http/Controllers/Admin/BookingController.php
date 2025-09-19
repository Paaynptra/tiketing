<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function updateStatus(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'status' => ['required', 'in:pending,confirmed,cancelled,checked_in'],
        ]);

        $booking->update(['status' => $validated['status']]);

        return back()->with('success', 'Status booking diperbarui.');
    }
}

