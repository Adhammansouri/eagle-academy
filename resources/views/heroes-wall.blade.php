@extends('layouts.admin')

@section('title', 'حائط الأبطال')
@section('pageTitle', 'حائط الأبطال')
@section('meta_description', 'حائط الأبطال - أفضل لاعبي أكاديمية النسر بناءً على تقييمات الأداء')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/heroes-wall.css') }}">
@endpush

@push('head_scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush

@section('content')
    <main class="hw-main">

        <header class="hw-header">
            <div class="hw-header-icon">🏆</div>
            <h2>حائط الأبطال</h2>
            <p>ترتيب الأبطال بناءً على أعلى تقييمات الأداء</p>
        </header>

        @if($evaluatedCount > 0)

            <div class="hw-stats">
                <div class="hw-stat-card glass-card">
                    <div class="hw-stat-icon">👥</div>
                    <h3>عدد المقيّمين</h3>
                    <div class="hw-stat-value">{{ $evaluatedCount }}</div>
                    @if($activeCategory !== 'all')
                        <div class="hw-stat-sub">في فئة {{ $activeCategory }}</div>
                    @else
                        <div class="hw-stat-sub">جميع الفئات</div>
                    @endif
                </div>
                <div class="hw-stat-card glass-card">
                    <div class="hw-stat-icon">📊</div>
                    <h3>متوسط التقييم</h3>
                    <div class="hw-stat-value gold">{{ $academyAvg }} <span style="font-size:14px;font-weight:600;color:var(--text-secondary);">/ 5</span></div>
                    <div class="hw-stat-sub">متوسط الأكاديمية</div>
                </div>
                <div class="hw-stat-card glass-card hw-stat-card--champion">
                    <div class="hw-stat-icon">🥇</div>
                    <h3>بطل الترتيب</h3>
                    <div class="hw-stat-value red">{{ $topPlayer->name }}</div>
                    <div class="hw-stat-sub">{{ round($topPlayer->avg_score, 1) }} / 5 — {{ $topPlayer->category ?? '—' }}</div>
                </div>
            </div>

            <div class="hw-filters">
                <a href="{{ route('heroes.wall', ['category' => 'all']) }}"
                   class="hw-filter-chip {{ $activeCategory === 'all' ? 'active' : '' }}">الكل</a>
                @foreach($categories as $cat)
                    <a href="{{ route('heroes.wall', ['category' => $cat]) }}"
                       class="hw-filter-chip {{ $activeCategory === $cat ? 'active active-gold' : '' }}">{{ $cat }}</a>
                @endforeach
            </div>

            @if($top3->count() > 0)
                <section class="hw-podium-wrap">
                    <div class="hw-podium">
                        @foreach($podiumOrder as $idx)
                            @php
                                $p = $top3[$idx];
                                $avg = round($p->avg_score, 1);
                            @endphp
                            <div class="hw-pod {{ $medalClasses[$idx] }}">
                                <div class="hw-pod-card glass-card" data-delay="{{ $idx === 0 ? 100 : ($idx === 1 ? 300 : 500) }}">
                                    <span class="hw-medal">{{ $medalEmojis[$idx] }}</span>
                                    <div class="hw-avatar">{{ mb_substr($p->name, 0, 1) }}</div>
                                    <div class="hw-name">{{ $p->name }}</div>
                                    <div class="hw-cat">{{ $p->category ?? '—' }}</div>
                                    <div class="hw-score-big">{{ $avg }} <span>/ 5</span></div>
                                    <div class="hw-score-label">متوسط التقييم</div>
                                    <div class="hw-skills">
                                        @foreach($skillLabels as $skill)
                                            @php $val = $p->{$skill['key']} ?? 0; @endphp
                                            <div class="hw-skill">
                                                <span class="hw-skill-name">{{ $skill['name'] }}</span>
                                                <div class="hw-skill-track">
                                                    <div class="hw-skill-fill"
                                                         data-width="{{ ($val / 5) * 100 }}%"
                                                         style="--target-width: {{ ($val / 5) * 100 }}%;"></div>
                                                </div>
                                                <span class="hw-skill-val">{{ $val }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif

            <section class="hw-chart-section glass-card">
                <div class="hw-chart-header">
                    <h3>📈 متوسط مهارات الأكاديمية</h3>
                    <p>
                        @if($activeCategory !== 'all')
                            فئة {{ $activeCategory }} — {{ $evaluatedCount }} لاعب
                        @else
                            جميع اللاعبين المقيّمين
                        @endif
                    </p>
                </div>
                <div class="hw-chart-canvas-wrap">
                    <canvas id="hwSkillsChart"></canvas>
                </div>
            </section>

            @if($players->count() > 3)
                <section class="hw-list-section">
                    <div class="hw-list-title">باقي الترتيب</div>
                    @foreach($players->slice(3)->values() as $index => $player)
                        @php
                            $rank = $index + 4;
                            $avg = round($player->avg_score, 1);
                        @endphp
                        <div class="hw-row glass-card" data-delay="{{ $index * 60 }}">
                            <div class="hw-row-rank">#{{ $rank }}</div>
                            <div class="hw-row-avatar">{{ mb_substr($player->name, 0, 1) }}</div>
                            <div class="hw-row-info">
                                <div class="hw-row-name">{{ $player->name }}</div>
                                <div class="hw-row-cat">{{ $player->category ?? '—' }}</div>
                            </div>
                            <div class="hw-row-bars">
                                @foreach($skillLabels as $skill)
                                    @php $bs = $player->{$skill['key']} ?? 0; @endphp
                                    <div class="hw-mini-bar {{ $bs >= 3 ? 'active' : '' }}"
                                         data-height="{{ ($bs / 5) * 26 }}px"
                                         style="height: 3px;"></div>
                                @endforeach
                            </div>
                            <div>
                                <div class="hw-row-score-num">{{ $avg }}</div>
                                <div class="hw-row-score-of">/ 5</div>
                            </div>
                        </div>
                    @endforeach
                </section>
            @endif

        @else
            <div class="hw-empty glass-card">
                <span class="hw-empty-icon">🏅</span>
                <h2>لا يوجد أبطال في هذا التصفية</h2>
                <p>
                    @if($activeCategory !== 'all')
                        لا يوجد لاعبون مقيّمون في فئة «{{ $activeCategory }}». جرّب فئة أخرى أو قم بتقييم اللاعبين.
                    @else
                        قم بتقييم اللاعبين من صفحة سجل اللاعبين لعرضهم هنا
                    @endif
                </p>
                <div class="hw-empty-actions">
                    @if($activeCategory !== 'all')
                        <a href="{{ route('heroes.wall', ['category' => 'all']) }}" class="btn-secondary">عرض الكل</a>
                    @endif
                    <a href="{{ route('players.list') }}" class="btn-primary" style="width: auto; padding: 12px 28px;">📋 الذهاب لسجل اللاعبين</a>
                </div>
            </div>
        @endif

    </main>
@endsection

@push('scripts')
    <script>
    (function() {
        'use strict';

        @if($evaluatedCount > 0)
        const chartEl = document.getElementById('hwSkillsChart');
        if (chartEl && typeof Chart !== 'undefined') {
            new Chart(chartEl, {
                type: 'radar',
                data: {
                    labels: @json($dimensionAverages['labels']),
                    datasets: [{
                        label: 'متوسط الأكاديمية',
                        data: @json($dimensionAverages['values']),
                        backgroundColor: 'rgba(211, 47, 47, 0.2)',
                        borderColor: '#d32f2f',
                        borderWidth: 2,
                        pointBackgroundColor: '#f1c40f',
                        pointBorderColor: '#fff',
                        pointHoverBackgroundColor: '#fff',
                        pointHoverBorderColor: '#d32f2f'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        r: {
                            min: 0,
                            max: 5,
                            ticks: { stepSize: 1, color: 'rgba(255,255,255,0.35)', backdropColor: 'transparent' },
                            grid: { color: 'rgba(255,255,255,0.08)' },
                            angleLines: { color: 'rgba(255,255,255,0.08)' },
                            pointLabels: { color: 'rgba(255,255,255,0.75)', font: { family: 'Cairo', size: 12, weight: '600' } }
                        }
                    },
                    plugins: {
                        legend: { display: false }
                    }
                }
            });
        }
        @endif

        const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

        const io = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (!entry.isIntersecting) return;
                const el = entry.target;
                const delay = Math.max(0, parseInt(el.dataset.delay, 10) || 0);

                setTimeout(() => {
                    el.classList.add('visible');

                    if (reducedMotion) {
                        el.querySelectorAll('.hw-skill-fill').forEach(bar => {
                            bar.style.width = bar.dataset.width;
                        });
                        el.querySelectorAll('.hw-mini-bar').forEach(bar => {
                            bar.style.height = bar.dataset.height;
                        });
                        return;
                    }

                    el.querySelectorAll('.hw-skill-fill').forEach((bar, i) => {
                        setTimeout(() => { bar.style.width = bar.dataset.width; }, 120 + i * 70);
                    });

                    el.querySelectorAll('.hw-mini-bar').forEach((bar, i) => {
                        setTimeout(() => { bar.style.height = bar.dataset.height; }, 80 + i * 50);
                    });
                }, delay);

                io.unobserve(el);
            });
        }, { threshold: 0.12, rootMargin: '0px 0px -30px 0px' });

        document.querySelectorAll('.hw-pod-card, .hw-row').forEach(el => io.observe(el));
    })();
    </script>
@endpush
