<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Kode Verifikasi — Rythmiq</title>
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
    width: 40px;
    height: 40px;
    background: rgba(255,255,255,0.2);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
  }
  .logo-text {
    font-size: 22px;
    font-weight: 800;
    color: #ffffff;
    letter-spacing: -0.5px;
  }
  .body {
    padding: 36px 40px;
  }
  .greeting {
    font-size: 15px;
    color: #64748b;
    margin-bottom: 6px;
  }
  .title {
    font-size: 20px;
    font-weight: 800;
    color: #1a202c;
    margin-bottom: 16px;
    letter-spacing: -0.3px;
  }
  .desc {
    font-size: 13.5px;
    color: #64748b;
    line-height: 1.7;
    margin-bottom: 28px;
  }
  .otp-box {
    background: linear-gradient(135deg, #eff6ff, #eef2ff);
    border: 2px solid #c7d2fe;
    border-radius: 16px;
    padding: 28px 20px;
    text-align: center;
    margin-bottom: 28px;
  }
  .otp-label {
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1.5px;
    color: #6366f1;
    margin-bottom: 12px;
  }
  .otp-code {
    font-size: 44px;
    font-weight: 800;
    letter-spacing: 14px;
    color: #1a202c;
    font-family: 'DM Mono', 'Courier New', monospace;
    text-indent: 14px;
  }
  .otp-expiry {
    font-size: 12px;
    color: #94a3b8;
    margin-top: 10px;
    font-weight: 500;
  }
  .warning {
    background: #fff7ed;
    border: 1px solid #fed7aa;
    border-radius: 12px;
    padding: 14px 16px;
    font-size: 12.5px;
    color: #92400e;
    line-height: 1.6;
    margin-bottom: 24px;
  }
  .warning strong { color: #7c2d12; }
  .divider {
    height: 1px;
    background: #e5eaf2;
    margin: 24px 0;
  }
  .footer {
    font-size: 12px;
    color: #94a3b8;
    line-height: 1.7;
    text-align: center;
    padding: 0 40px 32px;
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
    <h1 class="title">Kode Verifikasi Login</h1>
    <p class="desc">
      Kami menerima permintaan login ke akun Rythmiq Anda. 
      Gunakan kode berikut untuk menyelesaikan proses masuk:
    </p>

    <!-- OTP Code Box -->
    <div class="otp-box">
      <div class="otp-label">Kode Verifikasi</div>
      <div class="otp-code">{{ $otp }}</div>
      <div class="otp-expiry">⏱ Berlaku selama <strong>2 menit</strong></div>
    </div>

    <!-- Security Warning -->
    <div class="warning">
      🔒 <strong>Jangan bagikan kode ini kepada siapapun.</strong>
      Tim Rythmiq tidak akan pernah meminta kode verifikasi Anda.
      Jika Anda tidak melakukan login, abaikan email ini.
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
