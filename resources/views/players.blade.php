@extends('layouts.admin')

@section('title', 'قائمة اللاعبين')
@section('pageTitle', 'سجل اللاعبين')

@push('styles')
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

        .btn-action-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            border: none;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            text-decoration: none;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .btn-whatsapp-icon {
            background: rgba(46, 204, 113, 0.15);
            color: #2ecc71;
            border: 1px solid rgba(46, 204, 113, 0.3);
        }

        .btn-whatsapp-icon:hover {
            background: #2ecc71;
            color: #fff;
            transform: translateY(-3px) scale(1.05);
            box-shadow: 0 10px 15px -3px rgba(46, 204, 113, 0.4);
        }

        .btn-eval-icon {
            background: rgba(241, 196, 15, 0.15);
            color: #f1c40f;
            border: 1px solid rgba(241, 196, 15, 0.3);
        }

        .btn-eval-icon:hover {
            background: #f1c40f;
            color: #000;
            transform: translateY(-3px) scale(1.05);
            box-shadow: 0 10px 15px -3px rgba(241, 196, 15, 0.4);
        }

        .btn-renew-icon {
            background: rgba(46, 204, 113, 0.12);
            color: #2ecc71;
            border: 1px solid rgba(46, 204, 113, 0.35);
            font-size: 1.1rem;
        }

        .btn-renew-icon:hover {
            background: #27ae60;
            color: #fff;
            transform: translateY(-3px) scale(1.05);
            box-shadow: 0 10px 15px -3px rgba(46, 204, 113, 0.35);
        }

        .renew-preview {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid var(--border-color);
            border-radius: var(--radius);
            padding: 12px 14px;
            margin-bottom: 18px;
            font-size: 13px;
            color: var(--text-secondary);
            line-height: 1.7;
        }

        .renew-preview strong {
            color: var(--text-primary);
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.7);
            backdrop-filter: blur(5px);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .modal.show {
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 1;
        }

        .modal-content {
            background-color: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius);
            width: 90%;
            max-width: 500px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.5);
            transform: translateY(-20px);
            transition: transform 0.3s ease;
            position: relative;
        }

        .modal.show .modal-content {
            transform: translateY(0);
        }

        .modal-header {
            padding: 20px;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-title {
            color: var(--primary-color);
            margin: 0;
            font-size: 20px;
        }

        .close-btn {
            color: var(--text-secondary);
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
            transition: color 0.3s;
        }

        .close-btn:hover {
            color: var(--primary-red);
        }

        .modal-body {
            padding: 20px;
        }

        .eval-slider-container {
            margin-bottom: 20px;
        }

        .eval-slider-container label {
            display: flex;
            justify-content: space-between;
            color: var(--text-primary);
            margin-bottom: 10px;
            font-weight: bold;
        }

        .eval-slider-container input[type=range] {
            width: 100%;
            accent-color: #f1c40f;
        }

        /* Star Rating Widget */
        .star-rating {
            display: flex;
            flex-direction: row-reverse;
            justify-content: flex-end;
            gap: 5px;
        }

        .star-rating input {
            display: none;
        }

        .star-rating label {
            font-size: 35px;
            color: rgba(255, 255, 255, 0.2);
            cursor: pointer;
            transition: all 0.2s ease;
            display: inline-block !important;
            margin: 0 !important;
            line-height: 1;
            text-shadow: 0 2px 4px rgba(0,0,0,0.3);
        }

        .star-rating input:checked ~ label,
        .star-rating label:hover,
        .star-rating label:hover ~ label {
            color: #f1c40f;
            text-shadow: 0 0 10px rgba(241, 196, 15, 0.5);
            transform: scale(1.1);
        }
        
        .modal-footer {
            padding: 20px;
            border-top: 1px solid var(--border-color);
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

        .player-info {
            display: flex;
            align-items: center;
        }

        @media (max-width: 768px) {
            .table-wrapper {
                padding: 10px;
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

            .header-actions h2 { border: none; padding: 0; text-align: center; font-size: 20px; }
            .btn-secondary { width: 100%; text-align: center; }

            /* Reset all table elements to block */
            .table-wrapper table,
            .table-wrapper thead,
            .table-wrapper tbody,
            .table-wrapper th,
            .table-wrapper td,
            .table-wrapper tr { 
                display: block; 
                width: 100%;
            }
            
            .table-wrapper thead tr { 
                display: none;
            }
            
            /* Each row = a card */
            .table-wrapper tbody tr { 
                background: var(--bg-card);
                border: 1px solid var(--border-color); 
                margin-bottom: 20px; 
                border-radius: var(--radius); 
                box-shadow: 0 4px 15px rgba(0,0,0,0.2);
                padding: 0;
                overflow: hidden;
            }

            /* All td cells - reset */
            .table-wrapper td { 
                border: none;
                border-bottom: 1px solid rgba(255,255,255,0.06); 
                position: relative;
                padding: 14px 15px 14px 15px;
                text-align: right;
                font-size: 14px;
                display: flex;
                justify-content: space-between;
                align-items: center;
                gap: 10px;
            }

            .table-wrapper td:last-child {
                border-bottom: none;
            }

            /* Remove ALL global td:before labels - we use our own */
            .table-wrapper td:before { 
                content: none !important;
                display: none !important;
            }

            /* ---- Player Name (1st td) - Card Header ---- */
            .table-wrapper td:nth-of-type(1) {
                background: linear-gradient(135deg, rgba(211, 47, 47, 0.1) 0%, rgba(30, 34, 39, 0.9) 100%);
                padding: 18px 15px;
                justify-content: center;
                border-bottom: 2px solid rgba(211, 47, 47, 0.3);
            }
            .table-wrapper td:nth-of-type(1) .player-info {
                justify-content: center;
                gap: 10px;
            }

            /* ---- Data rows (2nd to 9th td) - Label : Value ---- */
            .table-wrapper td:nth-of-type(2):after,
            .table-wrapper td:nth-of-type(3):after,
            .table-wrapper td:nth-of-type(4):after,
            .table-wrapper td:nth-of-type(5):after,
            .table-wrapper td:nth-of-type(6):after,
            .table-wrapper td:nth-of-type(7):after,
            .table-wrapper td:nth-of-type(8):after,
            .table-wrapper td:nth-of-type(9):after {
                font-weight: 700;
                color: var(--text-secondary);
                font-size: 12px;
                order: 2;
                flex-shrink: 0;
                white-space: nowrap;
            }

            .table-wrapper td:nth-of-type(2):after { content: "الكود"; }
            .table-wrapper td:nth-of-type(3):after { content: "سنة المواليد"; }
            .table-wrapper td:nth-of-type(4):after { content: "تاريخ الاشتراك"; }
            .table-wrapper td:nth-of-type(5):after { content: "المتبقي"; }
            .table-wrapper td:nth-of-type(6):after { content: "القيمة"; }
            .table-wrapper td:nth-of-type(7):after { content: "الفئة"; }
            .table-wrapper td:nth-of-type(8):after { content: "الجهة"; }
            .table-wrapper td:nth-of-type(9):after { content: "الحالة"; }

            /* Value text sits on the left (start in RTL) */
            .table-wrapper td:nth-of-type(n+2):nth-of-type(-n+9) {
                flex-direction: row-reverse;
            }

            /* ---- Actions (10th td) - Card Footer ---- */
            .table-wrapper td:nth-of-type(10) {
                background: rgba(0, 0, 0, 0.15);
                padding: 12px 15px;
                justify-content: center;
                border-bottom: none;
            }
            .table-wrapper td:nth-of-type(10) > div {
                justify-content: center;
                width: 100%;
            }

            /* Avatar adjustments */
            .table-wrapper .avatar {
                width: 36px;
                height: 36px;
                font-size: 16px;
            }

            /* Player info layout in card header */
            .table-wrapper .player-info {
                flex-direction: row;
                align-items: center;
            }
        }
    </style>
@endpush

@section('content')
    <main class="dashboard-wrapper">
        <div class="table-wrapper">
            
            <div class="header-actions">
                <h2>قائمة اللاعبين المسجلين</h2>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>اللاعب</th>
                        <th>الكود</th>
                        <th>سنة المواليد</th>
                        <th>تاريخ الإشتراك</th>
                        <th>متبقي (أيام)</th>
                        <th>القيمة</th>
                        <th>الفئة</th>
                        <th>الجهة</th>
                        <th>الحالة</th>
                        <th>إجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($players as $player)
                        @php
                            $expirationDate = \Carbon\Carbon::parse($player->expiration_date)->startOfDay();
                            $today = \Carbon\Carbon::now()->startOfDay();
                            $daysRemaining = $today->diffInDays($expirationDate, false); // false keeps it negative if in the past
                            
                            $whatsappMessage = "مرحباً، نود تذكيركم بأن اشتراك البطل ({$player->name}) في The Eagle Academy سينتهي بتاريخ {$player->expiration_date}. \n\nكود اللاعب للاستعلام من البوابة: {$player->player_code}";
                            $whatsappMessageEncoded = urlencode($whatsappMessage);
                            
                            $phone = $player->phone_number;
                            if ($phone) {
                                $phone = preg_replace('/[^0-9]/', '', $phone);
                                if (str_starts_with($phone, '01')) {
                                    $phone = '2' . $phone;
                                }
                            }
                        @endphp
                        <tr>
                            <td>
                                <a href="{{ route('players.profile', $player->id) }}" style="text-decoration: none; color: inherit;">
                                    <div class="player-info" style="cursor: pointer; transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'" title="عرض الملف الشخصي">
                                        <div class="avatar">{{ mb_substr($player->name, 0, 1) }}</div>
                                        <span style="font-size: 18px; font-weight: 800; color: var(--primary); text-decoration: underline; text-underline-offset: 4px; text-decoration-color: rgba(241,196,15,0.3);">{{ $player->name }}</span>
                                    </div>
                                </a>
                            </td>
                            <td><span style="background: rgba(255,255,255,0.1); padding: 4px 8px; border-radius: 4px; font-family: monospace;">{{ $player->player_code }}</span></td>
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
                            
                            <!-- Actions Column -->
                            <td>
                                <div style="display: flex; gap: 10px; align-items: center;">
                                    @if($phone)
                                        <a href="https://wa.me/{{ $phone }}?text={{ $whatsappMessageEncoded }}" target="_blank" class="btn-action-icon btn-whatsapp-icon" title="إرسال تذكير عبر واتساب">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                                                <path d="M13.601 2.326A7.85 7.85 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.9 7.9 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.9 7.9 0 0 0 13.6 2.326zM7.994 14.521a6.6 6.6 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.56 6.56 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592m3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.73.73 0 0 0-.529.247c-.182.198-.691.677-.691 1.654s.71 1.916.81 2.049c.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232"/>
                                            </svg>
                                        </a>
                                    @endif
                                    
                                    <button type="button"
                                            class="btn-action-icon btn-renew-icon"
                                            data-player-id="{{ $player->id }}"
                                            data-player-name="{{ $player->name }}"
                                            data-subscription-date="{{ $player->subscription_date }}"
                                            data-expiration-date="{{ $player->expiration_date }}"
                                            data-player-fee="{{ (float) $player->fee }}"
                                            title="تجديد الاشتراك">
                                        🔄
                                    </button>

                                    <button class="btn-action-icon btn-eval-icon" onclick="openEvalModal({{ $player->id }}, '{{ $player->name }}', {{ $player->tech_score ?? 5 }}, {{ $player->speed_score ?? 5 }}, {{ $player->defense_score ?? 5 }}, {{ $player->fitness_score ?? 5 }}, {{ $player->discipline_score ?? 5 }}, '{{ addslashes($player->coach_notes) }}')" title="تقييم اللاعب">
                                        ⭐
                                    </button>
                                </div>
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

    <!-- Renewal Modal -->
    <div id="renewModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">🔄 تجديد اشتراك: <span id="renewPlayerName"></span></h3>
                <span class="close-btn" onclick="closeRenewModal()">&times;</span>
            </div>
            <form id="renewForm" onsubmit="event.preventDefault(); submitRenewal();">
                <div class="modal-body">
                    <input type="hidden" id="renewPlayerId">

                    <div class="renew-preview" id="renewPreview"></div>

                    <div class="form-group" style="margin-bottom: 16px;">
                        <label for="renewSubDate">تاريخ بداية الاشتراك</label>
                        <input type="date" id="renewSubDate" required style="width: 100%; padding: 10px; border-radius: var(--radius); background: var(--input-bg); border: 1px solid var(--border-color); color: var(--text-primary); font-family: 'Cairo', sans-serif;">
                    </div>

                    <div class="form-group" style="margin-bottom: 16px;">
                        <label for="renewExpDate">تاريخ انتهاء الاشتراك</label>
                        <input type="date" id="renewExpDate" required style="width: 100%; padding: 10px; border-radius: var(--radius); background: var(--input-bg); border: 1px solid var(--border-color); color: var(--text-primary); font-family: 'Cairo', sans-serif;">
                    </div>

                    <div class="form-group" style="margin-bottom: 0;">
                        <label for="renewalFee">المبلغ المدفوع (ج.م)</label>
                        <input type="number" id="renewalFee" min="0" step="0.01" required placeholder="مثال: 500" style="width: 100%; padding: 10px; border-radius: var(--radius); background: var(--input-bg); border: 1px solid var(--border-color); color: var(--text-primary); font-family: 'Cairo', sans-serif;">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-secondary" onclick="closeRenewModal()">إلغاء</button>
                    <button type="submit" class="btn-primary" id="renewSubmitBtn" style="width: auto; padding: 12px 24px;">تأكيد التجديد</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Evaluation Modal -->
    <div id="evalModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">⭐ تقييم الأداء: <span id="evalPlayerName"></span></h3>
                <span class="close-btn" onclick="closeEvalModal()">&times;</span>
            </div>
            <form id="evalForm">
                <div class="modal-body">
                    <input type="hidden" id="evalPlayerId">
                    
                    <div class="form-group" style="margin-bottom: 20px;">
                        <label for="evalDate">تاريخ التقييم</label>
                        <input type="date" id="evalDate" style="width: 100%; padding: 10px; border-radius: var(--radius); background: var(--input-bg); border: 1px solid var(--border-color); color: var(--text-primary); font-family: 'Cairo', sans-serif;" required>
                    </div>

                    <div class="eval-slider-container">
                        <label style="margin-bottom: 0;">الأساسيات الفنية (Technical Skills)</label>
                        <div class="star-rating">
                            <input type="radio" id="tech5" name="tech_score" value="5"><label for="tech5">★</label>
                            <input type="radio" id="tech4" name="tech_score" value="4"><label for="tech4">★</label>
                            <input type="radio" id="tech3" name="tech_score" value="3"><label for="tech3">★</label>
                            <input type="radio" id="tech2" name="tech_score" value="2"><label for="tech2">★</label>
                            <input type="radio" id="tech1" name="tech_score" value="1"><label for="tech1">★</label>
                        </div>
                    </div>

                    <div class="eval-slider-container">
                        <label style="margin-bottom: 0;">السرعة ورد الفعل (Speed & Reflexes)</label>
                        <div class="star-rating">
                            <input type="radio" id="speed5" name="speed_score" value="5"><label for="speed5">★</label>
                            <input type="radio" id="speed4" name="speed_score" value="4"><label for="speed4">★</label>
                            <input type="radio" id="speed3" name="speed_score" value="3"><label for="speed3">★</label>
                            <input type="radio" id="speed2" name="speed_score" value="2"><label for="speed2">★</label>
                            <input type="radio" id="speed1" name="speed_score" value="1"><label for="speed1">★</label>
                        </div>
                    </div>
                    
                    <div class="eval-slider-container">
                        <label style="margin-bottom: 0;">الدفاع والمراوغة (Defense & Evasion)</label>
                        <div class="star-rating">
                            <input type="radio" id="defense5" name="defense_score" value="5"><label for="defense5">★</label>
                            <input type="radio" id="defense4" name="defense_score" value="4"><label for="defense4">★</label>
                            <input type="radio" id="defense3" name="defense_score" value="3"><label for="defense3">★</label>
                            <input type="radio" id="defense2" name="defense_score" value="2"><label for="defense2">★</label>
                            <input type="radio" id="defense1" name="defense_score" value="1"><label for="defense1">★</label>
                        </div>
                    </div>
                    
                    <div class="eval-slider-container">
                        <label style="margin-bottom: 0;">اللياقة وقوة التحمل (Stamina)</label>
                        <div class="star-rating">
                            <input type="radio" id="fitness5" name="fitness_score" value="5"><label for="fitness5">★</label>
                            <input type="radio" id="fitness4" name="fitness_score" value="4"><label for="fitness4">★</label>
                            <input type="radio" id="fitness3" name="fitness_score" value="3"><label for="fitness3">★</label>
                            <input type="radio" id="fitness2" name="fitness_score" value="2"><label for="fitness2">★</label>
                            <input type="radio" id="fitness1" name="fitness_score" value="1"><label for="fitness1">★</label>
                        </div>
                    </div>
                    
                    <div class="eval-slider-container">
                        <label style="margin-bottom: 0;">الروح القتالية والانضباط (Discipline)</label>
                        <div class="star-rating">
                            <input type="radio" id="discipline5" name="discipline_score" value="5"><label for="discipline5">★</label>
                            <input type="radio" id="discipline4" name="discipline_score" value="4"><label for="discipline4">★</label>
                            <input type="radio" id="discipline3" name="discipline_score" value="3"><label for="discipline3">★</label>
                            <input type="radio" id="discipline2" name="discipline_score" value="2"><label for="discipline2">★</label>
                            <input type="radio" id="discipline1" name="discipline_score" value="1"><label for="discipline1">★</label>
                        </div>
                    </div>

                    <div class="form-group" style="margin-top: 15px;">
                        <label for="coachNotes">ملاحظات المدرب (اختياري)</label>
                        <textarea id="coachNotes" rows="3" placeholder="أضف نصيحة أو تعليق لولي الأمر..." style="width: 100%; padding: 10px; border-radius: var(--radius); background: var(--input-bg); border: 1px solid var(--border-color); color: var(--text-primary); font-family: 'Cairo', sans-serif; resize: vertical;"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-secondary" onclick="closeEvalModal()">إلغاء</button>
                    <button type="button" class="btn-primary" onclick="submitEvaluation()" id="evalSubmitBtn">حفظ التقييم ✔</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        const modal = document.getElementById('evalModal');
        const renewModal = document.getElementById('renewModal');
        const renewUrlTemplate = @json(route('players.renew', ['id' => '__ID__']));

        document.querySelectorAll('.btn-renew-icon').forEach(function(btn) {
            btn.addEventListener('click', function() {
                openRenewModal(
                    this.dataset.playerId,
                    this.dataset.playerName,
                    this.dataset.subscriptionDate,
                    this.dataset.expirationDate,
                    parseFloat(this.dataset.playerFee) || 0
                );
            });
        });

        function parseDateOnly(value) {
            const [y, m, d] = String(value).split('-').map(Number);
            return new Date(y, m - 1, d);
        }

        function formatDateOnly(date) {
            const y = date.getFullYear();
            const m = String(date.getMonth() + 1).padStart(2, '0');
            const d = String(date.getDate()).padStart(2, '0');
            return `${y}-${m}-${d}`;
        }

        function addDays(date, days) {
            const result = new Date(date);
            result.setDate(result.getDate() + days);
            return result;
        }

        function computeRenewalDefaults(subscriptionDate, expirationDate) {
            const today = new Date();
            today.setHours(0, 0, 0, 0);

            const currentSub = parseDateOnly(subscriptionDate);
            const currentExp = parseDateOnly(expirationDate);

            const periodDays = Math.max(
                1,
                Math.round((currentExp - currentSub) / (1000 * 60 * 60 * 24))
            );

            let newStart;
            if (currentExp >= today) {
                newStart = addDays(currentExp, 1);
            } else {
                newStart = new Date(today);
            }

            const newEnd = addDays(newStart, periodDays);

            return {
                subscription_date: formatDateOnly(newStart),
                expiration_date: formatDateOnly(newEnd),
                periodDays,
            };
        }

        function openRenewModal(id, name, subscriptionDate, expirationDate, currentFee) {
            document.getElementById('renewPlayerId').value = id;
            document.getElementById('renewPlayerName').textContent = name;

            const defaults = computeRenewalDefaults(subscriptionDate, expirationDate);
            document.getElementById('renewSubDate').value = defaults.subscription_date;
            document.getElementById('renewExpDate').value = defaults.expiration_date;
            document.getElementById('renewalFee').value = '';

            const today = new Date();
            today.setHours(0, 0, 0, 0);
            const exp = parseDateOnly(expirationDate);
            const daysRemaining = Math.round((exp - today) / (1000 * 60 * 60 * 24));
            let statusText = daysRemaining < 0
                ? 'منتهي'
                : (daysRemaining <= 7 ? `قريباً (${daysRemaining} أيام)` : `ساري (${daysRemaining} أيام)`);

            document.getElementById('renewPreview').innerHTML =
                `<strong>الاشتراك الحالي:</strong> من ${subscriptionDate} إلى ${expirationDate}<br>` +
                `<strong>الحالة:</strong> ${statusText}<br>` +
                `<strong>إجمالي المدفوع سابقاً:</strong> ${currentFee} ج.م<br>` +
                `<strong>مدة التجديد المقترحة:</strong> ${defaults.periodDays} يوم`;

            renewModal.classList.add('show');
        }

        function closeRenewModal() {
            renewModal.classList.remove('show');
        }

        async function submitRenewal() {
            const id = document.getElementById('renewPlayerId').value;
            const btn = document.getElementById('renewSubmitBtn');
            const originalText = btn.innerHTML;

            btn.innerHTML = 'جاري الحفظ...';
            btn.disabled = true;

            const data = {
                subscription_date: document.getElementById('renewSubDate').value,
                expiration_date: document.getElementById('renewExpDate').value,
                renewal_fee: document.getElementById('renewalFee').value,
            };

            try {
                const response = await fetch(renewUrlTemplate.replace('__ID__', id), {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    },
                    body: JSON.stringify(data),
                });

                if (!response.ok) {
                    let message = 'حدث خطأ أثناء التجديد.';
                    try {
                        const err = await response.json();
                        if (err.message) message = err.message;
                        if (err.errors) {
                            message = Object.values(err.errors).flat().join('\n');
                        }
                    } catch (e) {
                        const errText = await response.text();
                        if (errText) message = errText.substring(0, 200);
                    }
                    alert(message);
                    btn.innerHTML = originalText;
                    btn.disabled = false;
                    return;
                }

                const result = await response.json();

                if (result.success) {
                    btn.innerHTML = 'تم التجديد';
                    setTimeout(() => location.reload(), 600);
                } else {
                    alert(result.message || 'حدث خطأ أثناء التجديد.');
                    btn.innerHTML = originalText;
                    btn.disabled = false;
                }
            } catch (error) {
                console.error(error);
                alert('خطأ في الاتصال بالسيرفر: ' + error.message);
                btn.innerHTML = originalText;
                btn.disabled = false;
            }
        }

        function setCheckedRadio(name, value) {
            // Convert old 10-scale to 5-scale if needed
            let starValue = value > 5 ? Math.ceil(value / 2) : value;
            if (starValue < 1) starValue = 1;
            const radio = document.querySelector(`input[name="${name}"][value="${starValue}"]`);
            if (radio) radio.checked = true;
        }

        function openEvalModal(id, name, tech, speed, defense, fitness, discipline, notes) {
            document.getElementById('evalPlayerId').value = id;
            document.getElementById('evalPlayerName').innerText = name;
            document.getElementById('evalDate').value = new Date().toISOString().split('T')[0];
            
            setCheckedRadio('tech_score', tech);
            setCheckedRadio('speed_score', speed);
            setCheckedRadio('defense_score', defense);
            setCheckedRadio('fitness_score', fitness);
            setCheckedRadio('discipline_score', discipline);
            
            document.getElementById('coachNotes').value = notes;

            modal.classList.add('show');
        }

        function closeEvalModal() {
            modal.classList.remove('show');
        }

        window.onclick = function(event) {
            if (event.target === modal) {
                closeEvalModal();
            }
            if (event.target === renewModal) {
                closeRenewModal();
            }
        };

        async function submitEvaluation() {
            const id = document.getElementById('evalPlayerId').value;
            const btn = document.getElementById('evalSubmitBtn');
            const originalText = btn.innerHTML;
            
            btn.innerHTML = 'جاري الحفظ... ⏳';
            btn.disabled = true;

            const data = {
                _token: '{{ csrf_token() }}',
                evaluation_date: document.getElementById('evalDate').value,
                tech_score: document.querySelector('input[name="tech_score"]:checked')?.value || 1,
                speed_score: document.querySelector('input[name="speed_score"]:checked')?.value || 1,
                defense_score: document.querySelector('input[name="defense_score"]:checked')?.value || 1,
                fitness_score: document.querySelector('input[name="fitness_score"]:checked')?.value || 1,
                discipline_score: document.querySelector('input[name="discipline_score"]:checked')?.value || 1,
                coach_notes: document.getElementById('coachNotes').value
            };

            try {
                const response = await fetch(`/players/${id}/evaluate`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify(data)
                });

                if (!response.ok) {
                    const errText = await response.text();
                    console.error("Server Error:", errText);
                    alert('خطأ من السيرفر: ' + errText.substring(0, 100));
                    btn.innerHTML = originalText;
                    btn.disabled = false;
                    return;
                }

                const result = await response.json();

                if (result.success) {
                    btn.innerHTML = 'تم الحفظ ✔';
                    btn.style.background = '#2ecc71';
                    setTimeout(() => {
                        closeEvalModal();
                        btn.innerHTML = originalText;
                        btn.style.background = '';
                        btn.disabled = false;
                    }, 1500);
                } else {
                    alert('حدث خطأ أثناء الحفظ.');
                    btn.innerHTML = originalText;
                    btn.disabled = false;
                }
            } catch (error) {
                console.error(error);
                alert('خطأ في الاتصال بالسيرفر: ' + error.message);
                btn.innerHTML = originalText;
                btn.disabled = false;
            }
        }
    </script>
@endpush
