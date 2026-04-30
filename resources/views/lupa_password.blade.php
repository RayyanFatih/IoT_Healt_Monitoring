<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Lupa Password — Rythmiq</title>
<meta name="description" content="Masukkan email Anda untuk menerima link reset password.">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="/css/auth.css">
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%236366f1' stroke-width='2.5'><polyline points='22 12 18 12 15 21 9 3 6 12 2 12'/></svg>">
<link rel="stylesheet" href="/css/lupa_password.css">
</head>
<body>

<div class="auth-card">

  <!-- Logo -->
  <div class="auth-logo">
    <div class="auth-logo-icon">
      <svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
        <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>
      </svg>
    </div>
    <span class="auth-logo-text">Rythmiq</span>
  </div>

  @if(session('reset_sent'))
    {{-- ─── STATE: Email Berhasil Dikirim ─── --}}
    <div class="sent-container">
      <div class="sent-icon">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
          <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
          <polyline points="22,6 12,13 2,6"/>
        </svg>
      </div>
      <h1 class="sent-title">Cek Email Anda!</h1>
      <p class="sent-sub">
        Jika email yang Anda masukkan terdaftar, kami telah mengirimkan
        <span class="sent-email">link reset password</span> ke alamat tersebut.
      </p>
      <a href="/login" class="auth-btn" style="text-decoration:none;">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
          <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/>
          <polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/>
        </svg>
        Kembali ke Login
      </a>
    </div>

  @else
    {{-- ─── STATE: Form Input Email ─── --}}
    <div class="auth-heading">
      <h1 class="auth-title">Lupa Password?</h1>
      <p class="auth-subtitle">Masukkan email Anda dan kami akan mengirim link untuk reset password</p>
    </div>

    {{-- Error dari validasi / token invalid --}}
    @if(session('error'))
      <div class="alert-error">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
          <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
        </svg>
        {{ session('error') }}
      </div>
    @endif

    <form class="auth-form" id="forgotForm" method="POST" action="/forgot-password" novalidate>
      @csrf

      <div class="form-group">
        <label class="form-label" for="forgot-email">Email Terdaftar</label>
        <div class="input-wrap">
          <div class="input-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
              <polyline points="22,6 12,13 2,6"/>
            </svg>
          </div>
          <input type="email" id="forgot-email" name="email"
                 class="form-input @error('email') error @enderror"
                 placeholder="nama@email.com"
                 value="{{ old('email') }}"
                 autocomplete="email" required autofocus>
        </div>
        @error('email')
          <div class="form-error show">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
              <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
            </svg>
            <span>{{ $message }}</span>
          </div>
        @enderror
      </div>

      <button type="submit" class="auth-btn" id="sendBtn">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
          <line x1="22" y1="2" x2="11" y2="13"/>
          <polygon points="22 2 15 22 11 13 2 9 22 2"/>
        </svg>
        Kirim
      </button>
    </form>

    <button class="back-link" onclick="window.location.href='/login'">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/>
      </svg>
      Kembali ke halaman login
    </button>
  @endif

</div>

<script>
const form = document.getElementById('forgotForm');
const btn  = document.getElementById('sendBtn');
if (form && btn) {
  form.addEventListener('submit', () => {
    btn.disabled = true;
    btn.innerHTML = `<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4M4.93 19.07l2.83-2.83M16.24 7.76l2.83-2.83"/></svg> Mengirim…`;
  });
}
</script>
</body>
</html>
