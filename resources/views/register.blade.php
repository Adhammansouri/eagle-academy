@extends('layouts.admin')

@section('title', 'تسجيل لاعب جديد')
@section('pageTitle', 'تسجيل لاعب')

@push('styles')
    <style>
        .register-container {
            max-width: 800px;
            margin: 0 auto;
        }
    </style>
@endpush

@section('content')
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

                        <div class="form-group full-width" style="margin-bottom: 10px;">
                            <label for="playerName">👤 اسم اللاعب</label>
                            <input type="text" id="playerName" placeholder="اكتب الاسم ثلاثي أو رباعي..." required style="font-size: 16px; padding: 15px;">
                        </div>

                        <div class="form-group">
                            <label for="birthDate">📅 سنة المواليد</label>
                            <input type="number" id="birthDate" placeholder="مثال: 2010" required>
                        </div>

                        <div class="form-group">
                            <label for="phoneNumber">📱 رقم هاتف ولي الأمر</label>
                            <input type="text" id="phoneNumber" placeholder="مثال: 01012345678">
                        </div>

                        <div class="form-group">
                            <label for="source">🏢 الجهة القادم منها</label>
                            <select id="source" required>
                                <option value="" disabled selected>-- اختيار جهة الاشتراك --</option>
                                <option value="الاكاديميه">الأكاديمية المباشرة</option>
                                <option value="فورس جيم">فورس جيم</option>
                            </select>
                        </div>

                        <div class="form-group" id="categoryGroup" style="display: none;">
                            <label for="category">👦 الفئة العمرية</label>
                            <select id="category">
                                <option value="" disabled selected>-- اختيار الفئة --</option>
                                <option value="براعم">براعم</option>
                                <option value="شباب">شباب</option>
                            </select>
                        </div>

                        <div class="full-width" style="height: 1px; background: rgba(255,255,255,0.1); margin: 20px 0;"></div>

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

                    </div>

                    <button type="submit" id="submitBtn" class="btn-primary" style="margin-top: 30px; padding: 18px; font-size: 18px; display: flex; align-items: center; justify-content: center; gap: 10px;">
                        تأكيد وحفظ بيانات اللاعب ✔
                    </button>

                </form>
            </div>
        </div>
    </main>
@endsection

@push('scripts')
    <script src="{{ asset('js/app.js') }}"></script>
@endpush
