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
</head>
<body>

<!-- Background blobs -->
<div class="auth-bg-blob blob-1"></div>
<div class="auth-bg-blob blob-2"></div>
<div class="auth-bg-blob blob-3"></div>

<div class="auth-wrapper">
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

    <!-- Heading -->
    <div class="auth-heading">
      <h1 class="auth-title">Selamat Datang</h1>
      <p class="auth-subtitle">Masuk untuk memantau data kesehatanmu</p>
    </div>

    <!-- Form (normal view) -->
    <div id="loginFormWrap">
      <form class="auth-form" id="loginForm" onsubmit="handleLogin(event)" novalidate>

        <!-- Email -->
        <div class="form-group">
          <label class="form-label" for="login-email">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
            Email
          </label>
          <div class="input-wrap">
            <div class="input-icon">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
            </div>
            <input type="email" id="login-email" class="form-input" placeholder="nama@email.com" autocomplete="email" required>
          </div>
          <div class="form-error" id="email-error">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            <span id="email-error-text">Email tidak valid</span>
          </div>
        </div>

        <!-- Password -->
        <div class="form-group">
          <label class="form-label" for="login-password">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
            Password
          </label>
          <div class="input-wrap">
            <div class="input-icon">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
            </div>
            <input type="password" id="login-password" class="form-input" placeholder="••••••••" autocomplete="current-password" required>
            <button type="button" class="pw-toggle" id="togglePw" onclick="togglePassword('login-password','togglePw')" title="Tampilkan password">
              <svg id="eye-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
            </button>
          </div>
          <div class="form-error" id="pw-error">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            <span>Password tidak boleh kosong</span>
          </div>
        </div>

        <!-- Submit -->
        <button type="submit" class="auth-btn" id="loginBtn">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
          Masuk
        </button>

      </form>

      <div class="auth-divider"><span>atau</span></div>

      <div class="auth-footer">
        Belum punya akun? <a href="/register">Daftar sekarang</a>
      </div>
    </div>

    <!-- Success state (shown after OTP sent) -->
    <div class="auth-success" id="loginSuccess">
      <div class="success-icon" style="background: #dbeafe;">
        <svg viewBox="0 0 24 24" fill="none" stroke="#3b82f6" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
          <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
          <polyline points="22,6 12,13 2,6"/>
        </svg>
      </div>
      <div class="success-title">Kode Terkirim!</div>
      <div class="success-sub" id="successEmailHint">Memeriksa email Anda…</div>
    </div>

  </div>
</div>

<script>
const CSRF = document.querySelector('meta[name="csrf-token"]').content;

// ---- Toggle password visibility ----
function togglePassword(inputId, btnId) {
  const input = document.getElementById(inputId);
  const btn   = document.getElementById(btnId);
  const isHidden = input.type === 'password';
  input.type = isHidden ? 'text' : 'password';
  btn.innerHTML = isHidden
    ? `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/><path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/><line x1="1" y1="1" x2="23" y2="23"/></svg>`
    : `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>`;
}

// ---- Form validation helpers ----
function showError(id, msg) {
  const el = document.getElementById(id);
  el.querySelector('span') && (el.querySelector('span').textContent = msg);
  el.classList.add('show');
}
function hideError(id) {
  const el = document.getElementById(id);
  el && el.classList.remove('show');
}

// ---- Submit login to backend ----
async function handleLogin(e) {
  e.preventDefault();
  const email = document.getElementById('login-email');
  const pw    = document.getElementById('login-password');
  let valid   = true;

  hideError('email-error'); hideError('pw-error');
  email.classList.remove('error'); pw.classList.remove('error');

  if (!email.value || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value)) {
    showError('email-error', 'Masukkan email yang valid');
    email.classList.add('error');
    valid = false;
  }
  if (!pw.value) {
    document.getElementById('pw-error').classList.add('show');
    pw.classList.add('error');
    valid = false;
  }
  if (!valid) return;

  const btn = document.getElementById('loginBtn');
  btn.disabled = true;
  btn.innerHTML = `<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4M4.93 19.07l2.83-2.83M16.24 7.76l2.83-2.83"/></svg> Memproses…`;

  try {
    const res  = await fetch('/login', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': CSRF,
        'Accept': 'application/json',
      },
      body: JSON.stringify({ email: email.value, password: pw.value }),
    });

    const data = await res.json();

    if (data.success) {
      // Langsung redirect ke halaman OTP tanpa halaman peralihan
      window.location.href = '/otp';
    } else {
      showError('email-error', data.message || 'Email atau password salah.');
      email.classList.add('error');
      pw.classList.add('error');
      btn.disabled = false;
      btn.innerHTML = `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg> Masuk`;
    }
  } catch (err) {
    showError('email-error', 'Terjadi kesalahan server. Coba lagi.');
    btn.disabled = false;
    btn.innerHTML = `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg> Masuk`;
  }
}

// Clear errors on input
document.getElementById('login-email').addEventListener('input', () => hideError('email-error'));
document.getElementById('login-password').addEventListener('input', () => hideError('pw-error'));
</script>
</body>
</html>
