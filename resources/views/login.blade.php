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
        <!-- Instructions: place the logo.jpg image in the same directory -->
        <img
          src="{{ asset('logo.jpg') }}"
          alt="The Eagle Academy Logo"
          class="logo"
          onerror="this.src = 'https://via.placeholder.com/140?text=Eagle+Logo'"
        />
      </div>

      <h2 class="login-title">تسجيل دخول الكابتن</h2>

      <form action="{{ route('dashboard') }}" method="GET">
        <div class="form-group">
          <label for="username">اسم المستخدم</label>
          <input
            type="text"
            id="username"
            placeholder="أدخل اسم الكابتن"
            required
          />
        </div>

        <div class="form-group">
          <label for="password">كلمة المرور</label>
          <input
            type="password"
            id="password"
            placeholder="أدخل كلمة المرور"
            required
          />
        </div>

        <button type="submit" class="btn-primary">دخول إلى النظام 🦅</button>
      </form>
    </div>
  </body>
</html>
