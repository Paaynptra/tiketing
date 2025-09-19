<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $start = $request->input('start_date');
        $end = $request->input('end_date');

        $query = Booking::with('ticket');

        if ($start) {
            $query->whereDate('visit_date', '>=', $start);
        }
        if ($end) {
            $query->whereDate('visit_date', '<=', $end);
        }

        $bookings = $query->orderBy('visit_date')->paginate(20)->withQueryString();

        $totals = [
            'bookings' => (clone $query)->count(),
            'visitors' => (clone $query)->sum('quantity'),
            'revenue' => (clone $query)->sum('total_amount'),
        ];

        return view('admin.reports', compact('bookings', 'totals', 'start', 'end'));
    }
}
