<!doctype html>
<html lang="ar" dir="rtl">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>استعلام الاشتراك | The Eagle Academy</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
    <style>
      .portal-container {
        max-width: 550px;
        margin: 50px auto;
        padding: 40px;
        background: rgba(30, 34, 39, 0.8);
        backdrop-filter: blur(15px);
        -webkit-backdrop-filter: blur(15px);
        border: 1px solid rgba(255, 255, 255, 0.05);
        border-radius: 20px;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.4);
        text-align: center;
        animation: fadeIn 0.6s ease-out;
      }
      
      @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
      }

      .portal-title {
        color: #ffffff;
        margin-bottom: 10px;
        font-size: 2rem;
        font-weight: 800;
        letter-spacing: -0.5px;
      }
      
      .portal-subtitle {
        color: #9ea4a8;
        font-size: 1.1rem;
        margin-bottom: 30px;
        line-height: 1.6;
      }

      .result-card {
        margin-top: 30px;
        padding: 30px;
        border-radius: 16px;
        text-align: right;
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
      }

      .result-card.active {
        background: linear-gradient(145deg, rgba(46, 204, 113, 0.1) 0%, rgba(30, 34, 39, 0.9) 100%);
        border: 1px solid rgba(46, 204, 113, 0.3);
        box-shadow: 0 10px 30px rgba(46, 204, 113, 0.1);
      }
      
      .result-card.expired {
        background: linear-gradient(145deg, rgba(231, 76, 60, 0.1) 0%, rgba(30, 34, 39, 0.9) 100%);
        border: 1px solid rgba(231, 76, 60, 0.3);
        box-shadow: 0 10px 30px rgba(231, 76, 60, 0.1);
      }

      .result-card::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 6px;
        height: 100%;
      }
      
      .result-card.active::before { background: #2ecc71; }
      .result-card.expired::before { background: #e74c3c; }

      .player-header {
        display: flex;
        align-items: center;
        margin-bottom: 25px;
        padding-bottom: 15px;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05);
      }

      .player-avatar {
        width: 50px;
        height: 50px;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        font-weight: bold;
        color: #ffffff;
        margin-left: 15px;
        border: 1px solid rgba(255, 255, 255, 0.1);
      }

      .player-name-wrapper {
        flex: 1;
      }

      .player-name {
        font-size: 1.4rem;
        font-weight: 800;
        color: #ffffff;
        margin: 0;
      }
      
      .player-category {
        font-size: 0.9rem;
        color: #9ea4a8;
      }

      .details-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-bottom: 25px;
      }

      .detail-item {
        background: rgba(0, 0, 0, 0.2);
        padding: 15px;
        border-radius: 12px;
      }

      .detail-label {
        font-size: 0.85rem;
        color: #9ea4a8;
        margin-bottom: 5px;
        display: block;
      }

      .detail-value {
        font-size: 1.1rem;
        font-weight: 700;
        color: #ffffff;
        display: block;
      }

      .status-badge-container {
        text-align: center;
        padding-top: 15px;
        border-top: 1px solid rgba(255, 255, 255, 0.05);
      }

      .status-badge {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 25px;
        border-radius: 30px;
        font-size: 1.1rem;
        font-weight: 800;
        letter-spacing: 0.5px;
      }

      .badge-active { 
        background: rgba(46, 204, 113, 0.15); 
        color: #2ecc71; 
        border: 1px solid rgba(46, 204, 113, 0.3);
      }
      
      .badge-expired { 
        background: rgba(231, 76, 60, 0.15); 
        color: #e74c3c; 
        border: 1px solid rgba(231, 76, 60, 0.3);
      }

      .error-msg {
        color: #ff5252;
        background: rgba(211, 47, 47, 0.1);
        border: 1px solid rgba(211, 47, 47, 0.3);
        padding: 15px;
        border-radius: 10px;
        margin-bottom: 25px;
        font-weight: 600;
      }

      .back-link {
        display: inline-block;
        margin-top: 25px;
        color: #9ea4a8;
        text-decoration: none;
        font-weight: 600;
        transition: color 0.3s;
      }

      .back-link:hover {
        color: #ffffff;
      }
      
      /* Evaluation Styles */
      .evaluation-section {
        margin-top: 25px;
        padding-top: 25px;
        border-top: 1px dashed rgba(255, 255, 255, 0.1);
        text-align: right;
      }

      .eval-title {
        font-size: 1.2rem;
        color: #f1c40f;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 8px;
        font-weight: bold;
      }

      .progress-container {
        margin-bottom: 15px;
      }

      .coach-notes {
        background: rgba(241, 196, 15, 0.05);
        border-right: 4px solid #f1c40f;
        padding: 15px;
        border-radius: 8px 0 0 8px;
        margin-top: 20px;
        color: #d1d8e0;
        font-size: 0.95rem;
        line-height: 1.6;
        font-style: italic;
      }

      /* Responsive */
      @media (max-width: 600px) {
        .portal-container { margin: 20px; padding: 25px 20px; }
        .details-grid { grid-template-columns: 1fr; gap: 15px; }
      }
    </style>
  </head>
  <body class="login-body" style="min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 20px;">
    
    <div class="portal-container" style="width: 100%;">
      <div class="logo-wrapper" style="margin-bottom: 25px;">
        <img
          src="{{ asset('logo.jpg') }}"
          alt="The Eagle Academy Logo"
          class="logo"
          onerror="this.src = 'https://via.placeholder.com/120?text=Eagle'"
          style="width: 120px; height: 120px; border-radius: 50%; box-shadow: 0 5px 15px rgba(0,0,0,0.3); border: 3px solid rgba(255,255,255,0.1);"
        />
      </div>

      <h2 class="portal-title">استعلام الاشتراك</h2>
      <p class="portal-subtitle">
        أدخل كود اللاعب الفريد أو رقم الهاتف المسجل لمعرفة تفاصيل الاشتراك بدقة.
      </p>

      @if(session('error'))
        <div class="error-msg">
            ⚠️ {{ session('error') }}
        </div>
      @endif

      <form action="{{ route('portal.check') }}" method="POST">
        @csrf
        <div class="form-group" style="text-align: right; margin-bottom: 25px;">
          <input
            type="text"
            name="search_term"
            id="search_term"
            placeholder="مثال: EA-1005 أو رقم الهاتف..."
            required
            value="{{ old('search_term') }}"
            style="padding: 16px; font-size: 1.1rem; text-align: center; letter-spacing: 1px;"
          />
        </div>

        <button type="submit" class="btn-primary" style="width: 100%; padding: 16px; font-size: 1.2rem; font-weight: bold; display: flex; align-items: center; justify-content: center; gap: 10px;">
          <span>استعلام عن الحالة</span>
          <span>🔍</span>
        </button>
      </form>

      @if(isset($player))
        @php
            $expirationDate = \Carbon\Carbon::parse($player->expiration_date)->startOfDay();
            $today = \Carbon\Carbon::now()->startOfDay();
            $daysRemaining = $today->diffInDays($expirationDate, false);
            $isExpired = $daysRemaining < 0;
            
            $statusClass = $isExpired ? 'expired' : 'active';
            $badgeClass = $isExpired ? 'badge-expired' : 'badge-active';
            $statusText = $isExpired ? 'اشتراك منتهي' : 'اشتراك ساري';
            $icon = $isExpired ? '❌' : '✅';
        @endphp
        
        <div class="result-card {{ $statusClass }}">
            
            <div class="player-header">
                <div class="player-avatar">
                    {{ mb_substr($player->name, 0, 1) }}
                </div>
                <div class="player-name-wrapper">
                    <h3 class="player-name">{{ $player->name }}</h3>
                    <span class="player-category">الفئة المحددة: {{ $player->category ?? 'غير محدد' }}</span>
                </div>
            </div>

            <div class="details-grid">
                <div class="detail-item">
                    <span class="detail-label">بداية الاشتراك</span>
                    <span class="detail-value">{{ $player->subscription_date }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">تاريخ الانتهاء</span>
                    <span class="detail-value" style="color: {{ $isExpired ? '#ff5252' : '#ffffff' }}">{{ $player->expiration_date }}</span>
                </div>
            </div>

            <div class="status-badge-container">
                <div class="status-badge {{ $badgeClass }}">
                    <span>{{ $icon }}</span>
                    <span>{{ $statusText }}</span>
                    @if(!$isExpired)
                        <span style="font-size: 0.9rem; margin-right: 5px; opacity: 0.8;">(متبقي {{ $daysRemaining }} يوم)</span>
                    @endif
                </div>
            </div>

            @php
                function getStarScore($score) {
                    if (is_null($score)) return 0;
                    return $score > 5 ? ceil($score / 2) : $score;
                }
                
                $hasEvaluation = !is_null($player->tech_score) || !is_null($player->speed_score) || !is_null($player->defense_score) || !is_null($player->fitness_score) || !is_null($player->discipline_score);
            @endphp

            @if($hasEvaluation)
                <div class="evaluation-section">
                    <h4 class="eval-title">🥊 تقرير الأداء الفني والبدني للملاكم</h4>
                    @if($player->evaluation_date)
                        <div style="font-size: 0.85rem; color: #b2bec3; margin-top: -15px; margin-bottom: 20px;">
                            تم التقييم بتاريخ: {{ \Carbon\Carbon::parse($player->evaluation_date)->format('Y-m-d') }}
                        </div>
                    @endif
                    
                    @if(!is_null($player->tech_score))
                        <div class="progress-container" style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid rgba(255,255,255,0.05); padding-bottom: 10px;">
                            <span style="color: #ffffff; font-weight: 600; font-size: 0.95rem;">الأساسيات الفنية</span>
                            <div dir="ltr">
                                @php $s = getStarScore($player->tech_score); @endphp
                                @for($i = 1; $i <= 5; $i++)
                                    <span style="font-size: 22px; color: {{ $i <= $s ? '#f1c40f' : 'rgba(255,255,255,0.1)' }};">★</span>
                                @endfor
                            </div>
                        </div>
                    @endif

                    @if(!is_null($player->speed_score))
                        <div class="progress-container" style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid rgba(255,255,255,0.05); padding-bottom: 10px;">
                            <span style="color: #ffffff; font-weight: 600; font-size: 0.95rem;">السرعة ورد الفعل</span>
                            <div dir="ltr">
                                @php $s = getStarScore($player->speed_score); @endphp
                                @for($i = 1; $i <= 5; $i++)
                                    <span style="font-size: 22px; color: {{ $i <= $s ? '#f1c40f' : 'rgba(255,255,255,0.1)' }};">★</span>
                                @endfor
                            </div>
                        </div>
                    @endif
                    
                    @if(!is_null($player->defense_score))
                        <div class="progress-container" style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid rgba(255,255,255,0.05); padding-bottom: 10px;">
                            <span style="color: #ffffff; font-weight: 600; font-size: 0.95rem;">الدفاع والمراوغة</span>
                            <div dir="ltr">
                                @php $s = getStarScore($player->defense_score); @endphp
                                @for($i = 1; $i <= 5; $i++)
                                    <span style="font-size: 22px; color: {{ $i <= $s ? '#f1c40f' : 'rgba(255,255,255,0.1)' }};">★</span>
                                @endfor
                            </div>
                        </div>
                    @endif

                    @if(!is_null($player->fitness_score))
                        <div class="progress-container" style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid rgba(255,255,255,0.05); padding-bottom: 10px;">
                            <span style="color: #ffffff; font-weight: 600; font-size: 0.95rem;">اللياقة وقوة التحمل</span>
                            <div dir="ltr">
                                @php $s = getStarScore($player->fitness_score); @endphp
                                @for($i = 1; $i <= 5; $i++)
                                    <span style="font-size: 22px; color: {{ $i <= $s ? '#f1c40f' : 'rgba(255,255,255,0.1)' }};">★</span>
                                @endfor
                            </div>
                        </div>
                    @endif

                    @if(!is_null($player->discipline_score))
                        <div class="progress-container" style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid rgba(255,255,255,0.05); padding-bottom: 10px;">
                            <span style="color: #ffffff; font-weight: 600; font-size: 0.95rem;">الروح القتالية والانضباط</span>
                            <div dir="ltr">
                                @php $s = getStarScore($player->discipline_score); @endphp
                                @for($i = 1; $i <= 5; $i++)
                                    <span style="font-size: 22px; color: {{ $i <= $s ? '#f1c40f' : 'rgba(255,255,255,0.1)' }};">★</span>
                                @endfor
                            </div>
                        </div>
                    @endif

                    @if(!empty($player->coach_notes))
                        <div class="coach-notes">
                            <strong>💬 رسالة من الكابتن:</strong><br>
                            {{ $player->coach_notes }}
                        </div>
                    @endif
                </div>
            @endif

            @if($player->evaluations && $player->evaluations->count() > 1)
                <div class="evaluation-section" style="margin-top: 20px;">
                    <h4 class="eval-title" style="color: #b2bec3; font-size: 1rem;">📅 التقييمات السابقة (سجل التطور)</h4>
                    <div style="border-right: 2px solid rgba(255,255,255,0.1); padding-right: 15px; margin-right: 10px;">
                        @foreach($player->evaluations->skip(1) as $eval)
                            <div style="margin-bottom: 15px; position: relative;">
                                <div style="position: absolute; right: -21px; top: 5px; width: 10px; height: 10px; border-radius: 50%; background: rgba(255,255,255,0.3);"></div>
                                <div style="color: #f1c40f; font-size: 0.85rem; margin-bottom: 5px;">{{ \Carbon\Carbon::parse($eval->evaluation_date)->format('Y-m-d') }}</div>
                                <div style="background: rgba(0,0,0,0.2); padding: 10px; border-radius: 8px; display: flex; flex-wrap: wrap; gap: 10px; font-size: 0.8rem; color: #dfe6e9;">
                                    <span>فنيات: {{ $eval->tech_score }}★</span>
                                    <span>سرعة: {{ $eval->speed_score }}★</span>
                                    <span>دفاع: {{ $eval->defense_score }}★</span>
                                    <span>لياقة: {{ $eval->fitness_score }}★</span>
                                    <span>انضباط: {{ $eval->discipline_score }}★</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Fight Record for Parents --}}
            @if($player->fights && $player->fights->count() > 0)
                @php
                    $wins = $player->fights->where('result', 'win')->count();
                    $losses = $player->fights->where('result', 'loss')->count();
                    $draws = $player->fights->where('result', 'draw')->count();
                @endphp
                <div style="margin-top: 20px;">
                    <h4 style="color: #f1c40f; font-size: 1rem; margin-bottom: 15px;">🥊 سجل النزالات</h4>
                    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px; margin-bottom: 15px;">
                        <div style="background: rgba(46,204,113,0.1); padding: 15px; border-radius: 10px; text-align: center;">
                            <div style="font-size: 1.8rem; font-weight: 800; color: #2ecc71;">{{ $wins }}</div>
                            <div style="color: #94a3b8; font-size: 0.8rem;">انتصارات</div>
                        </div>
                        <div style="background: rgba(231,76,60,0.1); padding: 15px; border-radius: 10px; text-align: center;">
                            <div style="font-size: 1.8rem; font-weight: 800; color: #e74c3c;">{{ $losses }}</div>
                            <div style="color: #94a3b8; font-size: 0.8rem;">خسائر</div>
                        </div>
                        <div style="background: rgba(243,156,18,0.1); padding: 15px; border-radius: 10px; text-align: center;">
                            <div style="font-size: 1.8rem; font-weight: 800; color: #f39c12;">{{ $draws }}</div>
                            <div style="color: #94a3b8; font-size: 0.8rem;">تعادلات</div>
                        </div>
                    </div>
                    @foreach($player->fights->take(5) as $fight)
                        <div style="display: flex; justify-content: space-between; align-items: center; padding: 8px 12px; background: rgba(0,0,0,0.15); border-radius: 8px; margin-bottom: 6px; font-size: 0.85rem;">
                            <span style="padding: 3px 8px; border-radius: 5px; font-weight: 700; font-size: 0.75rem;
                                background: {{ $fight->result == 'win' ? 'rgba(46,204,113,0.2)' : ($fight->result == 'loss' ? 'rgba(231,76,60,0.2)' : 'rgba(243,156,18,0.2)') }};
                                color: {{ $fight->result == 'win' ? '#2ecc71' : ($fight->result == 'loss' ? '#e74c3c' : '#f39c12') }};">
                                {{ $fight->result == 'win' ? 'فوز' : ($fight->result == 'loss' ? 'خسارة' : 'تعادل') }}
                            </span>
                            <span>vs {{ $fight->opponent_name }}</span>
                            <span style="color: #94a3b8;">{{ \Carbon\Carbon::parse($fight->fight_date)->format('Y-m-d') }}</span>
                        </div>
                    @endforeach
                </div>
            @endif

            {{-- Tournaments for Parents --}}
            @if($player->tournaments && $player->tournaments->count() > 0)
                <div style="margin-top: 20px;">
                    <h4 style="color: #f1c40f; font-size: 1rem; margin-bottom: 15px;">🏆 البطولات والميداليات</h4>
                    @foreach($player->tournaments as $t)
                        <div style="display: flex; align-items: center; gap: 10px; padding: 10px; background: rgba(0,0,0,0.15); border-radius: 8px; margin-bottom: 6px;">
                            <span style="font-size: 1.3rem;">@if($t->medal == 'gold')🥇@elseif($t->medal == 'silver')🥈@elseif($t->medal == 'bronze')🥉@else🎗️@endif</span>
                            <div style="flex: 1;">
                                <strong>{{ $t->tournament_name }}</strong>
                                @if($t->location)<span style="color: #94a3b8; font-size: 0.8rem;"> - {{ $t->location }}</span>@endif
                            </div>
                            <span style="color: #94a3b8; font-size: 0.8rem;">{{ \Carbon\Carbon::parse($t->tournament_date)->format('Y-m-d') }}</span>
                        </div>
                    @endforeach
                </div>
            @endif

        </div>
      @endif
      
    </div>
    
  </body>
</html>
