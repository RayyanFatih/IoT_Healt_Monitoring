<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Daftar — Rythmiq</title>
<meta name="description" content="Buat akun Rythmiq IoT Health Monitoring baru.">
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
      <h1 class="auth-title">Buat Akun Baru</h1>
      <p class="auth-subtitle">Daftar untuk mulai memantau kesehatan Anda</p>
    </div>

    <!-- Form -->
    <div id="regFormWrap">
      <form class="auth-form" id="regForm" onsubmit="handleRegister(event)" novalidate>

        <!-- Nama -->
        <div class="form-group">
          <label class="form-label" for="reg-name">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            Nama Lengkap
          </label>
          <div class="input-wrap">
            <div class="input-icon">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            </div>
            <input type="text" id="reg-name" class="form-input" placeholder="Ahmad Farhan" autocomplete="name" required>
          </div>
          <div class="form-error" id="name-error">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            <span>Nama tidak boleh kosong</span>
          </div>
        </div>

        <!-- Email -->
        <div class="form-group">
          <label class="form-label" for="reg-email">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
            Email
          </label>
          <div class="input-wrap">
            <div class="input-icon">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
            </div>
            <input type="email" id="reg-email" class="form-input" placeholder="nama@email.com" autocomplete="email" required>
          </div>
          <div class="form-error" id="reg-email-error">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            <span id="reg-email-error-text">Email tidak valid</span>
          </div>
        </div>

        <!-- Password -->
        <div class="form-group">
          <label class="form-label" for="reg-password">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
            Password
          </label>
          <div class="input-wrap">
            <div class="input-icon">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
            </div>
            <input type="password" id="reg-password" class="form-input" placeholder="Min. 8 karakter" autocomplete="new-password" required oninput="checkStrength(this.value)">
            <button type="button" class="pw-toggle" id="toggleRegPw" onclick="togglePassword('reg-password','toggleRegPw')" title="Tampilkan password">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
            </button>
          </div>
          <!-- Strength bar -->
          <div class="pw-strength-wrap" id="strengthWrap" style="display:none;">
            <div class="pw-strength-bars">
              <div class="pw-strength-bar" id="sb1"></div>
              <div class="pw-strength-bar" id="sb2"></div>
              <div class="pw-strength-bar" id="sb3"></div>
              <div class="pw-strength-bar" id="sb4"></div>
            </div>
            <span class="pw-strength-label" id="strengthLabel">Lemah</span>
          </div>
          <div class="form-error" id="reg-pw-error">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            <span id="reg-pw-error-text">Password minimal 8 karakter</span>
          </div>
        </div>

        <!-- Konfirmasi Password -->
        <div class="form-group">
          <label class="form-label" for="reg-confirm">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
            Konfirmasi Password
          </label>
          <div class="input-wrap">
            <div class="input-icon">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
            </div>
            <input type="password" id="reg-confirm" class="form-input" placeholder="Ulangi password" autocomplete="new-password" required>
            <button type="button" class="pw-toggle" id="toggleConfirm" onclick="togglePassword('reg-confirm','toggleConfirm')" title="Tampilkan password">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
            </button>
          </div>
          <div class="form-error" id="confirm-error">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            <span id="confirm-error-text">Password tidak cocok</span>
          </div>
        </div>

        <!-- Submit -->
        <button type="submit" class="auth-btn" id="regBtn">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" y1="8" x2="19" y2="14"/><line x1="22" y1="11" x2="16" y2="11"/></svg>
          Buat Akun
        </button>

      </form>

      <div class="auth-divider"><span>atau</span></div>

      <div class="auth-footer">
        Sudah punya akun? <a href="/login">Masuk di sini</a>
      </div>
    </div>

    <!-- Success state -->
    <div class="auth-success" id="regSuccess">
      <div class="success-icon">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
          <polyline points="20 6 9 17 4 12"/>
        </svg>
      </div>
      <div class="success-title">Akun Berhasil Dibuat!</div>
      <div class="success-sub">Mengalihkan ke halaman login…</div>
    </div>

  </div>
</div>

<script>
// ---- Toggle password ----
function togglePassword(inputId, btnId) {
  const input = document.getElementById(inputId);
  const btn   = document.getElementById(btnId);
  const isHidden = input.type === 'password';
  input.type = isHidden ? 'text' : 'password';
  btn.innerHTML = isHidden
    ? `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/><path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/><line x1="1" y1="1" x2="23" y2="23"/></svg>`
    : `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>`;
}

