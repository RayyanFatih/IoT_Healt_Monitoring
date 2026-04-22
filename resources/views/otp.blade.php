<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Verifikasi OTP — Rythmiq</title>
<meta name="description" content="Masukkan kode verifikasi 6 digit yang dikirim ke email Anda.">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="/css/auth.css">
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="/css/otp.css">
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
      <h1 class="auth-title">Verifikasi Email</h1>
      <p class="auth-subtitle">Masukkan kode 6 digit yang telah dikirim</p>
    </div>

    <!-- Info box -->
    <div class="otp-info-box">
      <div class="otp-info-icon">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
          <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
          <polyline points="22,6 12,13 2,6"/>
        </svg>
      </div>
      <div class="otp-info-text">
        <div class="otp-info-title">Kode dikirim ke</div>
        <div class="otp-info-email" id="maskedEmailDisplay">{{ $maskedEmail }}</div>
      </div>
    </div>

    <!-- Expired notice -->
    <div class="expired-notice" id="expiredNotice">
      ⏰ Kode OTP sudah kedaluwarsa. Silakan <a href="/login" style="color:#ea580c;font-weight:700;">login ulang</a>.
    </div>

    <!-- OTP Digit Inputs -->
    <div class="otp-inputs" id="otpInputs">
      <input class="otp-digit" id="d0" type="number" maxlength="1" min="0" max="9" inputmode="numeric" autocomplete="one-time-code" autofocus>
      <input class="otp-digit" id="d1" type="number" maxlength="1" min="0" max="9" inputmode="numeric">
      <input class="otp-digit" id="d2" type="number" maxlength="1" min="0" max="9" inputmode="numeric">
      <input class="otp-digit" id="d3" type="number" maxlength="1" min="0" max="9" inputmode="numeric">
      <input class="otp-digit" id="d4" type="number" maxlength="1" min="0" max="9" inputmode="numeric">
      <input class="otp-digit" id="d5" type="number" maxlength="1" min="0" max="9" inputmode="numeric">
    </div>

    <!-- Error message -->
    <div class="otp-error-msg" id="otpError">Kode tidak sesuai. Coba lagi.</div>

    <!-- Timer -->
    <div class="otp-timer-row">
      <span>Kode berlaku:</span>
      <span class="timer-countdown" id="timerDisplay">02:00</span>
    </div>

    <!-- Submit button -->
    <button class="auth-btn" id="verifyBtn" onclick="submitOtp()" disabled>
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
        <polyline points="22 4 12 15 9 12"/>
      </svg>
      Verifikasi
    </button>

    <!-- Resend -->
    <div class="resend-row">
      Tidak menerima kode?
      <button class="resend-btn" id="resendBtn" onclick="resendOtp()">Kirim Ulang</button>
    </div>

    <!-- Back to login -->
    <button class="back-link" onclick="window.location.href='/login'">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/>
      </svg>
      Kembali ke halaman login
    </button>

    <!-- Success state -->
    <div class="auth-success" id="otpSuccess">
      <div class="success-icon">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
          <polyline points="20 6 9 17 4 12"/>
        </svg>
      </div>
      <div class="success-title">Verifikasi Berhasil!</div>
      <div class="success-sub">Mengalihkan ke dashboard…</div>
    </div>

  </div>
</div>

<script>
const CSRF        = document.querySelector('meta[name="csrf-token"]').content;
const digits      = Array.from({length: 6}, (_, i) => document.getElementById('d' + i));
const verifyBtn   = document.getElementById('verifyBtn');
const otpError    = document.getElementById('otpError');
const resendBtn   = document.getElementById('resendBtn');
const timerEl     = document.getElementById('timerDisplay');
const expiredNote = document.getElementById('expiredNotice');

// ── EXPIRY TIMER ──
const expiryTs = {{ $expiry }};
let timerInterval;

function startTimer() {
  clearInterval(timerInterval);
  timerInterval = setInterval(() => {
    const remaining = expiryTs - Math.floor(Date.now() / 1000);
    if (remaining <= 0) {
      clearInterval(timerInterval);
      timerEl.textContent = '00:00';
      timerEl.classList.add('urgent');
      expiredNote.classList.add('show');
      digits.forEach(d => d.disabled = true);
      verifyBtn.disabled = true;
      resendBtn.disabled = false;
      return;
    }
    const m = String(Math.floor(remaining / 60)).padStart(2, '0');
    const s = String(remaining % 60).padStart(2, '0');
    timerEl.textContent = `${m}:${s}`;
    if (remaining <= 60) timerEl.classList.add('urgent');
    else timerEl.classList.remove('urgent');
  }, 1000);
}
startTimer();

