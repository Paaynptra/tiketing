<?php

namespace Database\Seeders;

use App\Models\Ticket;
use App\Models\Booking;
use App\Models\Visitor;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin user
        User::updateOrCreate(
            ['email' => 'admin@lempuyang.test'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        // Sample tourist user
        User::updateOrCreate(
            ['email' => 'user@lempuyang.test'],
            [
                'name' => 'Contoh Pengguna',
                'password' => Hash::make('password'),
                'role' => 'user',
                'email_verified_at' => now(),
            ]
        );

        // Tickets
        $reg = Ticket::updateOrCreate(['name' => 'Reguler'], [
            'description' => 'Tiket reguler kunjungan Pura Lempuyang',
            'price' => 50000,
            'daily_quota' => 500,
            'active' => true,
        ]);

        $vip = Ticket::updateOrCreate(['name' => 'VIP'], [
            'description' => 'Tiket VIP dengan antrian prioritas',
            'price' => 150000,
            'daily_quota' => 100,
            'active' => true,
        ]);

        $sunrise = Ticket::updateOrCreate(['name' => 'Sunrise'], [
            'description' => 'Kunjungan pagi untuk menikmati matahari terbit',
            'price' => 80000,
            'daily_quota' => 200,
            'active' => true,
        ]);

        $student = Ticket::updateOrCreate(['name' => 'Pelajar/Mahasiswa'], [
            'description' => 'Diskon khusus pelajar dengan kartu identitas',
            'price' => 30000,
            'daily_quota' => 300,
            'active' => true,
        ]);

        // Sample bookings for reports
        $user = User::where('email', 'user@lempuyang.test')->first();
        $admin = User::where('email', 'admin@lempuyang.test')->first();

        if ($user) {
            $this->seedSampleBookings($user->id, [$reg, $vip, $sunrise, $student]);
        }
        if ($admin) {
            $this->seedSampleBookings($admin->id, [$reg, $vip]);
        }
    }

    protected function seedSampleBookings(int $userId, array $tickets): void
    {
        $dates = [
            now()->toDateString(),
            now()->addDay()->toDateString(),
            now()->subDay()->toDateString(),
            now()->addDays(7)->toDateString(),
        ];

        $statuses = ['pending', 'confirmed', 'confirmed', 'cancelled'];

        foreach ($dates as $i => $date) {
            $ticket = $tickets[$i % count($tickets)];
            $qty = 1 + ($i % 4);
            $booking = Booking::updateOrCreate(
                [
                    'booking_code' => strtoupper(substr(md5($userId.$date.$ticket->id), 0, 8)),
                ],
                [
                    'user_id' => $userId,
                    'ticket_id' => $ticket->id,
                    'visit_date' => $date,
                    'quantity' => $qty,
                    'total_amount' => $ticket->price * $qty,
                    'status' => $statuses[$i] ?? 'pending',
                    'notes' => null,
                ]
            );

            Visitor::updateOrCreate(
                [
                    'booking_id' => $booking->id,
                    'email' => "contact{$userId}_{$i}@example.test",
                ],
                [
                    'full_name' => "Kontak {$userId}-{$i}",
                    'phone' => '081234567890',
                ]
            );
        }
    }
}
