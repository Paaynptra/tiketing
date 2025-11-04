<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Ticket;
use App\Models\Visitor;
use App\Services\Qr\QrService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    public function index()
    {
        $tickets = Ticket::where('active', true)->orderBy('price')->get();
        return view('booking.index', compact('tickets'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'ticket_id' => ['required', 'exists:tickets,id'],
            'visit_date' => ['required', 'date', 'after_or_equal:today'],
            'quantity' => ['required', 'integer', 'min:1', 'max:10'],
            'contact_name' => ['required', 'string', 'max:255'],
            'contact_email' => ['nullable', 'email'],
            'contact_phone' => ['nullable', 'string', 'max:50'],
            'notes' => ['nullable', 'string'],
        ]);

        $ticket = Ticket::findOrFail($validated['ticket_id']);

        $total = $ticket->price * (int) $validated['quantity'];

        $booking = Booking::create([
            'user_id' => Auth::id(),
            'ticket_id' => $ticket->id,
            'visit_date' => $validated['visit_date'],
            'quantity' => $validated['quantity'],
            'total_amount' => $total,
            'status' => 'pending',
            'booking_code' => strtoupper(Str::random(8)),
            'notes' => $validated['notes'] ?? null,
        ]);

        Visitor::create([
            'booking_id' => $booking->id,
            'full_name' => $validated['contact_name'],
            'email' => $validated['contact_email'] ?? null,
            'phone' => $validated['contact_phone'] ?? null,
        ]);

        return redirect()->route('booking.history')->with('success', 'Pemesanan berhasil dibuat. Kode booking: ' . $booking->booking_code);
    }

    public function history()
    {
        $bookings = Booking::with('ticket')
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('booking.history', compact('bookings'));
    }


    public function showQrCode(string $booking_code, QrService $qr)
    {
        $booking = Booking::where('booking_code', $booking_code)->firstOrFail();

        if ($booking->status !== 'confirmed') {
            abort(404);
        }

        return view('booking.show_qrcode', compact('booking', 'qr'));
    }
}
