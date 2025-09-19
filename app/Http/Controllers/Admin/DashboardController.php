<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\User;
use App\Models\Ticket;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        $range = request('range', null); // optional preset
        $startInput = request('start_date');
        $endInput = request('end_date');

        $start = $startInput ? Carbon::parse($startInput) : null;
        $end = $endInput ? Carbon::parse($endInput) : null;
        if (!$start && $range) {
            $start = match ($range) {
                'day' => Carbon::today(),
                'month' => Carbon::now()->startOfMonth(),
                'year' => Carbon::now()->startOfYear(),
                default => null,
            };
        }

        $base = Booking::query()->whereIn('status', ['confirmed', 'checked_in']);
        if ($start) $base->whereDate('visit_date', '>=', $start);
        if ($end) $base->whereDate('visit_date', '<=', $end);

        $revenueTotal = (clone $base)->sum('total_amount');
        $ticketsSold = (clone $base)->sum('quantity');

        $todayBookings = Booking::whereDate('visit_date', $today)->count();
        $todayVisitors = Booking::whereDate('visit_date', $today)->sum('quantity');
        $pendingBookings = Booking::where('status', 'pending')->count();
        $confirmedBookings = Booking::where('status', 'confirmed')->count();
        $totalUsers = User::count();

        $recentQ = Booking::with('ticket', 'user')->latest();
        if ($start) $recentQ->whereDate('visit_date', '>=', $start);
        if ($end) $recentQ->whereDate('visit_date', '<=', $end);
        $recent = $recentQ->limit(10)->get();

        // Charts data
        $chartStart = $start ? $start->copy() : Carbon::today()->subDays(6);
        $chartEnd = $end ? $end->copy() : Carbon::today();
        $byDay = Booking::selectRaw('DATE(visit_date) as d, SUM(total_amount) as t, COUNT(*) as c')
            ->whereIn('status', ['confirmed','checked_in'])
            ->whereBetween('visit_date', [$chartStart->toDateString(), $chartEnd->toDateString()])
            ->groupBy('d')
            ->get()
            ->keyBy('d');

        $period = new \DatePeriod($chartStart, new \DateInterval('P1D'), $chartEnd->copy()->addDay());
        $days = collect(iterator_to_array($period))->map(fn($d) => Carbon::instance($d));
        $chartRevenueLabels = $days->map(fn($d) => $d->format('d M'))->toArray();
        $chartRevenueData = $days->map(fn($d) => (int) ($byDay[$d->toDateString()]->t ?? 0))->toArray();
        $chartCountData = $days->map(fn($d) => (int) ($byDay[$d->toDateString()]->c ?? 0))->toArray();

        $byTicket = Booking::selectRaw('ticket_id, SUM(total_amount) as t')
            ->whereIn('status', ['confirmed','checked_in'])
            ->groupBy('ticket_id')
            ->pluck('t','ticket_id')
            ->toArray();
        $ticketNames = Ticket::whereIn('id', array_keys($byTicket))->pluck('name','id')->toArray();
        $chartTicketLabels = array_values($ticketNames);
        $chartTicketData = array_map(fn($id) => (int) ($byTicket[$id] ?? 0), array_keys($ticketNames));

        // Quota cards for a target date (start date or today)
        $targetDate = $start ? $start->toDateString() : $today->toDateString();
        $ticketQuota = Ticket::where('active', true)->get()->map(function($t) use ($targetDate) {
            $used = Booking::whereDate('visit_date', $targetDate)->where('ticket_id', $t->id)->sum('quantity');
            return [
                'id' => $t->id,
                'name' => $t->name,
                'quota' => (int) $t->daily_quota,
                'used' => (int) $used,
            ];
        })->toArray();

        return view('admin.dashboard', compact(
            'todayBookings', 'todayVisitors', 'pendingBookings', 'confirmedBookings', 'recent',
            'revenueTotal', 'ticketsSold', 'totalUsers', 'range', 'start', 'end',
            'chartRevenueLabels', 'chartRevenueData', 'chartCountData', 'chartTicketLabels', 'chartTicketData', 'ticketQuota'
        ));
    }
}
