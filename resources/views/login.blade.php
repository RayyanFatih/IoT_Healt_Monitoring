<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login — Rythmiq</title>
<meta name="description" content="Masuk ke akun Rythmiq IoT Health Monitoring Anda.">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="/css/auth.css">
<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- 🖼️ GANTI FAVICON: Letakkan favicon.ico di folder public/ lalu ubah href di bawah -->
<link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%236366f1' stroke-width='2.5'><polyline points='22 12 18 12 15 21 9 3 6 12 2 12'/></svg>">
</head>
<body>

<div class="auth-card">

  <!-- Logo -->
  <div class="auth-logo">
    <div class="auth-logo-icon">
      <!-- 🖼️ GANTI LOGO ICON: Hapus <svg> ini, ganti dengan <img src="/images/logo-icon.png" alt="Logo" width="20" height="20"> -->
      <svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
        <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>
      </svg>
    </div>
    <!-- 🖼️ GANTI NAMA BRAND: Bisa diganti dengan <img src="/images/logo-text.png" alt="Rythmiq" height="22"> -->
    <span class="auth-logo-text">Rythmiq</span>
  </div>

  <div class="auth-heading">
    <h1 class="auth-title">Selamat Datang</h1>
    <p class="auth-subtitle">Masuk untuk memantau data kesehatanmu</p>
  </div>

  <!-- Error dari server -->
  @if(session('error'))
    <div class="form-error show" style="margin-bottom:14px;font-size:13px;">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
      <span>{{ session('error') }}</span>
    </div>
  @endif

  @if(session('success'))
    <div style="display:flex;align-items:flex-start;gap:10px;background:#f0fdf4;border:1.5px solid #86efac;border-radius:12px;padding:13px 15px;margin-bottom:16px;">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#16a34a" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink:0;margin-top:1px"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 15 9 12"/></svg>
      <span style="font-size:13px;color:#15803d;font-weight:600;">{{ session('success') }}</span>
    </div>
  @endif

  <!-- Form POST langsung ke server (tidak pakai fetch/async) -->
  <form class="auth-form" id="loginForm" method="POST" action="/login" novalidate>
    @csrf

    <!-- Email -->
    <div class="form-group">
      <label class="form-label" for="login-email">Email</label>
      <div class="input-wrap">
        <div class="input-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
        </div>
        <input type="email" id="login-email" name="email" class="form-input @error('email') error @enderror"
               placeholder="nama@email.com" value="{{ old('email') }}" autocomplete="email" required>
      </div>
      @error('email')
        <div class="form-error show">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
          <span>{{ $message }}</span>
        </div>
      @enderror
    </div>

    <!-- Password -->
    <div class="form-group">
      <label class="form-label" for="login-password">Password</label>
      <div class="input-wrap">
        <div class="input-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
        </div>
        <input type="password" id="login-password" name="password" class="form-input"
               placeholder="••••••••" autocomplete="current-password" required>
        <button type="button" class="pw-toggle" id="togglePw"
                onclick="togglePassword('login-password','togglePw')" title="Tampilkan password">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
        </button>
      </div>
      <div style="text-align:right;margin-top:5px;">
        <a href="/forgot-password" style="font-size:12px;color:var(--brand);font-weight:600;text-decoration:none;transition:color 0.15s;"
           onmouseover="this.style.color='var(--brand-dark)'" onmouseout="this.style.color='var(--brand)'">Lupa Password</a>
      </div>
    </div>

    <!-- Submit -->
    <button type="submit" class="auth-btn" id="loginBtn">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
        <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/>
        <polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/>
      </svg>
      Masuk
    </button>

  </form>

  <div class="auth-divider"><span>atau</span></div>
  <div class="auth-footer">
    Belum punya akun? <a href="/register">Daftar sekarang</a>
  </div>

</div>

<script>
function togglePassword(inputId, btnId) {
  const input = document.getElementById(inputId);
  const btn   = document.getElementById(btnId);
  const isHidden = input.type === 'password';
  input.type = isHidden ? 'text' : 'password';
  btn.innerHTML = isHidden
    ? `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/><path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/><line x1="1" y1="1" x2="23" y2="23"/></svg>`
    : `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>`;
}
</script>
</body>
</html>