// ── DIGIT INPUT BEHAVIOUR ──
digits.forEach((input, idx) => {
  input.addEventListener('input', (e) => {
    // Keep only single digit
    const val = e.target.value.replace(/\D/g, '').slice(-1);
    e.target.value = val;

    if (val) {
      e.target.classList.add('filled');
      if (idx < 5) digits[idx + 1].focus();
    } else {
      e.target.classList.remove('filled');
    }
    hideError();
    updateBtn();
  });

  input.addEventListener('keydown', (e) => {
    if (e.key === 'Backspace' && !input.value && idx > 0) {
      digits[idx - 1].focus();
      digits[idx - 1].value = '';
      digits[idx - 1].classList.remove('filled');
      updateBtn();
    }
    // Prevent non-numeric
    if (!/[0-9]|Backspace|Tab|ArrowLeft|ArrowRight/.test(e.key)) {
      e.preventDefault();
    }
  });

  // Handle paste (paste full 6 digit code)
  input.addEventListener('paste', (e) => {
    e.preventDefault();
    const pasted = (e.clipboardData || window.clipboardData).getData('text').replace(/\D/g, '');
    if (pasted.length >= 6) {
      digits.forEach((d, i) => {
        d.value = pasted[i] || '';
        d.classList.toggle('filled', !!pasted[i]);
      });
      digits[5].focus();
      updateBtn();
    }
  });
});

function getCode() {
  return digits.map(d => d.value).join('');
}

function updateBtn() {
  verifyBtn.disabled = getCode().length < 6;
}

function hideError() {
  otpError.classList.remove('show');
  digits.forEach(d => d.classList.remove('error-state'));
}

function showError(msg) {
  otpError.textContent = msg || 'Kode tidak sesuai. Coba lagi.';
  otpError.classList.add('show');
  digits.forEach(d => {
    d.value = '';
    d.classList.remove('filled');
    d.classList.add('error-state');
  });
  setTimeout(() => digits.forEach(d => d.classList.remove('error-state')), 400);
  digits[0].focus();
  updateBtn();
}

// ── SUBMIT OTP ──
async function submitOtp() {
  const code = getCode();
  if (code.length < 6) return;

  verifyBtn.disabled = true;
  verifyBtn.innerHTML = `<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4M4.93 19.07l2.83-2.83M16.24 7.76l2.83-2.83"/></svg> Memverifikasi…`;

  try {
    const res = await fetch('/otp/verify', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': CSRF,
        'Accept': 'application/json',
      },
      body: JSON.stringify({ code }),
    });

    const data = await res.json();

    if (data.success) {
      clearInterval(timerInterval);
      document.querySelector('.auth-card').innerHTML = `
        <div class="auth-logo">
          <div class="auth-logo-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
          </div>
          <span class="auth-logo-text">Rythmiq</span>
        </div>
        <div class="auth-success show">
          <div class="success-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
          </div>
          <div class="success-title">Verifikasi Berhasil!</div>
          <div class="success-sub">Mengalihkan ke dashboard…</div>
        </div>`;
      setTimeout(() => { window.location.href = '/dashboard'; }, 1600);
    } else {
      if (data.expired) {
        clearInterval(timerInterval);
        expiredNote.classList.add('show');
        digits.forEach(d => d.disabled = true);
        verifyBtn.innerHTML = `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 15 9 12"/></svg> Verifikasi`;
      } else {
        showError(data.message);
        verifyBtn.disabled = false;
        verifyBtn.innerHTML = `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 15 9 12"/></svg> Verifikasi`;
        updateBtn();
      }
    }
  } catch (err) {
    showError('Terjadi kesalahan. Coba lagi.');
    verifyBtn.disabled = false;
    verifyBtn.innerHTML = `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 15 9 12"/></svg> Verifikasi`;
    updateBtn();
  }
}

// ── RESEND OTP ──
let resendCooldown = 0;
async function resendOtp() {
  if (resendCooldown > 0) return;

  resendBtn.disabled = true;
  resendBtn.textContent = 'Mengirim…';

  try {
    const res = await fetch('/otp/resend', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': CSRF,
        'Accept': 'application/json',
      },
    });

    const data = await res.json();

    if (data.success) {
      // Reset timer & UI
      expiredNote.classList.remove('show');
      digits.forEach(d => { d.disabled = false; d.value = ''; d.classList.remove('filled', 'error-state'); });
      digits[0].focus();
      hideError();
      updateBtn();

      // Update expiry in JS (simulate new 10 min window from now)
      // The server updates the session; we restart our countdown
      const newExpiry = Math.floor(Date.now() / 1000) + 600;
      Object.defineProperty(window, 'expiryTs', { value: newExpiry, writable: true });
      startTimer();

      // Cooldown 60s
      resendCooldown = 60;
      const countdown = setInterval(() => {
        resendCooldown--;
        resendBtn.textContent = `Kirim Ulang (${resendCooldown}s)`;
        if (resendCooldown <= 0) {
          clearInterval(countdown);
          resendBtn.textContent = 'Kirim Ulang';
          resendBtn.disabled = false;
        }
      }, 1000);
    } else {
      resendBtn.textContent = 'Kirim Ulang';
      resendBtn.disabled = false;
    }
  } catch {
    resendBtn.textContent = 'Kirim Ulang';
    resendBtn.disabled = false;
  }
}

// Allow Enter key to submit
document.addEventListener('keydown', (e) => {
  if (e.key === 'Enter' && !verifyBtn.disabled) submitOtp();
});
</script>
</body>
</html>