// ---- Password strength ----
function checkStrength(val) {
  const wrap = document.getElementById('strengthWrap');
  wrap.style.display = val ? 'block' : 'none';
  const bars  = [document.getElementById('sb1'), document.getElementById('sb2'), document.getElementById('sb3'), document.getElementById('sb4')];
  const label = document.getElementById('strengthLabel');
  const colorMap = { 1: '#ef4444', 2: '#f59e0b', 3: '#3b82f6', 4: '#10b981' };
  const labelMap = { 1: 'Lemah', 2: 'Cukup', 3: 'Kuat', 4: 'Sangat Kuat' };
  let score = 0;
  if (val.length >= 8) score++;
  if (/[A-Z]/.test(val)) score++;
  if (/[0-9]/.test(val)) score++;
  if (/[^A-Za-z0-9]/.test(val)) score++;
  score = Math.max(1, score);
  bars.forEach((b, i) => { b.style.background = i < score ? colorMap[score] : 'var(--border)'; });
  label.textContent = labelMap[score];
  label.style.color = colorMap[score];
}

// ---- SHA-256 hash ----
async function hashPassword(password) {
  const enc = new TextEncoder();
  const buf = await crypto.subtle.digest('SHA-256', enc.encode(password));
  return Array.from(new Uint8Array(buf)).map(b => b.toString(16).padStart(2, '0')).join('');
}

// ---- Errors ----
function showError(id, msg) {
  const el = document.getElementById(id);
  const span = el.querySelector('span');
  if (msg && span) span.textContent = msg;
  el.classList.add('show');
}
function hideAll() {
  ['name-error','reg-email-error','reg-pw-error','confirm-error'].forEach(id => {
    const el = document.getElementById(id);
    el && el.classList.remove('show');
  });
  document.querySelectorAll('.form-input').forEach(el => el.classList.remove('error'));
}

// ---- Submit register to backend ----
async function handleRegister(e) {
  e.preventDefault();
  hideAll();
  const name    = document.getElementById('reg-name');
  const email   = document.getElementById('reg-email');
  const pw      = document.getElementById('reg-password');
  const confirm = document.getElementById('reg-confirm');
  let valid = true;

  if (!name.value.trim()) { showError('name-error'); name.classList.add('error'); valid = false; }
  if (!email.value || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value)) {
    showError('reg-email-error', 'Masukkan email yang valid');
    email.classList.add('error'); valid = false;
  }
  if (!pw.value || pw.value.length < 8) {
    showError('reg-pw-error', 'Password minimal 8 karakter');
    pw.classList.add('error'); valid = false;
  }
  if (pw.value !== confirm.value) {
    showError('confirm-error', 'Password tidak cocok');
    confirm.classList.add('error'); valid = false;
  }
  if (!valid) return;

  const btn = document.getElementById('regBtn');
  btn.disabled = true;
  btn.innerHTML = `<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4M4.93 19.07l2.83-2.83M16.24 7.76l2.83-2.83"/></svg> Membuat akun…`;

  const CSRF = document.querySelector('meta[name="csrf-token"]').content;

  try {
    const res = await fetch('/register', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': CSRF,
        'Accept': 'application/json',
      },
      body: JSON.stringify({
        name: name.value.trim(),
        email: email.value,
        password: pw.value,
        password_confirmation: confirm.value,
      }),
    });

    const data = await res.json();

    if (data.success) {
      document.getElementById('regFormWrap').style.display = 'none';
      document.getElementById('regSuccess').classList.add('show');
      setTimeout(() => { window.location.href = '/login'; }, 1800);
    } else {
      // Show validation errors from server
      if (data.errors) {
        if (data.errors.name)     showError('name-error',      data.errors.name[0]);
        if (data.errors.email)    showError('reg-email-error', data.errors.email[0]);
        if (data.errors.password) showError('reg-pw-error',    data.errors.password[0]);
      } else {
        showError('reg-email-error', data.message || 'Terjadi kesalahan.');
      }
      btn.disabled = false;
      btn.innerHTML = `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" y1="8" x2="19" y2="14"/><line x1="22" y1="11" x2="16" y2="11"/></svg> Buat Akun`;
    }
  } catch (err) {
    showError('reg-email-error', 'Terjadi kesalahan server. Coba lagi.');
    btn.disabled = false;
    btn.innerHTML = `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" y1="8" x2="19" y2="14"/><line x1="22" y1="11" x2="16" y2="11"/></svg> Buat Akun`;
  }
}

// Clear errors on input
['reg-name','reg-email','reg-password','reg-confirm'].forEach(id => {
  document.getElementById(id).addEventListener('input', hideAll);
});
</script>
</body>
</html>
