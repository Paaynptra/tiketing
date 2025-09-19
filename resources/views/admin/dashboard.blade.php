<x-admin-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-display text-2xl text-warm-900 leading-tight">Admin Dashboard</h2>
            <form method="GET" class="flex items-center gap-2">
                <label class="text-sm text-warm-700">Tanggal</label>
                <input type="date" name="start_date" value="{{ optional($start)->toDateString() }}" class="rounded border-warm-300 text-sm">
                <span class="text-warm-600">—</span>
                <input type="date" name="end_date" value="{{ optional($end)->toDateString() }}" class="rounded border-warm-300 text-sm">
                <button class="inline-flex items-center px-3 py-2 rounded-md bg-brand-primary-600 text-white text-sm hover:bg-brand-primary-700">Filter</button>
            </form>
        </div>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto px-4">
    <h1 class="font-display text-2xl text-warm-900 mb-4">Ringkasan</h1>
    @if (session('success'))
        <div class="mb-4 max-w-6xl mx-auto p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="p-4 bg-white ring-1 ring-warm-200 rounded shadow-sm">
            <div class="text-warm-600 text-sm">Total Pendapatan</div>
            <div class="text-2xl font-semibold text-warm-900">Rp {{ number_format($revenueTotal, 0, ',', '.') }}</div>
            <div class="text-xs text-warm-600 mt-1">Status: confirmed & checked_in</div>
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

    <div class="bg-white rounded ring-1 ring-warm-200 shadow-sm p-4">
        <div class="flex items-center justify-between mb-3">
            <h2 class="font-semibold text-warm-900">Pemesanan Terbaru</h2>
            <div class="flex items-center gap-3">
                <a href="{{ route('admin.reports', ['start_date'=>optional($start)->toDateString(), 'end_date'=>optional($end)->toDateString()]) }}" class="text-warm-700 hover:text-warm-900 underline">Laporan</a>
                <a href="{{ route('admin.reports.export', ['start_date'=>optional($start)->toDateString(), 'end_date'=>optional($end)->toDateString(), 'format'=>'csv']) }}" class="inline-flex items-center px-3 py-2 rounded-md bg-brand-primary-600 text-white text-sm hover:bg-brand-primary-700">Export CSV</a>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead><tr class="text-left border-b border-warm-200 text-warm-700">
                    <th class="p-2">Tanggal</th>
                    <th class="p-2">Kode</th>
                    <th class="p-2">Pengguna</th>
                    <th class="p-2">Tiket</th>
                    <th class="p-2">Qty</th>
                    <th class="p-2">Total</th>
                    <th class="p-2">Status</th>
                </tr></thead>
                <tbody>
                @foreach ($recent as $b)
                    <tr class="border-b border-warm-200 text-warm-900">
                        <td class="p-2">{{ $b->visit_date->format('d M Y') }}</td>
                        <td class="p-2 font-mono">{{ $b->booking_code }}</td>
                        <td class="p-2">{{ optional($b->user)->name }}</td>
                        <td class="p-2">{{ optional($b->ticket)->name }}</td>
                        <td class="p-2">{{ $b->quantity }}</td>
                        <td class="p-2">Rp {{ number_format($b->total_amount, 0, ',', '.') }}</td>
                        <td class="p-2 capitalize">
                            <form method="POST" action="{{ route('admin.bookings.status', $b) }}" class="flex items-center gap-2">
                                @csrf
                                @method('PATCH')
                                <select name="status" class="rounded border-warm-300 text-sm">
                                    @foreach (['pending','confirmed','cancelled','checked_in'] as $st)
                                        <option value="{{ $st }}" @selected($b->status === $st)>{{ ucfirst(str_replace('_',' ', $st)) }}</option>
                                    @endforeach
                                </select>
                                <button class="bg-brand-primary-600 text-white px-2 py-1 rounded text-xs hover:bg-brand-primary-700">Ubah</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="mt-6 grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded shadow p-4">
            <h3 class="font-semibold mb-2">Pendapatan 7 Hari Terakhir</h3>
            <canvas id="revenue7"></canvas>
        </div>
        <div class="bg-white rounded shadow p-4">
            <h3 class="font-semibold mb-2">Jumlah Booking Harian</h3>
            <canvas id="count7"></canvas>
        </div>
        <div class="bg-white rounded shadow p-4">
            <h3 class="font-semibold mb-2">Pendapatan per Paket</h3>
            <canvas id="byTicket"></canvas>
        </div>
    </div>

    <!-- Quota Cards -->
    <div class="mt-6">
        <h3 class="font-display text-xl text-warm-900 mb-2">Kuota Slot ({{ optional($start)->toDateString() ?? now()->toDateString() }})</h3>
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4">
            @foreach ($ticketQuota as $q)
                @php $pct = $q['quota']>0 ? min(100, round($q['used']/$q['quota']*100)) : 0; @endphp
                <div class="bg-white ring-1 ring-warm-200 rounded p-4">
                    <div class="flex items-center justify-between">
                        <div class="font-semibold text-warm-900">{{ $q['name'] }}</div>
                        <div class="text-sm text-warm-700">{{ $q['used'] }}/{{ $q['quota'] }}</div>
                    </div>
                    <div class="mt-2 h-2 rounded bg-warm-100 overflow-hidden">
                        <div class="h-2 bg-brand-primary-600" style="width: {{ $pct }}%"></div>
                    </div>
                    <div class="mt-1 text-xs text-warm-600">{{ $pct }}% terpakai</div>
                </div>
            @endforeach
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3"></script>
    <script>
        const brand = {
            primary: '#059669',
            accent: '#0D9488',
            gold: '#D97706',
        };
        const warm = ['#292524','#44403C','#57534E','#78716C','#A8A29E'];

        // Revenue last 7 days (line)
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
            options: {
                responsive: true,
                scales: { y: { beginAtZero: true, ticks: { callback: v => 'Rp ' + v.toLocaleString('id-ID') } } },
                plugins: { legend: { display: false } }
            }
        });

        // Revenue by ticket (doughnut)
        const ticketColors = ['#10B981','#2DD4BF','#D97706','#6EE7B7','#FDE68A'];
        new Chart(document.getElementById('byTicket'), {
            type: 'doughnut',
            data: {
                labels: @json($chartTicketLabels),
                datasets: [{
                    data: @json($chartTicketData),
                    backgroundColor: ticketColors,
                    borderWidth: 1,
                    borderColor: '#fff',
                }]
            },
            options: {
                plugins: {
                    legend: { position: 'bottom' }
                }
            }
        });

        // Bookings per day (bar)
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
            options: {
                responsive: true,
                scales: { y: { beginAtZero: true } },
                plugins: { legend: { display: false } }
            }
        });
    </script>
    </div>
</x-admin-layout>
