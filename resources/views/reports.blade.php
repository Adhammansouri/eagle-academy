@extends('layouts.admin')

@section('title', 'التقارير والميزانية')
@section('pageTitle', 'التقارير')

@push('head_scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush

@push('styles')
    <style>
        .filter-section {
            background: var(--glass-bg);
            backdrop-filter: blur(15px);
            border: 1px solid var(--border-color);
            border-radius: var(--radius);
            padding: 25px;
            margin-bottom: 30px;
            animation: fadeIn 0.8s ease forwards;
        }

        .filter-section h2 {
            font-size: 22px;
            color: var(--text-primary);
            border-right: 4px solid var(--primary-red);
            padding-right: 15px;
            margin-bottom: 20px;
        }

        .filter-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            align-items: end;
        }

        .filter-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .filter-group label {
            font-size: 13px;
            color: var(--text-secondary);
            font-weight: 600;
        }

        .filter-group input, .filter-group select {
            background: rgba(0,0,0,0.2);
            border: 1px solid var(--border-color);
            color: white;
            padding: 12px;
            border-radius: 10px;
            font-size: 14px;
        }

        .filter-group input:focus, .filter-group select:focus {
            border-color: var(--primary-red);
            outline: none;
        }
        
        .btn-filter {
            background: var(--primary-red);
            color: white;
            border: none;
            padding: 12px;
            border-radius: 10px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s;
            height: 43px; /* Match input height */
        }

        .btn-filter:hover {
            box-shadow: 0 4px 15px var(--primary-red-glow);
            transform: translateY(-2px);
        }

        .btn-clear {
            background: rgba(255,255,255,0.1);
            color: var(--text-secondary);
            text-align: center;
            text-decoration: none;
            padding: 12px;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-clear:hover {
            background: rgba(255,255,255,0.2);
            color: white;
        }

        /* Results table tweaks */
        .table-wrapper {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius);
            padding: 25px;
            overflow-x: auto;
            margin-top: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            text-align: right;
        }

        th, td {
            padding: 15px;
            border-bottom: 1px solid var(--border-color);
        }
        
        th { color: var(--text-secondary); font-size: 14px; }
        
        tr:hover { background: rgba(255, 255, 255, 0.02); }

        .status-active { color: #2ecc71; font-weight: bold; }
        .status-expired { color: #e74c3c; font-weight: bold; }

        @media (max-width: 768px) {
            .filter-grid {
                grid-template-columns: 1fr;
            }
            .table-wrapper table, .table-wrapper tbody, .table-wrapper tr, .table-wrapper td {
                display: block;
                width: 100%;
            }
            .table-wrapper thead { display: none; }
            .table-wrapper tr {
                background: rgba(0,0,0,0.2);
                margin-bottom: 15px;
                border: 1px solid var(--border-color);
                border-radius: 10px;
            }
            .table-wrapper td {
                display: flex;
                justify-content: space-between;
                border-bottom: 1px solid rgba(255,255,255,0.05);
            }
            .table-wrapper td::before {
                content: attr(data-label);
                font-weight: bold;
                color: var(--text-secondary);
            }
        }
    </style>
@endpush

@section('content')
    <main class="dashboard-wrapper">
        
        <div class="welcome-hero" style="margin-bottom: 30px;">
            <div class="hero-content">
                <h2>مركز التقارير والتحليلات 📊</h2>
                <p>راقب أداء الأكاديمية المالي ومعدلات النمو، وقم بفلترة اللاعبين بذكاء.</p>
            </div>
        </div>

        <!-- Smart Filter Section -->
        <div class="filter-section">
            <h2>فلترة اللاعبين الذكية 🔍</h2>
            <form action="{{ route('reports.index') }}" method="GET" class="filter-grid">
                
                <div class="filter-group">
                    <label>بحث بالاسم أو الكود</label>
                    <input type="text" name="search" placeholder="اسم اللاعب..." value="{{ request('search') }}">
                </div>

                <div class="filter-group">
                    <label>الجهة التابع لها</label>
                    <select name="source">
                        <option value="">الكل</option>
                        <option value="الاكاديميه" {{ request('source') == 'الاكاديميه' ? 'selected' : '' }}>الأكاديمية</option>
                        <option value="فورس جيم" {{ request('source') == 'فورس جيم' ? 'selected' : '' }}>فورس جيم</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label>الفئة العمرية</label>
                    <select name="category">
                        <option value="">الكل</option>
                        <option value="براعم" {{ request('category') == 'براعم' ? 'selected' : '' }}>براعم</option>
                        <option value="شباب" {{ request('category') == 'شباب' ? 'selected' : '' }}>شباب</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label>حالة الاشتراك</label>
                    <select name="status">
                        <option value="">الكل</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>ساري</option>
                        <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>منتهي</option>
                    </select>
                </div>

                <button type="submit" class="btn-filter">تطبيق الفلتر ✔</button>
                <a href="{{ route('reports.index') }}" class="btn-clear">إلغاء الفلاتر ✖</a>
            </form>
        </div>

        <!-- Dynamic Financials (Affected by Filters) -->
        <div class="stats-row" style="grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); margin-bottom: 30px;">
            <div class="stat-card glass-card" style="border: 1px solid rgba(46, 204, 113, 0.3);">
                <div class="stat-icon" style="background: rgba(46, 204, 113, 0.1); color: #2ecc71;">💰</div>
                <div class="stat-info">
                    <h3 style="color: #2ecc71;">إجمالي الميزانية (المطابقة للبحث)</h3>
                    <h2>{{ number_format($totalRevenue, 0) }} <span style="font-size: 14px;">ج.م</span></h2>
                </div>
            </div>

            <div class="stat-card glass-card">
                <div class="stat-icon" style="background: rgba(52, 152, 219, 0.1); color: #3498db;">🦅</div>
                <div class="stat-info">
                    <h3>إيرادات الأكاديمية فقط</h3>
                    <h2>{{ number_format($academyRevenue, 0) }} <span style="font-size: 14px;">ج.م</span></h2>
                </div>
            </div>

            <div class="stat-card glass-card">
                <div class="stat-icon" style="background: rgba(155, 89, 182, 0.1); color: #9b59b6;">💪</div>
                <div class="stat-info">
                    <h3>إيرادات فورس جيم فقط</h3>
                    <h2>{{ number_format($forceGymRevenue, 0) }} <span style="font-size: 14px;">ج.م</span></h2>
                </div>
            </div>
            
            <div class="stat-card glass-card">
                <div class="stat-icon" style="background: rgba(241, 196, 15, 0.1); color: #f1c40f;">👥</div>
                <div class="stat-info">
                    <h3>عدد اللاعبين (المطابق للبحث)</h3>
                    <h2>{{ $filteredPlayers->count() }}</h2>
                </div>
            </div>
        </div>

        <!-- Growth Chart and Table Grid -->
        <div style="display: grid; grid-template-columns: 1fr; gap: 30px;">
            
            <!-- Growth Chart -->
            <div class="chart-box glass-card">
                <div class="chart-header">
                    <h3>معدل النمو (آخر 6 شهور) 📈</h3>
                </div>
                <div class="canvas-container" style="height: 300px;">
                    <canvas id="growthChart"></canvas>
                </div>
            </div>

            <!-- Filtered Players Results -->
            <div class="table-wrapper">
                <h3 style="margin-bottom: 20px; color: var(--text-primary); border-right: 4px solid var(--primary-red); padding-right: 15px;">
                    نتائج البحث ({{ $filteredPlayers->count() }} لاعب)
                </h3>
                <table>
                    <thead>
                        <tr>
                            <th>الاسم</th>
                            <th>الجهة</th>
                            <th>الفئة</th>
                            <th>القيمة</th>
                            <th>تاريخ الانتهاء</th>
                            <th>الحالة</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($filteredPlayers as $player)
                            @php
                                $isExpired = \Carbon\Carbon::parse($player->expiration_date)->startOfDay()->isPast();
                            @endphp
                            <tr>
                                <td data-label="الاسم">{{ $player->name }}</td>
                                <td data-label="الجهة">{{ $player->source }}</td>
                                <td data-label="الفئة">
                                    <span style="background: rgba(255,255,255,0.1); padding: 4px 10px; border-radius: 12px; font-size: 12px;">
                                        {{ $player->category }}
                                    </span>
                                </td>
                                <td data-label="القيمة" style="color: #2ecc71; font-weight: bold;">{{ $player->fee }} ج.م</td>
                                <td data-label="الانتهاء">{{ $player->expiration_date }}</td>
                                <td data-label="الحالة">
                                    @if($isExpired)
                                        <span class="status-expired">❌ منتهي</span>
                                    @else
                                        <span class="status-active">✔ ساري</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" style="text-align: center; color: var(--text-secondary); padding: 30px;">
                                    لا يوجد لاعبين يطابقون شروط البحث.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>

    </main>
@endsection

@push('scripts')
    <script>
        // Initialize Growth Line Chart
        document.addEventListener('DOMContentLoaded', function() {
            var ctx = document.getElementById('growthChart').getContext('2d');
            var growthLabels = @json($growthLabels);
            var growthData = @json($growthData);

            // Reverse arrays so oldest is on the left
            growthLabels.reverse();
            growthData.reverse();

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: growthLabels,
                    datasets: [{
                        label: 'عدد الاشتراكات الجديدة',
                        data: growthData,
                        borderColor: '#e74c3c', // primary red
                        backgroundColor: 'rgba(231, 76, 60, 0.1)',
                        borderWidth: 3,
                        pointBackgroundColor: '#fff',
                        pointBorderColor: '#e74c3c',
                        pointBorderWidth: 2,
                        pointRadius: 5,
                        fill: true,
                        tension: 0.4 // smooth curves
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { color: 'rgba(255, 255, 255, 0.05)' },
                            ticks: { color: '#a0aec0', stepSize: 1 }
                        },
                        x: {
                            grid: { display: false },
                            ticks: { color: '#a0aec0' }
                        }
                    }
                }
            });
        });
    </script>
@endpush
