<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>قائمة اللاعبين | The Eagle Academy</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    
    <style>
        .table-wrapper {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius);
            padding: 30px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.4);
            animation: fadeIn 0.8s ease forwards;
            overflow-x: auto;
        }

        .header-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .header-actions h2 {
            font-size: 24px;
            color: var(--text-primary);
            border-right: 4px solid var(--primary-red);
            padding-right: 15px;
        }

        .btn-secondary {
            background: var(--input-bg);
            border: 1px solid var(--border-color);
            color: var(--text-primary);
            padding: 10px 20px;
            border-radius: var(--radius);
            text-decoration: none;
            transition: var(--transition);
            font-weight: 600;
        }

        .btn-secondary:hover {
            border-color: var(--text-secondary);
            background: rgba(255, 255, 255, 0.05);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            text-align: right;
        }

        thead {
            background: rgba(0, 0, 0, 0.2);
        }

        th, td {
            padding: 16px;
            border-bottom: 1px solid var(--border-color);
        }

        th {
            color: var(--text-secondary);
            font-weight: 700;
            font-size: 14px;
        }

        td {
            font-weight: 600;
            font-size: 15px;
        }

        tr:hover {
            background: rgba(255, 255, 255, 0.02);
            transition: background 0.3s;
        }

        .badge {
            padding: 6px 14px;
            border-radius: 30px;
            font-size: 13px;
            font-weight: 700;
        }

        .badge-red {
            background: rgba(211, 47, 47, 0.2);
            color: #ff5252;
            border: 1px solid rgba(211, 47, 47, 0.5);
        }

        .badge-gray {
            background: rgba(158, 164, 168, 0.2);
            color: #b0bec5;
            border: 1px solid rgba(158, 164, 168, 0.5);
        }

        .status-active { 
            color: #2ecc71; 
            font-weight: 800; 
            background: rgba(46, 204, 113, 0.15); 
            padding: 5px 10px; 
            border-radius: 8px; 
        }
        .status-warning { 
            color: #f39c12; 
            font-weight: 800; 
            background: rgba(243, 156, 18, 0.15); 
            padding: 5px 10px; 
            border-radius: 8px; 
            animation: pulse-border 2s infinite; 
        }
        .status-expired { 
            color: #e74c3c; 
            font-weight: 800; 
            background: rgba(231, 76, 60, 0.15); 
            padding: 5px 10px; 
            border-radius: 8px; 
        }

        .avatar {
            width: 40px;
            height: 40px;
            background: var(--bg-main);
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: var(--primary-red);
            font-weight: bold;
            font-size: 18px;
            margin-left: 10px;
            border: 1px solid var(--border-color);
        }

        .player-info {
            display: flex;
            align-items: center;
        }

        @media (max-width: 768px) {
            .table-wrapper {
                padding: 15px;
                background: transparent;
                border: none;
                box-shadow: none;
            }

            .header-actions { 
                flex-direction: column; 
                gap: 15px; 
                align-items: center; 
                background: var(--bg-card);
                padding: 20px;
                border-radius: var(--radius);
                border: 1px solid var(--border-color);
                width: 100%;
            }

            .header-actions h2 { border: none; padding: 0; text-align: center; font-size: 20px;}
            .btn-secondary { width: 100%; text-align: center; }

            table, thead, tbody, th, td, tr { 
                display: block; 
                width: 100%;
            }
            
            thead tr { 
                display: none;
            }
            
            tr { 
                background: var(--bg-card);
                border: 1px solid var(--border-color); 
                margin-bottom: 20px; 
                border-radius: var(--radius); 
                box-shadow: 0 4px 15px rgba(0,0,0,0.2);
                padding: 15px;
                position: relative;
            }
            
            td { 
                border: none;
                border-bottom: 1px solid rgba(255,255,255,0.05); 
                position: relative;
                padding: 12px 10px 12px 40%; 
                text-align: left;
                font-size: 15px;
            }

            td:last-child {
                border-bottom: none;
            }
            
            td:before { 
                position: absolute;
                top: 12px;
                right: 10px;
                width: auto; 
                padding-right: 0; 
                white-space: nowrap;
                text-align: right;
                font-weight: 700;
                color: var(--text-secondary);
                font-size: 13px;
            }
            
            /* Enhanced Mobile Table Labels */
            td:nth-of-type(1) {
                background: rgba(255,255,255,0.02);
                border-radius: var(--radius) var(--radius) 0 0;
                margin: -15px -15px 10px -15px;
                padding: 15px;
                text-align: right;
            }
            td:nth-of-type(1):before { content: ""; display: none; } /* Hide label for name row */

            td:nth-of-type(2):before { content: "سنة المواليد:"; display: inline-block; }
            td:nth-of-type(3):before { content: "تاريخ الاشتراك:"; display: inline-block; }
            td:nth-of-type(4):before { content: "متبقي للاشتراك:"; display: inline-block; }
            td:nth-of-type(5):before { content: "القيمة:"; display: inline-block; }
            td:nth-of-type(6):before { content: "الفئة المحددة:"; display: inline-block; }
            td:nth-of-type(7):before { content: "الجهة التابع لها:"; display: inline-block; }
            td:nth-of-type(8):before { content: "الحالة الحالية:"; display: inline-block; }
        }
    </style>
