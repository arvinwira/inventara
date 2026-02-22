<x-app-layout>
  <x-slot name="header">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
      <div>
        <h2 class="font-bold text-2xl text-gray-800 leading-tight">
          {{ $greeting }}, {{ Auth::user()->name }} 👋
        </h2>
        <p class="text-gray-500 text-sm mt-1">Ringkasan aktivitas dan performa penjualan Anda hari ini.</p>
      </div>
      
      <!-- Period Filter -->
      <div class="flex bg-white rounded-lg p-1 shadow-sm border border-gray-100">
        <a href="{{ route('dashboard', ['period' => 'today']) }}" 
           class="px-4 py-2 text-sm font-medium rounded-md transition-colors {{ $period === 'today' ? 'bg-brand-50 text-brand-700' : 'text-gray-500 hover:text-gray-700 hover:bg-gray-50' }}">
          Hari Ini
        </a>
        <a href="{{ route('dashboard', ['period' => '7d']) }}" 
           class="px-4 py-2 text-sm font-medium rounded-md transition-colors {{ $period === '7d' ? 'bg-brand-50 text-brand-700' : 'text-gray-500 hover:text-gray-700 hover:bg-gray-50' }}">
          7 Hari
        </a>
        <a href="{{ route('dashboard', ['period' => '30d']) }}" 
           class="px-4 py-2 text-sm font-medium rounded-md transition-colors {{ $period === '30d' ? 'bg-brand-50 text-brand-700' : 'text-gray-500 hover:text-gray-700 hover:bg-gray-50' }}">
          30 Hari
        </a>
      </div>
    </div>
  </x-slot>

  <div class="py-6 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto space-y-6">

    <!-- KPI Cards Row -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 fade-in-up">
      <x-stat-card 
        title="Pendapatan ({{ $periodLabel }})" 
        value="Rp {{ number_format($totalRevenue, 0, ',', '.') }}" 
        icon='<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>'
        :change="$revenueChange"
        changeLabel="vs periode sblmnya"
        color="brand"
      />
      
      <x-stat-card 
        title="Total Transaksi" 
        value="{{ number_format($totalTransactions, 0, ',', '.') }}" 
        icon='<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>'
        :change="$transactionChange"
        changeLabel="vs periode sblmnya"
        color="blue"
      />
      
      <x-stat-card 
        title="Total Produk Aktif" 
        value="{{ number_format($productCount, 0, ',', '.') }}" 
        icon='<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>'
        color="green"
      />
      
      <x-stat-card 
        title="Peringatan Stok" 
        value="{{ $lowStockCount }}" 
        icon='<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>'
        changeLabel="Perlu restock segera"
        color="red"
      />
    </div>

    <!-- Charts Row -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 fade-in-up delay-100">
      <div class="lg:col-span-2">
        <x-chart-card title="Tren Pendapatan" subtitle="{{ $periodLabel }}">
          <canvas id="salesChart"></canvas>
        </x-chart-card>
      </div>
      <div class="lg:col-span-1">
        <x-chart-card title="Penjualan per Kategori" subtitle="{{ $periodLabel }}">
          <canvas id="categoryChart"></canvas>
        </x-chart-card>
      </div>
    </div>

    <!-- Tables Row -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 fade-in-up delay-200">
      
      <!-- Recent Transactions -->
      <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center">
          <h3 class="font-bold text-gray-800 text-lg">Transaksi Terbaru</h3>
        </div>
        <div class="overflow-x-auto">
          <table class="w-full text-sm text-left">
            <thead class="text-xs text-gray-500 uppercase bg-gray-50">
              <tr>
                <th class="px-6 py-4 font-medium">Waktu</th>
                <th class="px-6 py-4 font-medium">Produk</th>
                <th class="px-6 py-4 font-medium text-right">Qty</th>
                <th class="px-6 py-4 font-medium text-right">Total</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
              @forelse($recentTransactions as $trx)
                <tr class="hover:bg-gray-50 transition-colors">
                  <td class="px-6 py-4 text-gray-500 whitespace-nowrap">{{ $trx['time'] }}</td>
                  <td class="px-6 py-4 font-medium text-gray-800">{{ $trx['product_name'] }}</td>
                  <td class="px-6 py-4 text-right">{{ $trx['qty'] }}</td>
                  <td class="px-6 py-4 text-right font-medium text-brand-600">Rp {{ number_format($trx['total'], 0, ',', '.') }}</td>
                </tr>
              @empty
                <tr>
                  <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                    Belum ada transaksi di periode ini.
                  </td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>

      <!-- Low Stock Alerts -->
      <div class="lg:col-span-1 bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden flex flex-col">
        <div class="p-6 border-b border-gray-100 flex justify-between items-center">
          <h3 class="font-bold text-gray-800 text-lg">Hampir Habis (Top 5)</h3>
          <a href="{{ route('products.index') }}" class="text-sm text-brand-600 hover:text-brand-700 font-medium">Kelola &rarr;</a>
        </div>
        <div class="p-6 flex-grow flex flex-col gap-4">
          @forelse($lowStocks as $p)
            @php
              // Calculate width for small progress bar based on reorder point
              $percentage = $p->reorder_point > 0 ? min(100, ($p->current_stock / ($p->reorder_point * 2)) * 100) : 0;
              $isCritical = $p->current_stock <= 0;
            @endphp
            <div class="flex items-center justify-between">
              <div class="min-w-0 pr-4 flex-1">
                <p class="text-sm font-medium text-gray-800 truncate">{{ $p->name }}</p>
                <div class="flex items-center mt-1">
                  <div class="w-full bg-gray-200 rounded-full h-1.5 mr-2">
                    <div class="h-1.5 rounded-full {{ $isCritical ? 'bg-red-500' : 'bg-yellow-400' }}" style="width: {{ max(5, $percentage) }}%"></div>
                  </div>
                </div>
              </div>
              <div class="text-right whitespace-nowrap">
                <p class="text-lg font-bold {{ $isCritical ? 'text-red-600' : 'text-gray-800' }}">{{ $p->current_stock }} <span class="text-xs font-normal text-gray-500">{{ $p->unit }}</span></p>
                <p class="text-xs text-gray-400">Min: {{ $p->reorder_point }}</p>
              </div>
            </div>
          @empty
            <div class="flex flex-col items-center justify-center py-6 text-center text-gray-500 flex-grow">
              <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
              <p>Stok produk aman.</p>
            </div>
          @endforelse
        </div>
      </div>
      
    </div>
  </div>

  @push('scripts')
  <!-- Chart.js CDN -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Common Chart Options
      Chart.defaults.font.family = "'Poppins', sans-serif";
      Chart.defaults.color = '#64748b';
      
      // 1. Sales Trend Line Chart
      const salesCtx = document.getElementById('salesChart');
      if (salesCtx) {
        new Chart(salesCtx, {
          type: 'line',
          data: {
            labels: {!! json_encode($chartLabels) !!},
            datasets: [{
              label: 'Pendapatan (Rp)',
              data: {!! json_encode($chartData) !!},
              borderColor: '#B71C1C',
              backgroundColor: 'rgba(183, 28, 28, 0.1)',
              borderWidth: 2,
              pointBackgroundColor: '#B71C1C',
              pointRadius: 4,
              pointHoverRadius: 6,
              fill: true,
              tension: 0.4
            }]
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
              legend: { display: false },
              tooltip: {
                callbacks: {
                  label: function(context) {
                    let label = context.dataset.label || '';
                    if (label) { label += ': '; }
                    if (context.parsed.y !== null) {
                      label += new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(context.parsed.y);
                    }
                    return label;
                  }
                }
              }
            },
            scales: {
              y: {
                beginAtZero: true,
                border: { display: false },
                grid: { color: 'rgba(0,0,0,0.05)', drawTicks: false },
                ticks: {
                  callback: function(value) {
                    return value >= 1000000 ? (value / 1000000).toFixed(1) + 'M' : 
                           value >= 1000 ? (value / 1000).toFixed(0) + 'k' : value;
                  }
                }
              },
              x: {
                border: { display: false },
                grid: { display: false }
              }
            }
          }
        });
      }

      // 2. Category Distribution Donut Chart
      const categoryCtx = document.getElementById('categoryChart');
      if (categoryCtx) {
        const categoryLabels = {!! json_encode($categoryLabels) !!};
        const categoryData = {!! json_encode($categoryDataValues) !!};
        
        if(categoryData.length > 0) {
            new Chart(categoryCtx, {
              type: 'doughnut',
              data: {
                labels: categoryLabels,
                datasets: [{
                  data: categoryData,
                  backgroundColor: [
                    '#B71C1C', '#E53935', '#EF5350', '#E57373', '#FFCDD2', '#ffebee'
                  ],
                  borderWidth: 0,
                  hoverOffset: 4
                }]
              },
              options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '70%',
                plugins: {
                  legend: {
                    position: 'bottom',
                    labels: { boxWidth: 12, padding: 15 }
                  },
                  tooltip: {
                    callbacks: {
                      label: function(context) {
                        let val = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(context.parsed);
                        return ' ' + val;
                      }
                    }
                  }
                }
              }
            });
        } else {
             // Show empty state if no data
             const parent = categoryCtx.parentElement;
             categoryCtx.style.display = 'none';
             const emptyMsg = document.createElement('div');
             emptyMsg.className = 'absolute inset-0 flex flex-col items-center justify-center text-gray-400 text-sm';
             emptyMsg.innerHTML = '<svg class="w-10 h-10 mb-2 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path></svg>Tidak ada data penjualan';
             parent.appendChild(emptyMsg);
        }
      }
    });
  </script>
  @endpush
</x-app-layout>
