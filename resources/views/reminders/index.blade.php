@extends('layouts.admin')

@section('title', 'تنبيهات الاشتراكات')

@push('styles')
    <style>
        .table-responsive {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius);
            padding: 20px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.4);
            animation: fadeIn 0.8s ease forwards;
            overflow-x: auto;
        }

        table.reminders-table {
            width: 100%;
            border-collapse: collapse;
            text-align: right;
        }

        table.reminders-table thead {
            background: rgba(0, 0, 0, 0.2);
        }

        table.reminders-table th, 
        table.reminders-table td {
            padding: 16px;
            border-bottom: 1px solid var(--border-color);
            vertical-align: middle;
            white-space: nowrap;
        }

        table.reminders-table th {
            color: var(--text-secondary);
            font-weight: 700;
            font-size: 14px;
        }

        table.reminders-table td {
            font-weight: 600;
            font-size: 15px;
        }

        table.reminders-table tr:hover {
            background: rgba(255, 255, 255, 0.02);
            transition: background 0.3s;
        }

        .badge {
            padding: 6px 12px;
            border-radius: 30px;
            font-size: 12px;
            font-weight: 700;
            display: inline-block;
        }

        .badge-danger {
            background: rgba(231, 76, 60, 0.2);
            color: #e74c3c;
            border: 1px solid rgba(231, 76, 60, 0.4);
        }

        .badge-warning {
            background: rgba(241, 196, 15, 0.2);
            color: #f1c40f;
            border: 1px solid rgba(241, 196, 15, 0.4);
        }

        /* Wrap action buttons in flex div inside the td to prevent layout breaking */
        .reminders-actions-wrapper {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        @media (max-width: 768px) {
            .table-responsive {
                padding: 10px;
                background: transparent;
                border: none;
                box-shadow: none;
            }

            /* Reset all table elements to block */
            table.reminders-table,
            table.reminders-table thead,
            table.reminders-table tbody,
            table.reminders-table th,
            table.reminders-table td,
            table.reminders-table tr { 
                display: block; 
                width: 100%;
            }
            
            table.reminders-table thead tr { 
                display: none;
            }
            
            /* Each row = a card */
            table.reminders-table tbody tr { 
                background: var(--bg-card);
                border: 1px solid var(--border-color); 
                margin-bottom: 20px; 
                border-radius: var(--radius); 
                box-shadow: 0 4px 15px rgba(0,0,0,0.2);
                padding: 0;
                overflow: hidden;
            }

            /* All td cells - reset */
            table.reminders-table td { 
                border: none;
                border-bottom: 1px solid rgba(255,255,255,0.06); 
                position: relative;
                padding: 14px 15px;
                text-align: right;
                font-size: 14px;
                display: flex;
                justify-content: space-between;
                align-items: center;
                gap: 10px;
            }

            table.reminders-table td:last-child {
                border-bottom: none;
            }

            /* Remove default/global td:before labels if any */
            table.reminders-table td:before { 
                content: none !important;
                display: none !important;
            }

            /* ---- Player Name (1st td) - Card Header ---- */
            table.reminders-table td:nth-of-type(1) {
                background: linear-gradient(135deg, rgba(211, 47, 47, 0.1) 0%, rgba(30, 34, 39, 0.9) 100%);
                padding: 18px 15px;
                justify-content: center;
                border-bottom: 2px solid rgba(211, 47, 47, 0.3);
                font-size: 16px;
                font-weight: 800;
            }

            /* ---- Data rows (2nd to 6th td) - Label : Value ---- */
            table.reminders-table td:nth-of-type(2):after,
            table.reminders-table td:nth-of-type(3):after,
            table.reminders-table td:nth-of-type(4):after,
            table.reminders-table td:nth-of-type(5):after,
            table.reminders-table td:nth-of-type(6):after {
                font-weight: 700;
                color: var(--text-secondary);
                font-size: 12px;
                order: 2;
                flex-shrink: 0;
                white-space: nowrap;
            }

            table.reminders-table td:nth-of-type(2):after { content: "الكود"; }
            table.reminders-table td:nth-of-type(3):after { content: "ينتهي في"; }
            table.reminders-table td:nth-of-type(4):after { content: "الأيام المتبقية"; }
            table.reminders-table td:nth-of-type(5):after { content: "الهاتف"; }
            table.reminders-table td:nth-of-type(6):after { content: "الحالة"; }

            /* Value text sits on the left */
            table.reminders-table td:nth-of-type(n+2):nth-of-type(-n+6) {
                flex-direction: row-reverse;
            }

            /* ---- Actions (7th td) - Card Footer ---- */
            table.reminders-table td:nth-of-type(7) {
                background: rgba(0, 0, 0, 0.15);
                padding: 12px 15px;
                justify-content: center;
                border-bottom: none;
            }
            
            table.reminders-table .reminders-actions-wrapper {
                justify-content: center;
                width: 100%;
            }
        }
    </style>
@endpush

@section('content')
    <main class="dashboard-wrapper">
        <div class="page-header">
            <h1>تنبيهات الاشتراكات</h1>
            <p class="page-subtitle">
                اللاعبون الذين ينتهي اشتراكهم خلال {{ $windowDays }} أيام — اضغط واتساب لإرسال رسالة جاهزة
            </p>
        </div>

        @if (session('success'))
            <div class="alert alert-success" role="alert">{{ session('success') }}</div>
        @endif

        <div class="reminders-summary">
            <span class="reminders-summary-item">
                <strong>{{ $items->count() }}</strong> لاعب في القائمة
            </span>
            <span class="reminders-summary-item reminders-summary-item--pending">
                <strong>{{ $pendingCount }}</strong> تنبيه معلّق
            </span>
        </div>

        @if ($items->isEmpty())
            <div class="glass-card reminders-empty">
                <p>لا يوجد لاعبون قريبون من انتهاء الاشتراك (مع رقم هاتف مسجّل) خلال {{ $windowDays }} أيام.</p>
            </div>
        @else
            <div class="table-responsive glass-card">
                <table class="data-table reminders-table">
                    <thead>
                        <tr>
                            <th>اللاعب</th>
                            <th>الكود</th>
                            <th>ينتهي في</th>
                            <th>الأيام المتبقية</th>
                            <th>الهاتف</th>
                            <th>الحالة</th>
                            <th>إجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($items as $item)
                            <tr class="reminders-row reminders-row--{{ $item['status'] }}">
                                <td>{{ $item['player_name'] }}</td>
                                <td>{{ $item['player_code'] ?? '—' }}</td>
                                <td>{{ $item['expiration_date_formatted'] }}</td>
                                <td>
                                    @if ($item['days_remaining'] <= 0)
                                        <span class="badge badge-danger">منتهي</span>
                                    @elseif ($item['days_remaining'] <= 3)
                                        <span class="badge badge-warning">{{ $item['days_remaining'] }} يوم</span>
                                    @else
                                        <span class="badge">{{ $item['days_remaining'] }} يوم</span>
                                    @endif
                                </td>
                                <td dir="ltr">{{ $item['phone_number'] }}</td>
                                <td>
                                    <span class="reminder-status reminder-status--{{ $item['status'] }}">
                                        {{ $item['status_label'] }}
                                    </span>
                                </td>
                                <td>
                                    <div class="reminders-actions-wrapper">
                                        @if ($item['whatsapp_url'])
                                            <a href="{{ $item['whatsapp_url'] }}"
                                               target="_blank"
                                               rel="noopener noreferrer"
                                               class="btn-reminder btn-reminder--whatsapp">
                                                واتساب
                                            </a>
                                        @else
                                            <span class="text-muted">رقم غير صالح</span>
                                        @endif

                                        @if ($item['status'] !== 'sent')
                                            <form action="{{ route('reminders.sent', $item['player_id']) }}" method="POST" class="reminders-inline-form">
                                                @csrf
                                                <button type="submit" class="btn-reminder btn-reminder--sent">تم الإرسال</button>
                                            </form>
                                        @endif

                                        <form action="{{ route('reminders.dismiss', $item['player_id']) }}" method="POST" class="reminders-inline-form">
                                            @csrf
                                            <button type="submit" class="btn-reminder btn-reminder--dismiss">تجاهل</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </main>
@endsection