</head>
<body class="dashboard-body">

    <!-- Top Navigation -->
    <nav class="top-nav">
        <div class="nav-brand">
            <img src="{{ asset('logo.jpg') }}" alt="Logo" class="nav-logo" onerror="this.src='https://via.placeholder.com/45?text=Logo';">
            <h1>The Eagle Academy</h1>
        </div>
        <div class="top-actions">
            <a href="{{ route('players.create') }}" class="btn-top-nav">➕ تسجيل لاعب</a>
            <a href="{{ route('dashboard') }}" class="btn-top-nav secondary">🔙 لوحة التحكم</a>
            <a href="{{ route('reports.index') }}" class="btn-top-nav" style="background: rgba(241, 196, 15, 0.15); color: #f1c40f; border-color: rgba(241, 196, 15, 0.3);">📊 التقارير</a>
            <div class="user-profile">
                مرحباً بك، <span>الكابتن 🦅</span>
            </div>
        </div>
    </nav>

    <main class="dashboard-wrapper">
        <div class="table-wrapper">
            
            <div class="header-actions">
                <h2>قائمة اللاعبين المسجلين</h2>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>اللاعب</th>
                        <th>سنة المواليد</th>
                        <th>تاريخ الإشتراك</th>
                        <th>متبقي (أيام)</th>
                        <th>القيمة</th>
                        <th>الفئة</th>
                        <th>الجهة</th>
                        <th>الحالة</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($players as $player)
                        @php
                            $expirationDate = \Carbon\Carbon::parse($player->expiration_date)->startOfDay();
                            $today = \Carbon\Carbon::now()->startOfDay();
                            $daysRemaining = $today->diffInDays($expirationDate, false); // false keeps it negative if in the past
                        @endphp
                        <tr>
                            <td>
                                <div class="player-info">
                                    <div class="avatar">{{ mb_substr($player->name, 0, 1) }}</div>
                                    <span style="font-size: 18px; font-weight: 800;">{{ $player->name }}</span>
                                </div>
                            </td>
                            <td>{{ $player->birth_year }}</td>
                            <td>{{ $player->subscription_date }}</td>
                            
                            <!-- Days Remaining Column -->
                            <td style="font-size: 16px; font-weight: 900;">
                                @if($daysRemaining > 0)
                                    <span style="color: {{ $daysRemaining <= 7 ? '#f39c12' : '#2ecc71' }};">
                                        {{ $daysRemaining }} أيام
                                    </span>
                                @elseif($daysRemaining == 0)
                                     <span style="color: #f39c12;">اليوم!</span>
                                @else
                                    <span style="color: #e74c3c;">منتهي منذ {{ abs($daysRemaining) }} يوم</span>
                                @endif
                            </td>

                            <td style="color: #2ecc71; font-weight: bold;">{{ $player->fee }} ج.م</td>
                            <td>
                                <span class="badge {{ $player->category == 'براعم' ? 'badge-red' : 'badge-gray' }}">
                                    {{ $player->category }}
                                </span>
                            </td>
                            <td>{{ $player->source }}</td>
                            
                            <!-- Status Column -->
                            <td>
                                @if($daysRemaining < 0)
                                    <span class="status-expired">❌ منتهي</span>
                                @elseif($daysRemaining <= 7)
                                    <span class="status-warning">⚠️ قريباً</span>
                                @else
                                    <span class="status-active">✔ ساري</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" style="text-align: center; padding: 30px; color: var(--text-secondary);">
                                لا يوجد لاعبين مسجلين حتى الآن.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

        </div>
    </main>

</body>
</html>
