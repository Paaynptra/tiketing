<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Services\Qr\QrService;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function verify(Request $request, QrService $qr)
    {
        $request->validate([
            'qr_data' => ['required', 'string'],
        ]);

        $qrData = json_decode($request->qr_data, true);

        if (!isset($qrData['u'], $qrData['s'])) {
            return response()->json(['error' => 'Invalid QR code data.'], 400);
        }

        if (!$qr->verify($qrData['u'], $qrData['s'])) {
            return response()->json(['error' => 'Invalid QR code signature.'], 400);
        }

        $bookingData = json_decode($qrData['u'], true);

        if (!isset($bookingData['code'])) {
            return response()->json(['error' => 'Invalid booking data.'], 400);
        }

        $booking = Booking::where('booking_code', $bookingData['code'])->with('ticket', 'user')->first();

        if (!$booking) {
            return response()->json(['error' => 'Booking not found.'], 404);
        }

        return response()->json($booking);
    }
}
