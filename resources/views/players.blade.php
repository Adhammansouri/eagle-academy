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



    <script>
        const modal = document.getElementById('evalModal');

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
            if (event.target == modal) {
                closeEvalModal();
            }
        }

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
</body>
</html>
