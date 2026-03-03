<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل لاعب جديد | The Eagle Academy</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        .register-container {
            max-width: 800px;
            margin: 0 auto;
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
            <a href="{{ route('players.list') }}" class="btn-top-nav secondary">📋 سجل اللاعبين</a>
            <a href="{{ route('dashboard') }}" class="btn-top-nav secondary">🔙 لوحة التحكم</a>
            <a href="{{ route('reports.index') }}" class="btn-top-nav" style="background: rgba(241, 196, 15, 0.15); color: #f1c40f; border-color: rgba(241, 196, 15, 0.3);">📊 التقارير</a>
            <div class="user-profile">
                مرحباً بك، <span>الكابتن 🦅</span>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="dashboard-wrapper">
        <div class="welcome-hero" style="margin-bottom: 30px;">
            <div class="hero-content">
                <h2>إضافة لاعب جديد 🦅</h2>
                <p>قم بتسجيل بيانات اللاعب بدقة لإضافته فوراً إلى قاعدة بيانات الأكاديمية.</p>
            </div>
        </div>

        <div class="register-container">
            <div class="form-section glass-card" style="padding: 40px;">
                <h2 style="margin-bottom: 30px; font-size: 22px; color: var(--text-primary); border-right: 4px solid var(--primary-red); padding-right: 15px;">
                    📝 بيانات الاشتراك
                </h2>
                
                <form id="subscriptionForm">
                    <div class="form-grid">
                        
                        <!-- Personal Info -->
                        <div class="form-group full-width" style="margin-bottom: 10px;">
                            <label for="playerName">👤 اسم اللاعب</label>
                            <input type="text" id="playerName" placeholder="اكتب الاسم ثلاثي أو رباعي..." required style="font-size: 16px; padding: 15px;">
                        </div>

                        <div class="form-group">
                            <label for="birthDate">📅 سنة المواليد</label>
                            <input type="number" id="birthDate" placeholder="مثال: 2010" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="source">🏢 الجهة القادم منها</label>
                            <select id="source" required>
                                <option value="" disabled selected>-- اختيار جهة الاشتراك --</option>
                                <option value="الاكاديميه">الأكاديمية المباشرة</option>
                                <option value="فورس جيم">فورس جيم</option>
                            </select>
                        </div>

                        <!-- Category Group (Dynamically Visible) -->
                        <div class="form-group" id="categoryGroup" style="display: none;">
                            <label for="category">👦 الفئة العمرية</label>
                            <select id="category">
                                <option value="" disabled selected>-- اختيار الفئة --</option>
                                <option value="براعم">براعم</option>
                                <option value="شباب">شباب</option>
                            </select>
                        </div>

                        <!-- Divider -->
                        <div class="full-width" style="height: 1px; background: rgba(255,255,255,0.1); margin: 20px 0;"></div>

                        <!-- Subscription Details -->

                        <div class="form-group">
                            <label for="amount">💰 القيمة المدفوعة (ج.م)</label>
                            <input type="number" id="amount" placeholder="المبلغ..." required>
                        </div>

                        <div class="form-group">
                            <label for="subDate">🟢 بداية التفعيل</label>
                            <input type="date" id="subDate" required>
                        </div>

                        <div class="form-group">
                            <label for="expDate">🔴 تاريخ الانتهاء</label>
                            <input type="date" id="expDate" required>
                        </div>

                    </div> <!-- End Form Grid -->
                    
                    <button type="submit" id="submitBtn" class="btn-primary" style="margin-top: 30px; padding: 18px; font-size: 18px; display: flex; align-items: center; justify-content: center; gap: 10px;">
                        تأكيد وحفظ بيانات اللاعب ✔
                    </button>
                    
                    <div id="loadingIndicator" style="display: none; text-align: center; margin-top: 15px; color: var(--primary-red); font-weight: bold;">
                        جاري الحفظ... ⏳
                    </div>
                </form>
            </div>
        </div>
    </main>

    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        // Adding simple visual feedback to the form submission
        document.getElementById('subscriptionForm').addEventListener('submit', function() {
            document.getElementById('submitBtn').style.opacity = '0.5';
            document.getElementById('loadingIndicator').style.display = 'block';
        });
    </script>
</body>
</html>
