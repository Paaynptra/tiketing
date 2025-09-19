<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        $range = request('range', 'day'); // day, month, year, all

        $start = match ($range) {
            'day' => Carbon::today(),
            'month' => Carbon::now()->startOfMonth(),
            'year' => Carbon::now()->startOfYear(),
            default => null,
        };

        $base = Booking::query()->whereIn('status', ['confirmed', 'checked_in']);
        if ($start) {
            $base->whereDate('visit_date', '>=', $start);
        }

        $revenueTotal = (clone $base)->sum('total_amount');
        $ticketsSold = (clone $base)->sum('quantity');

        $todayBookings = Booking::whereDate('visit_date', $today)->count();
        $todayVisitors = Booking::whereDate('visit_date', $today)->sum('quantity');
        $pendingBookings = Booking::where('status', 'pending')->count();
        $confirmedBookings = Booking::where('status', 'confirmed')->count();
        $totalUsers = User::count();

        $recent = Booking::with('ticket', 'user')->latest()->limit(10)->get();

        return view('admin.dashboard', compact(
            'todayBookings', 'todayVisitors', 'pendingBookings', 'confirmedBookings', 'recent',
            'revenueTotal', 'ticketsSold', 'totalUsers', 'range'
        ));
    }
}
