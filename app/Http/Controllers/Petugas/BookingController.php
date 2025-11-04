<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->input('status');
        $bookings = Booking::with('ticket', 'user')
            ->when($status, fn($q) => $q->where('status', $status))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('petugas.bookings.index', compact('bookings', 'status'));
    }

    public function updateStatus(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'status' => ['required', 'in:checked_in'],
        ]);

        $booking->update(['status' => $validated['status']]);

        return back()->with('success', 'Status booking diperbarui.');
    }
}
