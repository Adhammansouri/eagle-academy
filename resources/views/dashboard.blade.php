@extends('layouts.admin')

@section('title', 'لوحة التحكم')
@section('pageTitle', 'لوحة التحكم')

@push('head_scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush

@section('content')
    <main class="dashboard-wrapper">

        <div class="welcome-hero">
            <div class="hero-content">
                <h2>أهلاً بعودتك يا كابتن! 👑</h2>
                <p>إليك نظرة شاملة وسريعة على أداء <strong>The Eagle Academy</strong> اليوم.</p>
            </div>
            <div class="hero-decoration"></div>
        </div>

        <div class="stats-row four-cols">
            <div class="stat-card glass-card">
                <div class="stat-icon" style="background: rgba(46, 204, 113, 0.1); color: #2ecc71;">👥</div>
                <div class="stat-info">
                    <h3>إجمالي اللاعبين</h3>
                    <h2 id="totalPlayers">{{ $playersCount }}</h2>
                </div>
            </div>

            <div class="stat-card glass-card">
                <div class="stat-icon" style="background: rgba(52, 152, 219, 0.1); color: #3498db;">📈</div>
                <div class="stat-info">
                    <h3>اشتراكات الشهر</h3>
                    <h2 id="newSubs">{{ $newSubsCount }}</h2>
                </div>
            </div>

            <div class="stat-card glass-card">
                <div class="stat-icon" style="background: rgba(241, 196, 15, 0.1); color: #f1c40f;">💰</div>
                <div class="stat-info">
                    <h3>إجمالي الإيرادات</h3>
                    <h2>{{ number_format($totalRevenue, 0) }} <span style="font-size: 14px; color: var(--text-secondary);">ج.م</span></h2>
                </div>
            </div>

            <div class="stat-card glass-card warning-glow">
                <div class="stat-icon" style="background: rgba(231, 76, 60, 0.1); color: #e74c3c;">⏳</div>
                <div class="stat-info">
                    <h3>اشتراكات توشك على الانتهاء</h3>
                    <h2 style="color: #e74c3c;">{{ $expiringSoonCount }}</h2>
                </div>
            </div>
        </div>

        <div class="actions-grid">
            <a href="{{ route('players.create') }}" class="action-card">
                <span class="action-icon">➕</span>
                <span class="action-title">تسجيل لاعب جديد</span>
                <p style="color: var(--text-secondary); font-size: 13px; margin-top: 5px; font-weight: normal;">إضافة اشتراك بضغطة واحدة</p>
            </a>

            <a href="{{ route('players.list') }}" class="action-card secondary">
                <span class="action-icon">📋</span>
                <span class="action-title">سجل اللاعبين بالكامل</span>
                <p style="color: var(--text-secondary); font-size: 13px; margin-top: 5px; font-weight: normal;">إدارة وتتبع تواريخ الإنتهاء</p>
            </a>

            <a href="{{ route('heroes.wall') }}" class="action-card" style="background: linear-gradient(135deg, rgba(241, 196, 15, 0.1) 0%, rgba(30, 34, 39, 0.9) 100%);">
                <span class="action-icon">🏆</span>
                <span class="action-title">حائط الأبطال</span>
                <p style="color: var(--text-secondary); font-size: 13px; margin-top: 5px; font-weight: normal;">أفضل اللاعبين أداءً</p>
            </a>
        </div>

        <div class="creative-grid">

            <div class="charts-section">
                <div class="chart-box glass-card">
                    <div class="chart-header">
                        <h3>التوزيع العمري للأكاديمية</h3>
                        <span class="chart-badge">مباشر</span>
                    </div>
                    <div class="canvas-container">
                        <canvas id="categoryChart"></canvas>
                    </div>
                </div>

                <div class="chart-box glass-card">
                    <div class="chart-header">
                        <h3>مصادر اشتراكات اللاعبين</h3>
                        <span class="chart-badge">مباشر</span>
                    </div>
                    <div class="canvas-container">
                        <canvas id="sourceChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="recent-activity glass-card">
                <h3>⚡ أحدث التسجيلات</h3>

                <div class="activity-list">
                    @forelse($recentPlayers as $player)
                        <div class="activity-item">
                            <div class="activity-avatar">{{ mb_substr($player->name, 0, 1) }}</div>
                            <div class="activity-details">
                                <h4>{{ $player->name }}</h4>
                                <span class="activity-meta">منذ {{ \Carbon\Carbon::parse($player->created_at)->diffForHumans() }} • {{ $player->category }}</span>
                            </div>
                            <div class="activity-amount">+{{ $player->fee }} ج.م</div>
                        </div>
                    @empty
                        <div style="text-align: center; color: var(--text-secondary); padding: 20px;">
                            لا توجد نشاطات حديثة.
                        </div>
                    @endforelse
                </div>

                <a href="{{ route('players.list') }}" class="view-all-link">عرض جميع اللاعبين ➔</a>
            </div>

        </div>
    </main>
@endsection

@push('scripts')
    <script>
        window.chartData = @json(['categories' => $categories, 'sources' => $sources]);
    </script>
    <script src="{{ asset('js/app.js') }}"></script>
@endpush
