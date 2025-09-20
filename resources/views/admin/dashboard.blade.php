<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-2xl text-bold text-warm-900 leading-tight">Admin Dashboard</h2>
            <form method="GET" class="flex items-center gap-3 text-sm">
                <label class="text-warm-700">Tanggal</label>
                <input type="date" name="start_date" value="{{ optional($start)->toDateString() }}" class="rounded border-warm-300 text-sm">
                <span class="text-warm-600">—</span>
                <input type="date" name="end_date" value="{{ optional($end)->toDateString() }}" class="rounded border-warm-300 text-sm">
                <button class="inline-flex items-center px-3 py-2 rounded-md bg-indigo-600 text-white text-sm hover:bg-indigo-700">
                    Filter
                </button>
            </form>
        </div>
    </x-slot>

    <div class="min-h-screen overflow-hidden max-w-7xl mx-auto px-4 py-3">
        <h1 class="font-display text-2xl text-warm-900 mb-4">Ringkasan</h1>

        @if (session('success'))
            <div class="mb-4 max-w-6xl mx-auto p-3 bg-green-100 text-green-800 rounded text-base">
                {{ session('success') }}
            </div>
        @endif

        <!-- Summary Cards -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4">
            <div class="p-4 bg-white ring-1 ring-warm-200 rounded shadow-sm">
                <div class="text-warm-600 text-sm">Total Pendapatan</div>
                <div class="text-2xl font-semibold text-warm-900">Rp {{ number_format($revenueTotal, 0, ',', '.') }}</div>
                <div class="text-sm text-warm-600 mt-1">Status: confirmed & checked_in</div>
            </div>
            <div class="p-4 bg-white ring-1 ring-warm-200 rounded shadow-sm">
                <div class="text-warm-600 text-sm">Tiket Terjual</div>
                <div class="text-2xl font-semibold text-warm-900">{{ $ticketsSold }}</div>
            </div>
            <div class="p-4 bg-white ring-1 ring-warm-200 rounded shadow-sm">
                <div class="text-warm-600 text-sm">Total Pengguna</div>
                <div class="text-2xl font-semibold text-warm-900">{{ $totalUsers }}</div>
            </div>
            <div class="p-4 bg-white ring-1 ring-warm-200 rounded shadow-sm">
                <div class="text-warm-600 text-sm">Booking Pending</div>
                <div class="text-2xl font-semibold text-warm-900">{{ $pendingBookings }}</div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 h-[75%]">
            <div class="bg-white rounded shadow p-4">
                <h3 class="font-semibold mb-2 text-lg">Pendapatan 7 Hari Terakhir</h3>
                <div class="w-full h-56">
                    <canvas id="revenue7" class="w-full h-full"></canvas>
                </div>
            </div>
            <div class="bg-white rounded shadow p-4">
                <h3 class="font-semibold mb-2 text-lg">Jumlah Booking Harian</h3>
                <div class="w-full h-56">
                    <canvas id="count7" class="w-full h-full"></canvas>
                </div>
            </div>
            <div class="bg-white rounded shadow p-4 lg:col-span-2">
                <h3 class="font-semibold mb-2 text-lg">Pendapatan per Paket</h3>
                <div class="w-full h-64">
                    <canvas id="byTicket" class="w-full h-full"></canvas>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3"></script>
    <script>
        const brand = { primary: '#059669', accent: '#0D9488', gold: '#D97706' };

        new Chart(document.getElementById('revenue7'), {
            type: 'line',
            data: {
                labels: @json($chartRevenueLabels),
                datasets: [{
                    label: 'Rp',
                    data: @json($chartRevenueData),
                    borderColor: brand.primary,
                    backgroundColor: 'rgba(5,150,105,0.15)',
                    tension: .35,
                    fill: true,
                }]
            },
            options: { responsive: true, maintainAspectRatio: false, plugins:{legend:{display:false}} }
        });

        new Chart(document.getElementById('byTicket'), {
            type: 'doughnut',
            data: {
                labels: @json($chartTicketLabels),
                datasets: [{
                    data: @json($chartTicketData),
                    backgroundColor: ['#10B981','#2DD4BF','#D97706','#6EE7B7','#FDE68A'],
                    borderWidth: 1,
                    borderColor: '#fff',
                }]
            },
            options: { responsive: true, maintainAspectRatio: false, plugins:{legend:{position:'bottom'}} }
        });

        new Chart(document.getElementById('count7'), {
            type: 'bar',
            data: {
                labels: @json($chartRevenueLabels),
                datasets: [{
                    label: 'Booking',
                    data: @json($chartCountData),
                    backgroundColor: brand.accent
                }]
            },
            options: { responsive: true, maintainAspectRatio: false, plugins:{legend:{display:false}} }
        });
    </script>
</x-admin-layout>
