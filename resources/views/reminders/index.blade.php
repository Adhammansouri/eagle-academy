@extends('layouts.admin')

@section('title', 'تنبيهات الاشتراكات')

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
                                <td class="reminders-actions">
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
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </main>
@endsection
