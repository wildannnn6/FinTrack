<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fintrack - Dashboard Keuangan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #ec4899, #8b5cf6, #3b82f6);
        }
        .card-shadow {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
        .urgent-important { border-left: 4px solid #ef4444; }
        .not-urgent-important { border-left: 4px solid #3b82f6; }
        .urgent-not-important { border-left: 4px solid #f59e0b; }
        .not-urgent-not-important { border-left: 4px solid #10b981; }
    </style>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen">
        <!-- Header -->
        <header class="gradient-bg text-white p-6">
            <div class="container mx-auto">
                <div class="flex justify-between items-center">
                    <h1 class="text-2xl font-bold">Fintrack</h1>
                    <nav class="flex space-x-4">
                        <a href="#" class="hover:text-pink-200 transition">Dashboard</a>
                        <a href="#" class="hover:text-pink-200 transition">Tables</a>
                        <a href="#" class="hover:text-pink-200 transition">Billing</a>
                        <a href="#" class="hover:text-pink-200 transition">Profile</a>
                    </nav>
                </div>
            </div>
        </header>

        <main class="container mx-auto p-6">
            <!-- Display Uang -->
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-2xl card-shadow p-6">
                    <h3 class="text-gray-500 text-sm font-medium">Total Balance</h3>
                    <p class="text-3xl font-bold text-gray-800 mt-2">Rp {{ number_format($total_balance, 0, ',', '.') }}</p>
                    <p class="text-green-500 text-sm mt-2">+5.2% dari bulan lalu</p>
                </div>
                
                <div class="bg-white rounded-2xl card-shadow p-6">
                    <h3 class="text-gray-500 text-sm font-medium">Pemasukan Bulanan</h3>
                    <p class="text-2xl font-bold text-gray-800 mt-2">Rp {{ number_format($monthly_income, 0, ',', '.') }}</p>
                    <p class="text-green-500 text-sm mt-2">+8% dari bulan lalu</p>
                </div>
                
                <div class="bg-white rounded-2xl card-shadow p-6">
                    <h3 class="text-gray-500 text-sm font-medium">Pengeluaran Bulanan</h3>
                    <p class="text-2xl font-bold text-gray-800 mt-2">Rp {{ number_format($monthly_expense, 0, ',', '.') }}</p>
                    <p class="text-red-500 text-sm mt-2">+3% dari bulan lalu</p>
                </div>
                
                <div class="bg-white rounded-2xl card-shadow p-6">
                    <h3 class="text-gray-500 text-sm font-medium">Tabungan</h3>
                    <p class="text-2xl font-bold text-gray-800 mt-2">Rp {{ number_format($savings, 0, ',', '.') }}</p>
                    <p class="text-green-500 text-sm mt-2">+12% dari bulan lalu</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Grafik Pengeluaran dan Pemasukan -->
                <div class="bg-white rounded-2xl card-shadow p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-6">Grafik Pengeluaran & Pemasukan</h2>
                    <div class="h-80">
                        <canvas id="financeChart"></canvas>
                    </div>
                </div>

                <!-- Eisenhower Matrix -->
                <div class="bg-white rounded-2xl card-shadow p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-6">Catatan Pengeluaran</h2>
                    <div class="grid grid-cols-2 gap-4">
                        <!-- Urgent & Important -->
                        <div class="space-y-3">
                            <h3 class="font-semibold text-red-600">Penting & Mendesak</h3>
                            @foreach($eisenhower_data as $item)
                                @if($item['category'] == 'urgent_important')
                                    <div class="urgent-important bg-white p-3 rounded-lg border border-gray-200">
                                        <p class="font-medium">{{ $item['task'] }}</p>
                                        <p class="text-red-600 font-bold">Rp {{ number_format($item['amount'], 0, ',', '.') }}</p>
                                        <p class="text-xs text-gray-500">Jatuh tempo: {{ $item['due_date'] }}</p>
                                    </div>
                                @endif
                            @endforeach
                        </div>

                        <!-- Not Urgent & Important -->
                        <div class="space-y-3">
                            <h3 class="font-semibold text-blue-600">Penting & Tidak Mendesak</h3>
                            @foreach($eisenhower_data as $item)
                                @if($item['category'] == 'not_urgent_important')
                                    <div class="not-urgent-important bg-white p-3 rounded-lg border border-gray-200">
                                        <p class="font-medium">{{ $item['task'] }}</p>
                                        <p class="text-blue-600 font-bold">Rp {{ number_format($item['amount'], 0, ',', '.') }}</p>
                                        <p class="text-xs text-gray-500">Jatuh tempo: {{ $item['due_date'] }}</p>
                                    </div>
                                @endif
                            @endforeach
                        </div>

                        <!-- Urgent & Not Important -->
                        <div class="space-y-3">
                            <h3 class="font-semibold text-yellow-600">Mendesak & Tidak Penting</h3>
                            @foreach($eisenhower_data as $item)
                                @if($item['category'] == 'urgent_not_important')
                                    <div class="urgent-not-important bg-white p-3 rounded-lg border border-gray-200">
                                        <p class="font-medium">{{ $item['task'] }}</p>
                                        <p class="text-yellow-600 font-bold">Rp {{ number_format($item['amount'], 0, ',', '.') }}</p>
                                        <p class="text-xs text-gray-500">Jatuh tempo: {{ $item['due_date'] }}</p>
                                    </div>
                                @endif
                            @endforeach
                        </div>

                        <!-- Not Urgent & Not Important -->
                        <div class="space-y-3">
                            <h3 class="font-semibold text-green-600">Tidak Mendesak & Tidak Penting</h3>
                            @foreach($eisenhower_data as $item)
                                @if($item['category'] == 'not_urgent_not_important')
                                    <div class="not-urgent-not-important bg-white p-3 rounded-lg border border-gray-200">
                                        <p class="font-medium">{{ $item['task'] }}</p>
                                        <p class="text-green-600 font-bold">Rp {{ number_format($item['amount'], 0, ',', '.') }}</p>
                                        <p class="text-xs text-gray-500">Jatuh tempo: {{ $item['due_date'] }}</p>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabungan Section -->
            <div class="bg-white rounded-2xl card-shadow p-6 mt-8">
                <h2 class="text-xl font-bold text-gray-800 mb-6">Progress Tabungan</h2>
                <div class="flex items-center justify-between mb-4">
                    <span class="text-gray-600">Target: Rp 10.000.000</span>
                    <span class="text-blue-600 font-bold">{{ round(($savings / 10000000) * 100) }}%</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-4">
                    <div class="gradient-bg h-4 rounded-full" style="width: {{ ($savings / 10000000) * 100 }}%"></div>
                </div>
                <p class="text-gray-600 text-sm mt-2">Sisa yang dibutuhkan: Rp {{ number_format(10000000 - $savings, 0, ',', '.') }}</p>
            </div>
        </main>
    </div>

    <script>
        // Chart.js Implementation
        const ctx = document.getElementById('financeChart').getContext('2d');
        const financeChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($monthly_data['labels']),
                datasets: [
                    {
                        label: 'Pemasukan',
                        data: @json($monthly_data['income']),
                        borderColor: '#8b5cf6',
                        backgroundColor: 'rgba(139, 92, 246, 0.1)',
                        tension: 0.4,
                        fill: true
                    },
                    {
                        label: 'Pengeluaran',
                        data: @json($monthly_data['expense']),
                        borderColor: '#ec4899',
                        backgroundColor: 'rgba(236, 72, 153, 0.1)',
                        tension: 0.4,
                        fill: true
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            drawBorder: false
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>