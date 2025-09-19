<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

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

    public function export(Request $request)
    {
        $start = $request->input('start_date');
        $end = $request->input('end_date');

        $query = Booking::with(['ticket','user']);
        if ($start) $query->whereDate('visit_date', '>=', $start);
        if ($end) $query->whereDate('visit_date', '<=', $end);
        $filename = 'bookings_'.($start ?: 'all').'_to_'.($end ?: 'all').'.csv';

        $response = new StreamedResponse(function () use ($query) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Date','Code','User','Ticket','Qty','Total','Status']);
            $query->orderBy('visit_date')->chunk(500, function($rows) use ($handle) {
                foreach ($rows as $b) {
                    fputcsv($handle, [
                        optional($b->visit_date)->format('Y-m-d'),
                        $b->booking_code,
                        optional($b->user)->name,
                        optional($b->ticket)->name,
                        $b->quantity,
                        $b->total_amount,
                        $b->status,
                    ]);
                }
            });
            fclose($handle);
        });
        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename="'.$filename.'"');
        return $response;
    }
}
