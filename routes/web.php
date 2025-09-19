<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use Illuminate\Support\Facades\Route;
use App\Models\Ticket;
use App\Services\Qr\QrService;

Route::get('/', function () {
    // Server-rendered highlights (Sorotan) so cards are visible without JS
    $highlights = [
        [
            'title' => 'Gerbang Surga',
            'img' => 'https://images.unsplash.com/photo-1528164344705-47542687000d?q=80&w=1400&auto=format&fit=crop',
            'desc' => 'Ikon Pura Lempuyang dengan latar Gunung Agung.',
            'full' => 'Gerbang Candi Bentar di Pura Lempuyang kerap disebut "Gates of Heaven" dengan pemandangan Gunung Agung yang megah, ideal untuk kunjungan sunrise.',
        ],
        [
            'title' => 'Tangga Menuju Suci',
            'img' => 'https://images.unsplash.com/photo-1558980664-10eb5e3102b5?q=80&w=1400&auto=format&fit=crop',
            'desc' => 'Ratusan anak tangga menuju area utama.',
            'full' => 'Tangga panjang ini mengantar pengunjung menuju area suci. Mohon menjaga kebersihan dan ketertiban selama menaiki tangga.',
        ],
        [
            'title' => 'Panorama Pegunungan',
            'img' => 'https://images.unsplash.com/photo-1558980823-0da3d51b3101?q=80&w=1400&auto=format&fit=crop',
            'desc' => 'Bentang alam Bali Timur yang menawan.',
            'full' => 'Panorama pegunungan dan langit Bali menghadirkan suasana menenangkan. Waktu terbaik berkunjung adalah pagi hari untuk cahaya yang lembut.',
        ],
    ];

    return view('welcome', compact('highlights'));
})->name('home');

// Public Packages page (informative). Booking action still requires login
Route::get('/packages', function () {
    $tickets = Ticket::where('active', true)->orderBy('price')->get();
    return view('packages.index', compact('tickets'));
})->name('packages');

// Simple QR preview route (demo)
Route::get('/qr/{uid}', function (string $uid, QrService $qr) {
    $dataUri = $qr->generateSigned($uid);
    return response("<img alt='QR untuk tiket' src='{$dataUri}' />");
});

Route::get('/dashboard', function () {
    return redirect()->route('home');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Booking routes
    Route::get('/booking', [BookingController::class, 'index'])->name('booking.index');
    Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');
    Route::get('/booking/history', [BookingController::class, 'history'])->name('booking.history');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/reports', [ReportController::class, 'index'])->name('reports');
    Route::get('/reports/export', [ReportController::class, 'export'])->name('reports.export');
    Route::patch('/bookings/{booking}/status', [AdminBookingController::class, 'updateStatus'])->name('bookings.status');
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
});

require __DIR__.'/auth.php';
