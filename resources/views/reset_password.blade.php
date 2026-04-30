<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Reset Password — Rythmiq</title>
<meta name="description" content="Buat password baru untuk akun Rythmiq Anda.">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="/css/auth.css">
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%236366f1' stroke-width='2.5'><polyline points='22 12 18 12 15 21 9 3 6 12 2 12'/></svg>">
<link rel="stylesheet" href="/css/reset_password.css">
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

  <div class="auth-heading">
    <h1 class="auth-title">Buat Password Baru</h1>
    <p class="auth-subtitle">Password baru harus berbeda dari password sebelumnya</p>
  </div>

  {{-- Error message --}}
  @if(session('error'))
    <div class="alert-error">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
        <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
      </svg>
      {{ session('error') }}
    </div>
  @endif

  <form class="auth-form" id="resetForm" method="POST" action="/reset-password" novalidate>
    @csrf
    <input type="hidden" name="token" value="{{ $token }}">
    <input type="hidden" name="email" value="{{ $email }}">

    <!-- Password Baru -->
    <div class="form-group">
      <label class="form-label" for="new-password">Password Baru</label>
      <div class="input-wrap">
        <div class="input-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/>
          </svg>
        </div>
        <input type="password" id="new-password" name="password"
               class="form-input @error('password') error @enderror"
               placeholder="Min. 8 karakter"
               autocomplete="new-password" required
               oninput="checkStrength(this.value)">
        <button type="button" class="pw-toggle" id="togglePw1"
                onclick="togglePassword('new-password','togglePw1')" title="Tampilkan password">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
          </svg>
        </button>
      </div>
      <!-- Strength bar -->
      <div class="pw-strength-wrap" id="strengthWrap" style="display:none">
        <div class="pw-strength-bars">
          <div class="pw-strength-bar" id="bar1"></div>
          <div class="pw-strength-bar" id="bar2"></div>
          <div class="pw-strength-bar" id="bar3"></div>
          <div class="pw-strength-bar" id="bar4"></div>
        </div>
        <div class="pw-strength-label" id="strengthLabel"></div>
      </div>
      @error('password')
        <div class="form-error show">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
            <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
          </svg>
          <span>{{ $message }}</span>
        </div>
      @enderror
    </div>

    <!-- Konfirmasi Password -->
    <div class="form-group">
      <label class="form-label" for="confirm-password">Konfirmasi Password</label>
      <div class="input-wrap">
        <div class="input-icon">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 15 9 12"/>
          </svg>
        </div>
        <input type="password" id="confirm-password" name="password_confirmation"
               class="form-input"
               placeholder="Ulangi password baru"
               autocomplete="new-password" required
               oninput="checkMatch()">
        <button type="button" class="pw-toggle" id="togglePw2"
                onclick="togglePassword('confirm-password','togglePw2')" title="Tampilkan password">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>
          </svg>
        </button>
      </div>
      <div class="form-error" id="matchError">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
          <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
        </svg>
        <span>Password tidak cocok.</span>
      </div>
    </div>

    <!-- Submit -->
    <button type="submit" class="auth-btn" id="resetBtn">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/>
      </svg>
      Simpan Password Baru
    </button>
  </form>

  <button class="back-link" onclick="window.location.href='/login'">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
      <line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/>
    </svg>
    Kembali ke halaman login
  </button>

</div>

<script>
// ── Toggle Password Visibility ──────────────────────────────────
function togglePassword(inputId, btnId) {
  const input   = document.getElementById(inputId);
  const btn     = document.getElementById(btnId);
  const isHidden = input.type === 'password';
  input.type = isHidden ? 'text' : 'password';
  btn.innerHTML = isHidden
    ? `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/><path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/><line x1="1" y1="1" x2="23" y2="23"/></svg>`
    : `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>`;
}

// ── Password Strength ───────────────────────────────────────────
function checkStrength(val) {
  const wrap  = document.getElementById('strengthWrap');
  const label = document.getElementById('strengthLabel');
  const bars  = [1,2,3,4].map(i => document.getElementById('bar'+i));

  if (!val) { wrap.style.display = 'none'; return; }
  wrap.style.display = 'block';

  let score = 0;
  if (val.length >= 8)  score++;
  if (/[A-Z]/.test(val)) score++;
  if (/[0-9]/.test(val)) score++;
  if (/[^A-Za-z0-9]/.test(val)) score++;

  const configs = [
    { color: '#ef4444', text: 'Lemah' },
    { color: '#f97316', text: 'Cukup' },
    { color: '#eab308', text: 'Baik' },
    { color: '#22c55e', text: 'Kuat' },
  ];

  bars.forEach((bar, i) => {
    bar.style.background = i < score ? configs[score - 1].color : 'var(--border)';
  });
  label.textContent = configs[score - 1]?.text ?? '';
  label.style.color  = configs[score - 1]?.color ?? 'var(--text-muted)';
}

// ── Confirm Password Match ──────────────────────────────────────
function checkMatch() {
  const pw      = document.getElementById('new-password').value;
  const confirm = document.getElementById('confirm-password').value;
  const err     = document.getElementById('matchError');
  if (confirm && pw !== confirm) {
    err.classList.add('show');
  } else {
    err.classList.remove('show');
  }
}

// ── Submit loading state ────────────────────────────────────────
document.getElementById('resetForm').addEventListener('submit', function(e) {
  const pw      = document.getElementById('new-password').value;
  const confirm = document.getElementById('confirm-password').value;
  if (pw !== confirm) { e.preventDefault(); return; }
  const btn = document.getElementById('resetBtn');
  btn.disabled = true;
  btn.innerHTML = `<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4M4.93 19.07l2.83-2.83M16.24 7.76l2.83-2.83"/></svg> Menyimpan…`;
});
</script>
</body>
</html>
