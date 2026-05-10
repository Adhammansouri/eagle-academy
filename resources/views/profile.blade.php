<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>الملف الشخصي | {{ $player->name }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root {
            --bg-dark: #0f172a;
            --bg-card: #1e293b;
            --primary: #f1c40f;
            --text-primary: #f8fafc;
            --text-secondary: #94a3b8;
            --radius: 12px;
        }

        body {
            font-family: 'Cairo', sans-serif;
            background-color: var(--bg-dark);
            color: var(--text-primary);
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .back-btn {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: var(--radius);
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .back-btn:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        .profile-card {
            background: var(--bg-card);
            border-radius: var(--radius);
            padding: 25px;
            margin-bottom: 30px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .player-info h1 {
            color: var(--primary);
            margin: 0 0 10px 0;
        }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-top: 20px;
        }

        .info-item {
            background: rgba(0,0,0,0.2);
            padding: 15px;
            border-radius: 8px;
        }

        .info-label {
            color: var(--text-secondary);
            font-size: 0.85rem;
            margin-bottom: 5px;
        }

        .info-value {
            font-weight: 600;
            font-size: 1.1rem;
        }

        .chart-container {
            position: relative;
            height: 300px;
            width: 100%;
            background: rgba(0,0,0,0.2);
            border-radius: var(--radius);
            padding: 15px;
            box-sizing: border-box;
        }

        .section-card {
            background: var(--bg-card);
            border-radius: var(--radius);
            padding: 25px;
            margin-bottom: 30px;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            padding-bottom: 15px;
            margin-bottom: 20px;
        }

        .section-header h2 { color: var(--primary); margin: 0; }

        .btn-add {
            background: var(--primary);
            color: #000;
            border: none;
            padding: 8px 16px;
            border-radius: 8px;
            font-family: 'Cairo', sans-serif;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s;
        }
        .btn-add:hover { transform: scale(1.05); box-shadow: 0 4px 15px rgba(241,196,15,0.4); }

        .record-cards {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            margin-bottom: 20px;
        }

        .record-card {
            background: rgba(0,0,0,0.2);
            padding: 20px;
            border-radius: 10px;
            text-align: center;
        }
        .record-card .num { font-size: 2.5rem; font-weight: 800; }
        .record-card .label { color: var(--text-secondary); font-size: 0.85rem; }
        .record-card.win .num { color: #2ecc71; }
        .record-card.loss .num { color: #e74c3c; }
        .record-card.draw .num { color: #f39c12; }

        .fight-row {
            display: grid;
            grid-template-columns: 80px 1fr 100px 80px;
            gap: 10px;
            align-items: center;
            padding: 12px;
            background: rgba(0,0,0,0.15);
            border-radius: 8px;
            margin-bottom: 8px;
        }
        .fight-result { padding: 4px 10px; border-radius: 6px; font-weight: 700; text-align: center; font-size: 0.8rem; }
        .fight-result.win { background: rgba(46,204,113,0.2); color: #2ecc71; }
        .fight-result.loss { background: rgba(231,76,60,0.2); color: #e74c3c; }
        .fight-result.draw { background: rgba(243,156,18,0.2); color: #f39c12; }

        .medal-badge { font-size: 1.5rem; }

        .tournament-row {
            display: grid;
            grid-template-columns: 40px 1fr 100px;
            gap: 10px;
            align-items: center;
            padding: 12px;
            background: rgba(0,0,0,0.15);
            border-radius: 8px;
            margin-bottom: 8px;
        }

        .modal-overlay {
            display: none; position: fixed; z-index: 1000; left: 0; top: 0;
            width: 100%; height: 100%; background: rgba(0,0,0,0.7);
            backdrop-filter: blur(5px); align-items: center; justify-content: center;
        }
        .modal-overlay.show { display: flex; }
        .modal-box {
            background: var(--bg-card); border-radius: var(--radius);
            width: 90%; max-width: 500px; padding: 25px;
            max-height: 80vh; overflow-y: auto;
        }
        .modal-box h3 { color: var(--primary); margin-top: 0; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; color: var(--text-secondary); font-size: 0.9rem; }
        .form-input {
            width: 100%; padding: 10px; border-radius: 8px; border: 1px solid rgba(255,255,255,0.1);
            background: rgba(0,0,0,0.3); color: var(--text-primary); font-family: 'Cairo', sans-serif;
            box-sizing: border-box;
        }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
        .btn-submit {
            background: var(--primary); color: #000; border: none; padding: 12px 24px;
            border-radius: 8px; font-family: 'Cairo', sans-serif; font-weight: 700;
            cursor: pointer; width: 100%; font-size: 1rem; transition: all 0.3s;
        }
        .btn-cancel {
            background: rgba(255,255,255,0.1); color: white; border: none; padding: 12px 24px;
            border-radius: 8px; font-family: 'Cairo', sans-serif; cursor: pointer; width: 100%;
        }

        .timeline-section {
            background: var(--bg-card);
            border-radius: var(--radius);
            padding: 25px;
            margin-bottom: 30px;
        }

        .timeline-title {
            color: var(--primary);
            border-bottom: 1px solid rgba(255,255,255,0.1);
            padding-bottom: 15px;
            margin-top: 0;
        }

        .timeline {
            position: relative;
            padding-right: 30px;
            border-right: 2px solid var(--primary);
            margin-top: 20px;
        }

        .timeline-item {
            position: relative;
            margin-bottom: 30px;
            background: rgba(0,0,0,0.2);
            padding: 20px;
            border-radius: 8px;
        }

        .timeline-item::before {
            content: '';
            position: absolute;
            right: -37px;
            top: 20px;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: var(--primary);
            border: 4px solid var(--bg-card);
        }

        .eval-date {
            color: var(--primary);
            font-weight: bold;
            margin-bottom: 15px;
            font-size: 1.1rem;
        }

        .stars-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 15px;
        }

        .star-box {
            background: rgba(255,255,255,0.05);
            padding: 10px;
            border-radius: 6px;
            text-align: center;
        }

        .star-label {
            color: var(--text-secondary);
            font-size: 0.9rem;
            margin-bottom: 5px;
        }

        .star-value {
            color: var(--primary);
            font-size: 1.2rem;
            letter-spacing: 2px;
        }

        .coach-note {
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid rgba(255,255,255,0.1);
            color: #dfe6e9;
            font-style: italic;
        }

        .status-badge {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 20px;
            font-weight: bold;
            font-size: 0.85rem;
        }
        .status-active { background: rgba(46, 204, 113, 0.2); color: #2ecc71; }
        .status-expired { background: rgba(231, 76, 60, 0.2); color: #e74c3c; }

        @media (max-width: 768px) {
            .profile-card {
                grid-template-columns: 1fr;
                padding: 15px;
            }
            .info-grid {
                grid-template-columns: 1fr;
                gap: 10px;
            }
            .header {
                flex-direction: column;
                align-items: center;
                text-align: center;
                gap: 15px;
            }
            .stars-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            .chart-container {
                height: 250px;
            }
            .timeline-item::before {
                right: -27px;
                width: 10px;
                height: 10px;
            }
            .timeline {
                padding-right: 15px;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <a href="{{ route('players.list') }}" class="back-btn">🔙 العودة للوحة التحكم</a>
        <h2 style="margin:0; color: var(--text-secondary);">الملف الشخصي للملاكم</h2>
    </div>

    <div class="profile-card">
        <div class="player-info">
            <h1>{{ $player->name }}</h1>
            <div style="display: flex; gap: 10px; margin-bottom: 20px; align-items: center;">
                <div style="background: var(--primary); color: #000; padding: 5px 15px; border-radius: 20px; font-weight: bold; font-size: 0.9rem;">
                    {{ $player->category ?? 'غير محدد' }} | {{ $player->source }}
                </div>
                @php
                    $expirationDate = \Carbon\Carbon::parse($player->expiration_date);
                    $daysLeft = intval(now()->startOfDay()->diffInDays($expirationDate->startOfDay(), false));
                    $isActive = $daysLeft >= 0;
                @endphp
                <div class="status-badge {{ $isActive ? 'status-active' : 'status-expired' }}">
                    {{ $isActive ? '✔ ساري' : '❌ منتهي' }}
                </div>
            </div>
            
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">كود اللاعب</div>
                    <div class="info-value">{{ $player->player_code }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">سنة المواليد</div>
                    <div class="info-value">{{ $player->birth_year }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">تاريخ الإشتراك</div>
                    <div class="info-value">{{ $player->subscription_date }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">انتهاء الإشتراك</div>
                    <div class="info-value">{{ $player->expiration_date }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">المتبقي من الاشتراك</div>
                    <div class="info-value" style="color: {{ $isActive ? '#2ecc71' : '#e74c3c' }}">
                        {{ abs($daysLeft) }} {{ $isActive ? 'أيام' : 'أيام (تأخير)' }}
                    </div>
                </div>
                <div class="info-item">
                    <div class="info-label">قيمة الإشتراك</div>
                    <div class="info-value">{{ $player->fee }} ج.م</div>
                </div>
            </div>
        </div>

        <div class="chart-container">
            @if($player->evaluations->count() > 0)
                <canvas id="skillsChart"></canvas>
            @else
                <div style="height: 100%; display: flex; align-items: center; justify-content: center; color: var(--text-secondary);">
                    لا يوجد تقييمات لعرض الرسم البياني
                </div>
            @endif
        </div>
    </div>

    <div class="timeline-section">
        <h2 class="timeline-title">سجل التقييمات وتطور الأداء</h2>
        
        @if($player->evaluations->count() > 0)
            <div class="timeline">
                @foreach($player->evaluations as $eval)
                    <div class="timeline-item">
                        <div class="eval-date">📅 تقييم بتاريخ: {{ \Carbon\Carbon::parse($eval->evaluation_date)->format('Y-m-d') }}</div>
                        
                        <div class="stars-grid">
                            <div class="star-box">
                                <div class="star-label">الأساسيات الفنية</div>
                                <div class="star-value" dir="ltr">
                                    @for($i=1; $i<=5; $i++)
                                        <span style="color: {{ $i <= $eval->tech_score ? 'var(--primary)' : 'rgba(255,255,255,0.1)' }}">★</span>
                                    @endfor
                                </div>
                            </div>
                            <div class="star-box">
                                <div class="star-label">السرعة ورد الفعل</div>
                                <div class="star-value" dir="ltr">
                                    @for($i=1; $i<=5; $i++)
                                        <span style="color: {{ $i <= $eval->speed_score ? 'var(--primary)' : 'rgba(255,255,255,0.1)' }}">★</span>
                                    @endfor
                                </div>
                            </div>
                            <div class="star-box">
                                <div class="star-label">الدفاع والمراوغة</div>
                                <div class="star-value" dir="ltr">
                                    @for($i=1; $i<=5; $i++)
                                        <span style="color: {{ $i <= $eval->defense_score ? 'var(--primary)' : 'rgba(255,255,255,0.1)' }}">★</span>
                                    @endfor
                                </div>
                            </div>
                            <div class="star-box">
                                <div class="star-label">اللياقة البدنية</div>
                                <div class="star-value" dir="ltr">
                                    @for($i=1; $i<=5; $i++)
                                        <span style="color: {{ $i <= $eval->fitness_score ? 'var(--primary)' : 'rgba(255,255,255,0.1)' }}">★</span>
                                    @endfor
                                </div>
                            </div>
                            <div class="star-box">
                                <div class="star-label">الروح القتالية</div>
                                <div class="star-value" dir="ltr">
                                    @for($i=1; $i<=5; $i++)
                                        <span style="color: {{ $i <= $eval->discipline_score ? 'var(--primary)' : 'rgba(255,255,255,0.1)' }}">★</span>
                                    @endfor
                                </div>
                            </div>
                        </div>

                        @if($eval->coach_notes)
                            <div class="coach-note">
                                <strong>ملاحظة الكابتن:</strong> {{ $eval->coach_notes }}
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @else
            <div style="text-align: center; padding: 40px; color: var(--text-secondary);">
                لم يتم تقييم هذا اللاعب بعد.
            </div>
        @endif
    </div>

    <!-- Fight Record Section -->
    @php
        $wins = $player->fights->where('result', 'win')->count();
        $losses = $player->fights->where('result', 'loss')->count();
        $draws = $player->fights->where('result', 'draw')->count();
    @endphp
    <div class="section-card">
        <div class="section-header">
            <h2>🥊 سجل النزالات</h2>
            <button class="btn-add" onclick="document.getElementById('fightModal').classList.add('show')">+ إضافة نزال</button>
        </div>
        <div class="record-cards">
            <div class="record-card win"><div class="num">{{ $wins }}</div><div class="label">انتصارات</div></div>
            <div class="record-card loss"><div class="num">{{ $losses }}</div><div class="label">خسائر</div></div>
            <div class="record-card draw"><div class="num">{{ $draws }}</div><div class="label">تعادلات</div></div>
        </div>
        @foreach($player->fights as $fight)
            <div class="fight-row">
                <div class="fight-result {{ $fight->result }}">
                    {{ $fight->result == 'win' ? 'فوز' : ($fight->result == 'loss' ? 'خسارة' : 'تعادل') }}
                </div>
                <div>
                    <strong>vs {{ $fight->opponent_name }}</strong>
                    @if($fight->opponent_club)<span style="color:var(--text-secondary);font-size:0.85rem"> - {{ $fight->opponent_club }}</span>@endif
                    @if($fight->result_method)<span style="color:var(--text-secondary);font-size:0.8rem"> ({{ strtoupper($fight->result_method) }})</span>@endif
                </div>
                <div style="color:var(--text-secondary);font-size:0.85rem">{{ $fight->weight_class ?? '-' }}</div>
                <div style="color:var(--text-secondary);font-size:0.85rem">{{ \Carbon\Carbon::parse($fight->fight_date)->format('Y-m-d') }}</div>
            </div>
        @endforeach
        @if($player->fights->count() == 0)
            <div style="text-align:center;padding:20px;color:var(--text-secondary)">لا توجد نزالات مسجلة بعد.</div>
        @endif
    </div>

    <!-- Weight Tracking Section -->
    <div class="section-card">
        <div class="section-header">
            <h2>⚖️ تتبع الوزن</h2>
            <button class="btn-add" onclick="document.getElementById('weightModal').classList.add('show')">+ تسجيل وزن</button>
        </div>
        @if($player->weights->count() > 0)
            <div style="background:rgba(0,0,0,0.2);border-radius:10px;padding:15px;margin-bottom:15px">
                <canvas id="weightChart" height="200"></canvas>
            </div>
            @foreach($player->weights as $w)
                <div style="display:flex;justify-content:space-between;padding:10px;background:rgba(0,0,0,0.15);border-radius:8px;margin-bottom:6px;align-items:center">
                    <span style="font-weight:700">{{ $w->weight_kg }} كجم</span>
                    <span style="color:var(--text-secondary);font-size:0.85rem">{{ \Carbon\Carbon::parse($w->recorded_date)->format('Y-m-d') }}</span>
                </div>
            @endforeach
        @else
            <div style="text-align:center;padding:20px;color:var(--text-secondary)">لا توجد قياسات وزن مسجلة بعد.</div>
        @endif
    </div>

    <!-- Tournaments Section -->
    <div class="section-card">
        <div class="section-header">
            <h2>🏆 البطولات والميداليات</h2>
            <button class="btn-add" onclick="document.getElementById('tournamentModal').classList.add('show')">+ إضافة بطولة</button>
        </div>
        @foreach($player->tournaments as $t)
            <div class="tournament-row">
                <div class="medal-badge">
                    @if($t->medal == 'gold')🥇@elseif($t->medal == 'silver')🥈@elseif($t->medal == 'bronze')🥉@else🎗️@endif
                </div>
                <div>
                    <strong>{{ $t->tournament_name }}</strong>
                    @if($t->location)<span style="color:var(--text-secondary);font-size:0.85rem"> - {{ $t->location }}</span>@endif
                    @if($t->weight_class)<span style="color:var(--text-secondary);font-size:0.8rem"> ({{ $t->weight_class }})</span>@endif
                </div>
                <div style="color:var(--text-secondary);font-size:0.85rem">{{ \Carbon\Carbon::parse($t->tournament_date)->format('Y-m-d') }}</div>
            </div>
        @endforeach
        @if($player->tournaments->count() == 0)
            <div style="text-align:center;padding:20px;color:var(--text-secondary)">لا توجد بطولات مسجلة بعد.</div>
        @endif
    </div>

</div>

<!-- Fight Modal -->
<div id="fightModal" class="modal-overlay" onclick="if(event.target===this)this.classList.remove('show')">
    <div class="modal-box">
        <h3>🥊 إضافة نزال جديد</h3>
        <div class="form-row">
            <div class="form-group"><label>تاريخ النزال</label><input type="date" id="fightDate" class="form-input"></div>
            <div class="form-group"><label>فئة الوزن</label><input type="text" id="fightWeightClass" class="form-input" placeholder="مثل: 60 كجم"></div>
        </div>
        <div class="form-row">
            <div class="form-group"><label>اسم الخصم</label><input type="text" id="fightOpponent" class="form-input"></div>
            <div class="form-group"><label>نادي الخصم</label><input type="text" id="fightOpponentClub" class="form-input"></div>
        </div>
        <div class="form-row">
            <div class="form-group"><label>النتيجة</label>
                <select id="fightResult" class="form-input"><option value="win">فوز</option><option value="loss">خسارة</option><option value="draw">تعادل</option></select>
            </div>
            <div class="form-group"><label>طريقة الحسم</label>
                <select id="fightMethod" class="form-input"><option value="">-</option><option value="points">بالنقاط</option><option value="ko">KO</option><option value="tko">TKO</option><option value="rsc">RSC</option><option value="walkover">Walkover</option><option value="dq">استبعاد</option></select>
            </div>
        </div>
        <div class="form-group"><label>ملاحظات</label><textarea id="fightNotes" class="form-input" rows="2"></textarea></div>
        <div class="form-row" style="margin-top:10px">
            <button class="btn-cancel" onclick="document.getElementById('fightModal').classList.remove('show')">إلغاء</button>
            <button class="btn-submit" onclick="submitFight()">حفظ النزال ✔</button>
        </div>
    </div>
</div>

<!-- Weight Modal -->
<div id="weightModal" class="modal-overlay" onclick="if(event.target===this)this.classList.remove('show')">
    <div class="modal-box">
        <h3>⚖️ تسجيل وزن جديد</h3>
        <div class="form-row">
            <div class="form-group"><label>التاريخ</label><input type="date" id="weightDate" class="form-input"></div>
            <div class="form-group"><label>الوزن (كجم)</label><input type="number" id="weightKg" class="form-input" step="0.1" min="10" max="200"></div>
        </div>
        <div class="form-group"><label>ملاحظات</label><textarea id="weightNotes" class="form-input" rows="2"></textarea></div>
        <div class="form-row" style="margin-top:10px">
            <button class="btn-cancel" onclick="document.getElementById('weightModal').classList.remove('show')">إلغاء</button>
            <button class="btn-submit" onclick="submitWeight()">حفظ الوزن ✔</button>
        </div>
    </div>
</div>

<!-- Tournament Modal -->
<div id="tournamentModal" class="modal-overlay" onclick="if(event.target===this)this.classList.remove('show')">
    <div class="modal-box">
        <h3>🏆 إضافة بطولة</h3>
        <div class="form-group"><label>اسم البطولة</label><input type="text" id="tournamentName" class="form-input"></div>
        <div class="form-row">
            <div class="form-group"><label>التاريخ</label><input type="date" id="tournamentDate" class="form-input"></div>
            <div class="form-group"><label>المكان</label><input type="text" id="tournamentLocation" class="form-input"></div>
        </div>
        <div class="form-row">
            <div class="form-group"><label>الميدالية</label>
                <select id="tournamentMedal" class="form-input"><option value="gold">🥇 ذهبية</option><option value="silver">🥈 فضية</option><option value="bronze">🥉 برونزية</option><option value="participant">🎗️ مشاركة</option></select>
            </div>
            <div class="form-group"><label>فئة الوزن</label><input type="text" id="tournamentWeightClass" class="form-input" placeholder="مثل: 60 كجم"></div>
        </div>
        <div class="form-group"><label>ملاحظات</label><textarea id="tournamentNotes" class="form-input" rows="2"></textarea></div>
        <div class="form-row" style="margin-top:10px">
            <button class="btn-cancel" onclick="document.getElementById('tournamentModal').classList.remove('show')">إلغاء</button>
            <button class="btn-submit" onclick="submitTournament()">حفظ البطولة ✔</button>
        </div>
    </div>
</div>
@if($player->evaluations->count() > 0)
<script>
    @php $latest = $player->evaluations->first(); @endphp
    Chart.defaults.color = '#94a3b8';
    Chart.defaults.font.family = "'Cairo', sans-serif";
    new Chart(document.getElementById('skillsChart').getContext('2d'), {
        type: 'radar',
        data: {
            labels: ['الأساسيات الفنية', 'السرعة', 'الدفاع', 'اللياقة', 'الروح القتالية'],
            datasets: [{
                label: 'مستوى اللاعب الحالي',
                data: [{{ $latest->tech_score }},{{ $latest->speed_score }},{{ $latest->defense_score }},{{ $latest->fitness_score }},{{ $latest->discipline_score }}],
                backgroundColor: 'rgba(241, 196, 15, 0.2)', borderColor: '#f1c40f',
                pointBackgroundColor: '#f1c40f', pointBorderColor: '#fff', borderWidth: 2
            }]
        },
        options: {
            responsive: true, maintainAspectRatio: false,
            scales: { r: { angleLines: { color: 'rgba(255,255,255,0.1)' }, grid: { color: 'rgba(255,255,255,0.1)' }, pointLabels: { color: '#f8fafc', font: { size: 13, family: "'Cairo', sans-serif" } }, ticks: { min: 0, max: 5, stepSize: 1, display: false } } },
            plugins: { legend: { display: false } }
        }
    });
</script>
@endif

@if($player->weights->count() > 0)
<script>
    @php $wData = $player->weights->reverse(); @endphp
    new Chart(document.getElementById('weightChart').getContext('2d'), {
        type: 'line',
        data: {
            labels: [{!! $wData->map(fn($w) => "'" . \Carbon\Carbon::parse($w->recorded_date)->format('m/d') . "'")->implode(',') !!}],
            datasets: [{
                label: 'الوزن (كجم)',
                data: [{{ $wData->pluck('weight_kg')->implode(',') }}],
                borderColor: '#e74c3c', backgroundColor: 'rgba(231,76,60,0.1)',
                tension: 0.4, fill: true, pointRadius: 6, pointBackgroundColor: '#e74c3c'
            }]
        },
        options: {
            responsive: true,
            scales: { y: { grid: { color: 'rgba(255,255,255,0.05)' } }, x: { grid: { color: 'rgba(255,255,255,0.05)' } } },
            plugins: { legend: { display: false } }
        }
    });
</script>
@endif

<script>
    const playerId = {{ $player->id }};
    const csrfToken = '{{ csrf_token() }}';

    async function submitForm(url, data, modalId) {
        try {
            const res = await fetch(url, {
                method: 'POST', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
                body: JSON.stringify(data)
            });
            const json = await res.json();
            if (json.success) { document.getElementById(modalId).classList.remove('show'); location.reload(); }
            else { alert('خطأ: ' + (json.message || 'حدث خطأ')); }
        } catch (e) { alert('خطأ في الاتصال بالسيرفر'); }
    }

    function submitFight() {
        submitForm(`/players/${playerId}/fights`, {
            fight_date: document.getElementById('fightDate').value,
            opponent_name: document.getElementById('fightOpponent').value,
            opponent_club: document.getElementById('fightOpponentClub').value,
            result: document.getElementById('fightResult').value,
            result_method: document.getElementById('fightMethod').value,
            weight_class: document.getElementById('fightWeightClass').value,
            notes: document.getElementById('fightNotes').value
        }, 'fightModal');
    }

    function submitWeight() {
        submitForm(`/players/${playerId}/weights`, {
            recorded_date: document.getElementById('weightDate').value,
            weight_kg: document.getElementById('weightKg').value,
            notes: document.getElementById('weightNotes').value
        }, 'weightModal');
    }

    function submitTournament() {
        submitForm(`/players/${playerId}/tournaments`, {
            tournament_name: document.getElementById('tournamentName').value,
            tournament_date: document.getElementById('tournamentDate').value,
            location: document.getElementById('tournamentLocation').value,
            medal: document.getElementById('tournamentMedal').value,
            weight_class: document.getElementById('tournamentWeightClass').value,
            notes: document.getElementById('tournamentNotes').value
        }, 'tournamentModal');
    }

    // Set default dates to today
    document.querySelectorAll('input[type="date"]').forEach(el => el.value = new Date().toISOString().split('T')[0]);
</script>

</body>
</html>

