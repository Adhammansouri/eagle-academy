@extends('layouts.admin')

@section('title', 'سجل الاشتراكات')
@section('pageTitle', 'سجل الاشتراكات')

@push('styles')
<style>
    .history-filters {
        background: var(--glass-bg);
        backdrop-filter: blur(15px);
        border: 1px solid var(--border-color);
        border-radius: var(--radius);
        padding: 22px;
        margin-bottom: 24px;
    }

    .history-filters h2 {
        font-size: 18px;
        color: var(--text-primary);
        border-right: 4px solid var(--primary-red);
        padding-right: 12px;
        margin-bottom: 16px;
    }

    .history-filter-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 14px;
        align-items: end;
    }

    .history-filter-grid label {
        display: block;
        margin-bottom: 6px;
        font-size: 13px;
        color: var(--text-secondary);
    }

    .history-filter-actions {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }

    .history-table-wrap {
        background: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: var(--radius);
        padding: 24px;
        overflow-x: auto;
    }

    .history-table-wrap h2 {
        font-size: 18px;
        margin-bottom: 18px;
        color: var(--text-primary);
    }

    .history-badge {
        display: inline-block;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 700;
    }

    .history-badge--registration {
        background: rgba(46, 204, 113, 0.15);
        color: #2ecc71;
        border: 1px solid rgba(46, 204, 113, 0.35);
    }

    .history-badge--renewal {
        background: rgba(241, 196, 15, 0.12);
        color: #f1c40f;
        border: 1px solid rgba(241, 196, 15, 0.35);
    }

    .history-dates-muted {
        font-size: 12px;
        color: var(--text-secondary);
    }

    .history-period {
        display: flex;
        flex-direction: column;
        gap: 5px;
        min-width: 0;
    }

    .history-period-row {
        display: flex;
        align-items: center;
        gap: 8px;
        white-space: nowrap;
        font-size: 13px;
        line-height: 1.3;
    }

    .history-period-label {
        flex-shrink: 0;
        font-size: 11px;
        font-weight: 700;
        color: var(--text-secondary);
        min-width: 32px;
    }

    .history-period-value {
        font-variant-numeric: tabular-nums;
        letter-spacing: 0.02em;
        color: var(--text-primary);
    }

    .history-period--muted .history-period-value {
        color: var(--text-secondary);
    }

    .history-period-empty {
        color: var(--text-secondary);
        font-size: 14px;
    }

    .history-table-wrap th.history-col-period,
    .history-table-wrap td.history-col-period {
        min-width: 155px;
        width: 155px;
        vertical-align: middle;
    }

    .history-pagination {
        margin-top: 20px;
    }

    .history-table-wrap table {
        width: 100%;
        min-width: 880px;
        border-collapse: collapse;
        text-align: right;
    }

    .history-table-wrap th,
    .history-table-wrap td {
        padding: 14px 15px;
        border-bottom: 1px solid var(--border-color);
    }

    .history-table-wrap th {
        color: var(--text-secondary);
        font-size: 14px;
        font-weight: 600;
    }

    .history-table-wrap tbody tr:hover {
        background: rgba(255, 255, 255, 0.02);
    }

    .history-cell-value {
        display: contents;
    }

    .history-amount {
        color: #2ecc71;
        font-weight: 800;
    }

    @media (max-width: 768px) {
        .history-table-wrap {
            padding: 12px;
            overflow-x: visible;
        }

        .history-table-wrap table {
            min-width: 0;
        }

        .history-table-wrap table,
        .history-table-wrap thead,
        .history-table-wrap tbody,
        .history-table-wrap th,
        .history-table-wrap td,
        .history-table-wrap tr {
            display: block;
            width: 100%;
        }

        .history-table-wrap thead {
            display: none;
        }

        .history-table-wrap tbody tr {
            display: flex;
            flex-direction: column;
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            margin-bottom: 14px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .history-table-wrap td.history-cell--player {
            order: -1;
        }

        .history-table-wrap td {
            border: none;
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
            position: relative;
            padding: 10px 14px !important;
            text-align: right;
            display: grid;
            grid-template-columns: 1fr;
            gap: 6px;
        }

        .history-table-wrap td:last-child {
            border-bottom: none;
        }

        .history-table-wrap th.history-col-period,
        .history-table-wrap td.history-col-period {
            min-width: 0 !important;
            width: auto !important;
        }

        /* Label فوق القيمة — بدون تداخل */
        .history-table-wrap td::before {
            content: attr(data-label) !important;
            position: static !important;
            top: auto !important;
            right: auto !important;
            left: auto !important;
            width: 100% !important;
            padding: 0 !important;
            display: block !important;
            font-weight: 700;
            font-size: 11px;
            line-height: 1.2;
            color: var(--text-secondary);
            white-space: nowrap;
        }

        .history-table-wrap td:nth-of-type(1)::before,
        .history-table-wrap td:nth-of-type(2)::before,
        .history-table-wrap td:nth-of-type(3)::before,
        .history-table-wrap td:nth-of-type(4)::before,
        .history-table-wrap td:nth-of-type(5)::before,
        .history-table-wrap td:nth-of-type(6)::before,
        .history-table-wrap td:nth-of-type(7)::before {
            content: attr(data-label) !important;
        }

        .history-table-wrap .history-cell-value {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 2px;
            width: 100%;
            font-size: 14px;
            line-height: 1.35;
        }

        .history-table-wrap .history-cell-value--datetime {
            flex-direction: row;
            align-items: baseline;
            justify-content: flex-end;
            gap: 10px;
        }

        .history-table-wrap td.history-cell--player {
            padding: 14px !important;
            background: linear-gradient(135deg, rgba(211, 47, 47, 0.12) 0%, rgba(30, 34, 39, 0.95) 100%);
            border-bottom: 2px solid rgba(211, 47, 47, 0.25);
        }

        .history-table-wrap td.history-cell--player::before {
            display: none !important;
        }

        .history-table-wrap td.history-cell--player .history-cell-value {
            align-items: center;
            width: 100%;
        }

        .history-table-wrap td.history-col-period .history-cell-value {
            align-items: stretch;
        }

        .history-table-wrap td.history-col-period .history-period {
            width: 100%;
            gap: 4px;
        }

        .history-table-wrap td.history-col-period .history-period-row {
            justify-content: flex-start;
        }

        .history-table-wrap tr:has(td[colspan]) {
            display: block;
            text-align: center;
            padding: 20px;
        }

        .history-table-wrap tr:has(td[colspan]) td::before {
            display: none !important;
        }
    }
</style>
@endpush

@section('content')
    <main class="dashboard-wrapper">

        <div class="welcome-hero" style="margin-bottom: 24px;">
            <div class="hero-content">
                <h2>سجل الاشتراكات والتجديدات</h2>
                <p>متابعة كل عمليات التسجيل والتجديد مع التواريخ والمبالغ.</p>
            </div>
        </div>

        <div class="stats-row" style="grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); margin-bottom: 24px;">
            <div class="stat-card glass-card">
                <div class="stat-icon" style="background: rgba(52, 152, 219, 0.1); color: #3498db;">📋</div>
                <div class="stat-info">
                    <h3>إجمالي العمليات</h3>
                    <h2>{{ $stats['total'] }}</h2>
                </div>
            </div>
            <div class="stat-card glass-card">
                <div class="stat-icon" style="background: rgba(46, 204, 113, 0.1); color: #2ecc71;">➕</div>
                <div class="stat-info">
                    <h3>تسجيلات جديدة</h3>
                    <h2>{{ $stats['registrations'] }}</h2>
                </div>
            </div>
            <div class="stat-card glass-card">
                <div class="stat-icon" style="background: rgba(241, 196, 15, 0.1); color: #f1c40f;">🔄</div>
                <div class="stat-info">
                    <h3>تجديدات</h3>
                    <h2>{{ $stats['renewals'] }}</h2>
                </div>
            </div>
            <div class="stat-card glass-card">
                <div class="stat-icon" style="background: rgba(211, 47, 47, 0.1); color: var(--primary-red);">💰</div>
                <div class="stat-info">
                    <h3>إجمالي المبالغ</h3>
                    <h2>{{ number_format($stats['total_amount'], 0) }} <span style="font-size: 13px; color: var(--text-secondary);">ج.م</span></h2>
                </div>
            </div>
        </div>

        <div class="history-filters">
            <h2>فلترة السجل</h2>
            <form method="GET" action="{{ route('subscriptions.history') }}" class="history-filter-grid">
                <div>
                    <label for="search">بحث (اسم أو كود)</label>
                    <input type="text" id="search" name="search" value="{{ request('search') }}" placeholder="اسم اللاعب...">
                </div>
                <div>
                    <label for="type">نوع العملية</label>
                    <select id="type" name="type">
                        <option value="">الكل</option>
                        <option value="registration" @selected(request('type') === 'registration')>تسجيل جديد</option>
                        <option value="renewal" @selected(request('type') === 'renewal')>تجديد اشتراك</option>
                    </select>
                </div>
                <div>
                    <label for="date_from">من تاريخ</label>
                    <input type="date" id="date_from" name="date_from" value="{{ request('date_from') }}">
                </div>
                <div>
                    <label for="date_to">إلى تاريخ</label>
                    <input type="date" id="date_to" name="date_to" value="{{ request('date_to') }}">
                </div>
                <div class="history-filter-actions">
                    <button type="submit" class="btn-primary" style="width: auto; padding: 12px 20px;">تطبيق</button>
                    <a href="{{ route('subscriptions.history') }}" class="btn-secondary" style="padding: 12px 20px; text-decoration: none;">إعادة ضبط</a>
                </div>
            </form>
        </div>

        <div class="history-table-wrap">
            <h2>العمليات ({{ $histories->total() }})</h2>

            <table>
                <thead>
                    <tr>
                        <th>التاريخ والوقت</th>
                        <th>اللاعب</th>
                        <th>الكود</th>
                        <th>العملية</th>
                        <th>المبلغ</th>
                        <th class="history-col-period">قبل التجديد</th>
                        <th class="history-col-period">الفترة الجديدة</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($histories as $history)
                        <tr>
                            <td data-label="التاريخ والوقت">
                                <div class="history-cell-value history-cell-value--datetime">
                                    <span>{{ $history->created_at->format('Y-m-d') }}</span>
                                    <span class="history-dates-muted">{{ $history->created_at->format('H:i') }}</span>
                                </div>
                            </td>
                            <td class="history-cell--player" data-label="اللاعب">
                                <div class="history-cell-value">
                                    <a href="{{ route('players.profile', $history->player_id) }}" style="color: var(--text-primary); font-weight: 700; text-decoration: none; font-size: 17px;">
                                        {{ $history->player->name }}
                                    </a>
                                </div>
                            </td>
                            <td data-label="الكود">
                                <div class="history-cell-value">{{ $history->player->player_code ?? '—' }}</div>
                            </td>
                            <td data-label="العملية">
                                <div class="history-cell-value">
                                    <span class="history-badge history-badge--{{ $history->type }}">
                                        {{ $history->typeLabel() }}
                                    </span>
                                </div>
                            </td>
                            <td data-label="المبلغ">
                                <div class="history-cell-value history-amount">
                                    {{ number_format($history->amount, 0) }} ج.م
                                </div>
                            </td>
                            <td class="history-col-period" data-label="قبل التجديد">
                                <div class="history-cell-value">
                                    @if($history->previous_subscription_date)
                                        <div class="history-period history-period--muted">
                                            <div class="history-period-row">
                                                <span class="history-period-label">من</span>
                                                <span class="history-period-value">{{ $history->previous_subscription_date->format('Y-m-d') }}</span>
                                            </div>
                                            <div class="history-period-row">
                                                <span class="history-period-label">إلى</span>
                                                <span class="history-period-value">{{ $history->previous_expiration_date?->format('Y-m-d') ?? '—' }}</span>
                                            </div>
                                        </div>
                                    @else
                                        <span class="history-period-empty">—</span>
                                    @endif
                                </div>
                            </td>
                            <td class="history-col-period" data-label="الفترة الجديدة">
                                <div class="history-cell-value">
                                    <div class="history-period">
                                        <div class="history-period-row">
                                            <span class="history-period-label">من</span>
                                            <span class="history-period-value">{{ $history->subscription_date->format('Y-m-d') }}</span>
                                        </div>
                                        <div class="history-period-row">
                                            <span class="history-period-label">إلى</span>
                                            <span class="history-period-value">{{ $history->expiration_date->format('Y-m-d') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="text-align: center; padding: 30px; color: var(--text-secondary);">
                                لا توجد عمليات مطابقة للبحث.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="history-pagination">
                {{ $histories->links() }}
            </div>
        </div>

    </main>
@endsection
