<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Reset Password — Rythmiq</title>
<style>
  * { box-sizing: border-box; margin: 0; padding: 0; }
  body {
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
    background: #f3f6fb;
    color: #1a202c;
    padding: 40px 16px;
  }
  .container {
    max-width: 520px;
    margin: 0 auto;
    background: #ffffff;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 8px 40px rgba(0,0,0,0.10);
  }
  .header {
    background: linear-gradient(135deg, #6366f1, #3b82f6);
    padding: 36px 40px 30px;
    text-align: center;
  }
  .logo-wrap {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 4px;
  }
  .logo-icon {
    width: 40px; height: 40px;
    background: rgba(255,255,255,0.2);
    border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
  }
  .logo-text {
    font-size: 22px; font-weight: 800; color: #ffffff; letter-spacing: -0.5px;
  }
  .body { padding: 36px 40px; }
  .greeting { font-size: 15px; color: #64748b; margin-bottom: 6px; }
  .title {
    font-size: 20px; font-weight: 800; color: #1a202c;
    margin-bottom: 16px; letter-spacing: -0.3px;
  }
  .desc {
    font-size: 13.5px; color: #64748b; line-height: 1.7; margin-bottom: 28px;
  }
  .btn-wrap { text-align: center; margin-bottom: 28px; }
  .reset-btn {
    display: inline-block;
    padding: 15px 36px;
    background: linear-gradient(135deg, #4f46e5, #6366f1);
    color: #ffffff !important;
    text-decoration: none;
    border-radius: 14px;
    font-size: 15px; font-weight: 700; letter-spacing: -0.2px;
    box-shadow: 0 4px 18px rgba(99,102,241,0.4);
  }
  .url-fallback {
    background: #f8faff;
    border: 1px solid #e0e7ff;
    border-radius: 10px;
    padding: 12px 16px;
    font-size: 12px; color: #6366f1;
    word-break: break-all;
    margin-bottom: 24px;
    line-height: 1.6;
  }
  .url-fallback strong { display: block; color: #64748b; margin-bottom: 4px; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; }
  .warning {
    background: #fff7ed; border: 1px solid #fed7aa;
    border-radius: 12px; padding: 14px 16px;
    font-size: 12.5px; color: #92400e; line-height: 1.6; margin-bottom: 24px;
  }
  .warning strong { color: #7c2d12; }
  .expiry-note {
    background: #eff6ff; border: 1px solid #bfdbfe;
    border-radius: 10px; padding: 12px 16px;
    font-size: 12.5px; color: #1d4ed8; line-height: 1.6; margin-bottom: 24px;
    display: flex; align-items: center; gap: 8px;
  }
  .divider { height: 1px; background: #e5eaf2; margin: 24px 0; }
  .footer {
    font-size: 12px; color: #94a3b8; line-height: 1.7;
    text-align: center; padding: 0 40px 32px;
  }
  .footer a { color: #6366f1; text-decoration: none; }
</style>
</head>
<body>
<div class="container">

  <!-- Header -->
  <div class="header">
    <div class="logo-wrap">
      <div class="logo-icon">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
          <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>
        </svg>
      </div>
      <span class="logo-text">Rythmiq</span>
    </div>
  </div>

  <!-- Body -->
  <div class="body">
    <p class="greeting">Halo, {{ $userName }} 👋</p>
    <h1 class="title">Reset Password Anda</h1>
    <p class="desc">
      Kami menerima permintaan untuk mereset password akun Rythmiq Anda.
      Klik tombol di bawah ini untuk membuat password baru.
    </p>

    <!-- CTA Button -->
    <div class="btn-wrap">
      <a href="{{ $resetUrl }}" class="reset-btn">🔑 Reset Password Sekarang</a>
    </div>

    <!-- Expiry notice -->
    <div class="expiry-note">
      ⏱ Link ini hanya berlaku selama <strong>&nbsp;60 menit&nbsp;</strong> sejak email ini dikirim.
    </div>

    <!-- URL fallback -->
    <div class="url-fallback">
      <strong>Jika tombol tidak berfungsi, salin link berikut ke browser:</strong>
      {{ $resetUrl }}
    </div>

    <!-- Security Warning -->
    <div class="warning">
      🔒 <strong>Jangan bagikan link ini kepada siapapun.</strong>
      Jika Anda tidak meminta reset password, abaikan email ini — password Anda tidak akan berubah.
    </div>

    <div class="divider"></div>
  </div>

  <!-- Footer -->
  <div class="footer">
    Email ini dikirim otomatis oleh sistem Rythmiq.<br>
    Jika ada pertanyaan, hubungi kami di <a href="mailto:support@rythmiq.id">support@rythmiq.id</a>
  </div>

</div>
</body>
</html>
