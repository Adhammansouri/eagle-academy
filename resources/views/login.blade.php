<!doctype html>
<html lang="ar" dir="rtl">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>تسجيل الدخول | The Eagle Academy</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
  </head>
  <body class="login-body">
    <div class="login-container">
      <div class="logo-wrapper">
        <img
          src="{{ asset('logo.jpg') }}"
          alt="The Eagle Academy Logo"
          class="logo"
          onerror="this.src = 'https://via.placeholder.com/140?text=Eagle+Logo'"
        />
      </div>

      <h2 class="login-title">تسجيل دخول الموظفين</h2>
      <p class="login-subtitle">استخدم <strong>اسم المستخدم</strong> — وليس رقم تليفون اللاعب</p>

      @if ($errors->any())
        <div class="login-error" role="alert">
          @foreach ($errors->all() as $error)
            <p>{{ $error }}</p>
          @endforeach
        </div>
      @endif

      <form action="{{ route('login') }}" method="POST">
        @csrf
        <div class="form-group">
          <label for="username">اسم المستخدم</label>
          <input
            type="text"
            id="username"
            name="username"
            value="{{ old('username') }}"
            placeholder="مثال: admin"
            required
            autofocus
          />
        </div>

        <div class="form-group">
          <label for="password">كلمة المرور</label>
          <input
            type="password"
            id="password"
            name="password"
            placeholder="أدخل كلمة المرور"
            required
          />
        </div>

        <div class="form-group">
          <label class="login-remember">
            <input type="checkbox" name="remember" value="1" {{ old('remember') ? 'checked' : '' }} />
            تذكرني
          </label>
        </div>

        <button type="submit" class="btn-primary">دخول إلى النظام</button>
      </form>

      <details class="login-credentials-hint">
        <summary>حسابات الدخول الافتراضية</summary>
        <ul>
          <li><strong>الحساب الافتراضي:</strong> admin / admin123</li>
        </ul>
      </details>
    </div>
  </body>
</html>
