@extends('layouts.admin')

@section('title', 'الاشتراكات المنتهية')
@section('pageTitle', 'الاشتراكات المنتهية')

@push('styles')
    <style>
        .expired-wrapper {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius);
            padding: 30px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.4);
            animation: fadeIn 0.8s ease forwards;
            overflow-x: auto;
        }

        .expired-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            flex-wrap: wrap;
            gap: 15px;
        }

        .expired-header h2 {
            font-size: 24px;
            color: var(--text-primary);
            border-right: 4px solid #c0392b;
            padding-right: 15px;
        }

        .expired-count-badge {
            background: rgba(192, 57, 43, 0.15);
            color: #c0392b;
            border: 1px solid rgba(192, 57, 43, 0.4);
            padding: 8px 20px;
            border-radius: 30px;
            font-weight: 800;
            font-size: 15px;
        }

        .expired-table {
            width: 100%;
            border-collapse: collapse;
            text-align: right;
        }

        .expired-table thead {
            background: rgba(192, 57, 43, 0.08);
        }

        .expired-table th, .expired-table td {
            padding: 16px;
            border-bottom: 1px solid var(--border-color);
        }

        .expired-table th {
            color: var(--text-secondary);
            font-weight: 700;
            font-size: 14px;
        }

        .expired-table td {
            font-weight: 600;
            font-size: 15px;
        }

        .expired-table tr:hover {
            background: rgba(255, 255, 255, 0.02);
            transition: background 0.3s;
        }

        .days-overdue {
            color: #c0392b;
            font-weight: 900;
            font-size: 16px;
        }

        .player-link {
            text-decoration: none;
            color: var(--gold);
            font-weight: 800;
            font-size: 16px;
            transition: all 0.2s;
        }

        .player-link:hover {
            text-decoration: underline;
            text-underline-offset: 4px;
        }

        .avatar-sm {
            width: 38px;
            height: 38px;
            background: var(--bg-main);
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-red);
            font-weight: bold;
            font-size: 16px;
            margin-left: 10px;
            border: 1px solid var(--border-color);
        }

        .actions-cell {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .btn-action-sm {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            border: none;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            text-decoration: none;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .btn-wa {
            background: rgba(46, 204, 113, 0.15);
            color: #2ecc71;
            border: 1px solid rgba(46, 204, 113, 0.3);
        }
        .btn-wa:hover {
            background: #2ecc71;
            color: #fff;
            transform: translateY(-3px) scale(1.05);
            box-shadow: 0 10px 15px -3px rgba(46, 204, 113, 0.4);
        }

        .btn-profile {
            background: rgba(241, 196, 15, 0.15);
            color: #f1c40f;
            border: 1px solid rgba(241, 196, 15, 0.3);
        }
        .btn-profile:hover {
            background: #f1c40f;
            color: #000;
            transform: translateY(-3px) scale(1.05);
            box-shadow: 0 10px 15px -3px rgba(241, 196, 15, 0.4);
        }

        .btn-renew {
            background: rgba(52, 152, 219, 0.15);
            color: #3498db;
            border: 1px solid rgba(52, 152, 219, 0.3);
        }
        .btn-renew:hover {
            background: #3498db;
            color: #fff;
            transform: translateY(-3px) scale(1.05);
            box-shadow: 0 10px 15px -3px rgba(52, 152, 219, 0.4);
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: var(--text-secondary);
        }
        .empty-state .icon { font-size: 48px; margin-bottom: 15px; display: block; }
        .empty-state p { font-size: 18px; font-weight: 600; }

        @media (max-width: 768px) {
            .expired-wrapper {
                padding: 10px;
                background: transparent;
                border: none;
                box-shadow: none;
            }
            .expired-header {
                flex-direction: column;
                align-items: center;
                background: var(--bg-card);
                padding: 20px;
                border-radius: var(--radius);
                border: 1px solid var(--border-color);
            }
            .expired-header h2 { border: none; padding: 0; text-align: center; }
            .expired-table, .expired-table thead, .expired-table tbody, .expired-table th, .expired-table td, .expired-table tr {
                display: block;
                width: 100%;
            }
            .expired-table thead tr { display: none; }
            .expired-table tbody tr {
                background: var(--bg-card);
                border: 1px solid var(--border-color);
                margin-bottom: 20px;
                border-radius: var(--radius);
                box-shadow: 0 4px 15px rgba(0,0,0,0.2);
                padding: 0;
                overflow: hidden;
            }
            .expired-table td {
                border: none;
                border-bottom: 1px solid rgba(255,255,255,0.06);
                padding: 14px 15px;
                display: flex;
                justify-content: space-between;
                align-items: center;
            }
            .expired-table td:last-child { border-bottom: none; }
            .expired-table td:nth-of-type(1) {
                background: linear-gradient(135deg, rgba(192, 57, 43, 0.15) 0%, rgba(30, 34, 39, 0.9) 100%);
                padding: 18px 15px;
                justify-content: center;
                border-bottom: 2px solid rgba(192, 57, 43, 0.3);
            }
            .expired-table td:nth-of-type(2):after { content: "الكود"; }
            .expired-table td:nth-of-type(3):after { content: "الهاتف"; }
            .expired-table td:nth-of-type(4):after { content: "تاريخ الانتهاء"; }
            .expired-table td:nth-of-type(5):after { content: "التأخير"; }
            .expired-table td:nth-of-type(6):after { content: "الفئة"; }
            .expired-table td:nth-of-type(n+2):nth-of-type(-n+6) {
                flex-direction: row-reverse;
            }
            .expired-table td:nth-of-type(n+2):nth-of-type(-n+6):after {
                font-weight: 700;
                color: var(--text-secondary);
                font-size: 12px;
                order: 2;
                flex-shrink: 0;
            }
            .expired-table td:nth-of-type(7) {
                background: rgba(0, 0, 0, 0.15);
                padding: 12px 15px;
                justify-content: center;
            }
            .actions-cell { justify-content: center; width: 100%; }
        }
    </style>
@endpush

@section('content')
    <main class="dashboard-wrapper">
        <div class="expired-wrapper">

            <div class="expired-header">
                <h2>🚫 قائمة الاشتراكات المنتهية</h2>
                <span class="expired-count-badge">{{ $players->count() }} لاعب منتهي الاشتراك</span>
            </div>

            @if($players->isEmpty())
                <div class="empty-state">
                    <span class="icon">🎉</span>
                    <p>لا توجد اشتراكات منتهية حالياً!</p>
                </div>
            @else
                <table class="expired-table">
                    <thead>
                        <tr>
                            <th>اللاعب</th>
                            <th>الكود</th>
                            <th>الهاتف</th>
                            <th>تاريخ الانتهاء</th>
                            <th>أيام التأخير</th>
                            <th>الفئة</th>
                            <th>إجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($players as $player)
                            @php
                                $expirationDate = \Carbon\Carbon::parse($player->expiration_date)->startOfDay();
                                $today = \Carbon\Carbon::now()->startOfDay();
                                $daysOverdue = $today->diffInDays($expirationDate);

                                $portalUrl = rtrim(config('app.url'), '/') . '/portal';
                                $whatsappMessage = "مرحباً، نود تذكيركم بأن اشتراك البطل ({$player->name}) في The Eagle Academy قد انتهى بتاريخ {$player->expiration_date}.\n\nيرجى التجديد في أقرب وقت للاستمرار في التدريب.\n\nللاستعلام عن حالة اللاعب من البورتال:\n{$portalUrl}\nكود اللاعب: {$player->player_code}";

                                $phone = \App\Support\PhoneHelper::toWhatsApp($player->phone_number ?? '');
                            @endphp
                            <tr>
                                <td>
                                    <a href="{{ route('players.profile', $player->id) }}" class="player-link" style="display: flex; align-items: center;">
                                        <span class="avatar-sm">{{ mb_substr($player->name, 0, 1) }}</span>
                                        {{ $player->name }}
                                    </a>
                                </td>
                                <td>
                                    <span style="background: rgba(255,255,255,0.1); padding: 4px 8px; border-radius: 4px; font-family: monospace;">{{ $player->player_code }}</span>
                                </td>
                                <td dir="ltr">{{ $player->phone_number ?? '—' }}</td>
                                <td>{{ $player->expiration_date }}</td>
                                <td><span class="days-overdue">منتهي منذ {{ $daysOverdue }} يوم</span></td>
                                <td>{{ $player->category ?? 'غير محدد' }}</td>
                                <td>
                                    <div class="actions-cell">
                                        @if($phone)
                                            <a href="https://wa.me/{{ $phone }}?text={{ urlencode($whatsappMessage) }}" target="_blank" class="btn-action-sm btn-wa" title="إرسال تذكير واتساب">
                                                💬
                                            </a>
                                        @endif
                                        <a href="{{ route('players.profile', $player->id) }}" class="btn-action-sm btn-profile" title="عرض البروفايل">
                                            👤
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </main>
@endsection
