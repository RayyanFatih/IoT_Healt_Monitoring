<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Rythmiq — IoT Health Monitoring</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="/css/dashboard.css">
<meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>

<!-- LAYOUT WRAPPER -->
<div class="layout">

  <!-- SIDEBAR -->
  <aside class="sidebar">
    <div class="sidebar-logo">
      <div class="sidebar-logo-icon">
        <svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
          <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>
        </svg>
      </div>
      <span class="sidebar-logo-text">Rythmiq</span>
    </div>

    <nav class="sidebar-nav">
      <a href="#" class="nav-item active" id="nav-dashboard">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/>
          <rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/>
        </svg>
        Dashboard
      </a>
      <a href="/history" class="nav-item" id="nav-history">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>
        </svg>
        History
      </a>
    </nav>

    <div class="sidebar-bottom">
      <a href="#" class="nav-item" id="nav-account" onclick="openProfilePanel(); return false;">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
        </svg>
        Profile
      </a>
      <a href="#" class="nav-item" id="nav-logout" onclick="openLogoutModal(); return false;">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
          <polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/>
        </svg>
        Logout
      </a>
    </div>
  </aside>

  <!-- MAIN CONTENT AREA -->
  <div class="content-area">

    <!-- PAGE TITLE -->
    <div class="page-header">
      <h1 class="page-title">Dashboard</h1>
    </div>

    <!-- 3 CARDS ROW: Stats | Condition | Sensor Status -->
    <div class="cards-row">

      <!-- STATS CARD -->
      <div class="info-card">
        <div class="info-card-title">Stats</div>

        <!-- Heart Rate -->
        <div class="metric-row">
          <div class="metric-info">
            <div class="metric-label">Heart Rate</div>
            <div class="metric-value">
              <span class="metric-number" id="stats-hr">75</span>
              <span class="metric-unit">bpm</span>
            </div>
          </div>
          <div class="metric-icon-wrap red">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>
            </svg>
          </div>
        </div>

        <div class="metric-divider"></div>

        <!-- SpO2 -->
        <div class="metric-row">
          <div class="metric-info">
            <div class="metric-label">SpO<sub>2</sub></div>
            <div class="metric-value">
              <span class="metric-number" id="stats-spo2">96</span>
              <span class="metric-unit">%</span>
            </div>
          </div>
          <div class="metric-icon-wrap blue">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M12 2.69l5.66 5.66a8 8 0 1 1-11.31 0z"/>
            </svg>
          </div>
        </div>
      </div>

      <!-- CONDITION CARD -->
      <div class="info-card" id="condition-card">
        <div class="info-card-title">Condition</div>

        <div class="condition-body">
          <!-- Status Icon -->
          <div class="condition-icon-wrap" id="condition-icon-wrap">
            <!-- Normal: green shield / Abnormal: red warning -->
            <svg id="condition-icon-normal" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
              <polyline points="9 12 11 14 15 10"/>
            </svg>
            <svg id="condition-icon-abnormal" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:none;">
              <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
              <line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>
            </svg>
          </div>

          <!-- Status Text -->
          <div class="condition-text-wrap">
            <div class="condition-status-label" id="condition-status-label">Normal</div>
            <div class="condition-status-sub" id="condition-status-sub">Kondisi pasien baik dan stabil.</div>
            <!-- Warning notice (only shown when abnormal) -->
            <div class="condition-warning-notice" id="condition-warning-notice" style="display:none;">
              <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="14" height="14">
                <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
              </svg>
              Dimohon segera periksa ke fasilitas kesehatan.
            </div>
          </div>
        </div>

        <!-- Status Badge -->
        <div class="condition-badge-row">
          <div class="condition-badge normal" id="condition-badge">
            <span class="badge-dot"></span>
            <span id="condition-badge-text">Normal</span>
          </div>
        </div>
      </div>

      <!-- SENSOR STATUS CARD -->
      <div class="info-card">
        <div class="info-card-title">Sensor Status</div>

        <!-- Finger Detection -->
        <div class="sensor-row">
          <div class="sensor-row-left">
            <div class="sensor-row-icon finger" id="sensor-finger-icon">
              <!-- Finger detected icon -->
              <svg id="finger-detected-svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M18 11V6a2 2 0 0 0-2-2v0a2 2 0 0 0-2 2v0"/>
                <path d="M14 10V4a2 2 0 0 0-2-2v0a2 2 0 0 0-2 2v2"/>
                <path d="M10 10.5V6a2 2 0 0 0-2-2v0a2 2 0 0 0-2 2v8"/>
                <path d="M18 8a2 2 0 1 1 4 0v6a8 8 0 0 1-8 8h-2c-2.8 0-4.5-.86-5.99-2.34l-3.6-3.6a2 2 0 0 1 2.83-2.82L7 15"/>
              </svg>
              <!-- Finger not detected icon -->
              <svg id="finger-undetected-svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:none;">
                <line x1="1" y1="1" x2="23" y2="23"/>
                <path d="M14 10V4a2 2 0 0 0-2-2v0a2 2 0 0 0-2 2v2"/>
                <path d="M10 10.5V6a2 2 0 0 0-2-2v0a2 2 0 0 0-2 2v8"/>
                <path d="M18 11V6a2 2 0 0 0-2-2v0a2 2 0 0 0-2 2v0"/>
                <path d="M18 8a2 2 0 1 1 4 0v6a8 8 0 0 1-8 8H2"/>
              </svg>
            </div>
            <div class="sensor-row-info">
              <div class="sensor-row-label">Finger Detection</div>
              <div class="sensor-row-value" id="finger-status-text">Jari Terdeteksi</div>
            </div>
          </div>
          <div class="sensor-state-badge detected" id="finger-badge">
            <span class="badge-dot"></span>
            <span id="finger-badge-text">Terdeteksi</span>
          </div>
        </div>

        <div class="metric-divider"></div>

        <!-- Signal Quality -->
        <div class="sensor-row">
          <div class="sensor-row-left">
            <div class="sensor-row-icon signal" id="sensor-signal-icon">
              <!-- Good signal bars -->
              <svg id="signal-good-svg" viewBox="0 0 24 24" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <rect x="2" y="16" width="4" height="5" rx="1" fill="var(--blue)" stroke="none"/>
                <rect x="8.5" y="11" width="4" height="10" rx="1" fill="var(--blue)" stroke="none"/>
                <rect x="15" y="6" width="4" height="15" rx="1" fill="var(--blue)" stroke="none"/>
                <rect x="21.5" y="3" width="3" height="18" rx="1" fill="var(--border)" stroke="none"/>
              </svg>
              <!-- Bad signal bars -->
              <svg id="signal-bad-svg" viewBox="0 0 24 24" fill="none" stroke-linecap="round" stroke-linejoin="round" style="display:none;">
                <rect x="2" y="16" width="4" height="5" rx="1" fill="var(--red)" stroke="none"/>
                <rect x="8.5" y="16" width="4" height="5" rx="1" fill="var(--border)" stroke="none"/>
                <rect x="15" y="16" width="4" height="5" rx="1" fill="var(--border)" stroke="none"/>
                <rect x="21.5" y="16" width="3" height="5" rx="1" fill="var(--border)" stroke="none"/>
                <line x1="18" y1="3" x2="23" y2="8" stroke="var(--red)" stroke-width="2" stroke-linecap="round"/>
                <line x1="23" y1="3" x2="18" y2="8" stroke="var(--red)" stroke-width="2" stroke-linecap="round"/>
              </svg>
            </div>
            <div class="sensor-row-info">
              <div class="sensor-row-label">Signal Quality</div>
              <div class="sensor-row-value" id="signal-status-text">Sinyal Bagus</div>
            </div>
          </div>
          <div class="sensor-state-badge good" id="signal-badge">
            <span class="badge-dot"></span>
            <span id="signal-badge-text">Bagus</span>
          </div>
        </div>
      </div>

    </div><!-- end cards-row -->

    <!-- CHART SECTION -->
    <div class="chart-card">
      <div class="chart-header">
        <div class="chart-title-group">
          <span class="chart-title-text">Chart</span>
          <span class="chart-legend-inline" id="chart-legend">
            <span class="legend-item" id="legend-hr"><span class="legend-dot red"></span> Heart Rate (BPM)</span>
            <span class="legend-item" id="legend-spo2" style="margin-left:14px;"><span class="legend-dot blue"></span> SpO₂ (%)</span>
          </span>
        </div>
        <div class="chart-tabs">
          <button class="chart-tab active" id="tab-both">Both</button>
          <button class="chart-tab" id="tab-hr">Heart Rate</button>
          <button class="chart-tab" id="tab-spo2">SpO₂</button>
        </div>
      </div>
      <div class="chart-area">
        <canvas id="trendChart"></canvas>
      </div>
    </div>

  </div><!-- end content-area -->
</div><!-- end layout -->

<!-- ===== PROFILE OVERLAY ===== -->
<div class="profile-overlay" id="profileOverlay" onclick="closeProfilePanel()"></div>

<!-- ===== PROFILE PANEL ===== -->
<div class="profile-panel" id="profilePanel">

  <!-- Header -->
  <div class="pf-header">
    <div class="pf-header-text">
      <h2>Profile</h2>
      <p>Informasi akun pengguna</p>
    </div>
    <button class="pf-close" onclick="closeProfilePanel()">
      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round">
        <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
      </svg>
    </button>
  </div>

  <!-- Avatar -->
  <div class="pf-avatar-wrap">
    <div class="pf-avatar">
      <span id="pf-initials">AF</span>
      <div class="pf-avatar-online"></div>
    </div>
  </div>

  <div class="pf-divider"></div>

  <!-- Fields -->
  <div class="pf-fields">

    <!-- Full Name -->
    <div class="pf-field-group">
      <div class="pf-field-label">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/>
        </svg>
        Nama
      </div>
      <input type="text" class="pf-field-value" id="pf-name" value="Ahmad Farhan" readonly>
    </div>

    <!-- Age (display) -->
    <div class="pf-field-group">
      <div class="pf-field-label">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
          <line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
        </svg>
        Umur
      </div>
      <!-- Read view -->
      <div id="pf-age-display-wrap">
        <input type="text" class="pf-field-value" id="pf-age-display" value="21 tahun" readonly>
      </div>
      <!-- Edit view (date picker) -->
      <div class="pf-age-wrap" id="pf-age-date-wrap" style="display:none;">
        <input type="date" class="pf-field-value editable" id="pf-dob" value="2004-04-18">
        <div class="pf-cal-icon">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/>
            <line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
          </svg>
        </div>
      </div>
    </div>

  </div>

  <!-- Footer -->
  <div class="pf-footer">
    <button class="pf-edit-btn" id="pf-edit-btn" onclick="pfStartEdit()">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
        <path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/>
        <path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/>
      </svg>
      Edit Profile
    </button>
    <button class="pf-save-btn" id="pf-save-btn" onclick="pfSave()">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
        <polyline points="20 6 9 17 4 12"/>
      </svg>
      Simpan
    </button>
    <button class="pf-cancel-btn" id="pf-cancel-btn" onclick="pfCancel()">Batal</button>
  </div>

</div>

<!-- Toast -->
<div class="pf-toast" id="pf-toast"></div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
<script>
// ---- Chart Setup ----
const labels = [
  '03:02:08','03:02:41','03:03:17','03:03:52','03:04:29',
  '03:04:47','03:05:14','03:05:38','03:06:01','03:06:29'
];
const hrData  = [105, 110, 115, 120, 117, 113, 119, 122, 115, 117];
const spo2Data = [98.5, 98.2, 97.8, 97.5, 97.2, 97.0, 97.4, 97.1, 97.3, 97.0];

const ctx = document.getElementById('trendChart').getContext('2d');
const chart = new Chart(ctx, {
  type: 'line',
  data: {
    labels,
    datasets: [
      {
        label: 'Heart Rate (BPM)',
        data: hrData,
        borderColor: '#fb7185',
        backgroundColor: 'rgba(251,113,133,0.08)',
        borderWidth: 2,
        pointRadius: 5,
        pointBackgroundColor: '#fb7185',
        pointBorderColor: '#fff',
        pointBorderWidth: 2,
        tension: 0.4,
        fill: false,
        yAxisID: 'y'
      },
      {
        label: 'SpO₂ (%)',
        data: spo2Data,
        borderColor: '#60a5fa',
        backgroundColor: 'rgba(96,165,250,0.08)',
        borderWidth: 2,
        pointRadius: 5,
        pointBackgroundColor: '#60a5fa',
        pointBorderColor: '#fff',
        pointBorderWidth: 2,
        tension: 0.4,
        fill: false,
        yAxisID: 'y2'
      }
    ]
  },
  options: {
    responsive: true,
    maintainAspectRatio: false,
    interaction: { mode: 'index', intersect: false },
    plugins: {
      legend: { display: false },
      tooltip: {
        backgroundColor: '#1e293b',
        titleColor: '#f1f5f9',
        bodyColor: '#94a3b8',
        padding: 12,
        cornerRadius: 10
      }
    },
    scales: {
      x: {
        grid: { color: '#f1f5f9', lineWidth: 1 },
        ticks: { font: { family: 'DM Mono', size: 10 }, color: '#94a3b8', maxRotation: 0, autoSkip: true, maxTicksLimit: 8 },
        border: { display: false }
      },
      y: {
        position: 'left',
        min: 50, max: 200,
        grid: { color: '#f1f5f9' },
        ticks: { font: { family: 'DM Mono', size: 10 }, color: '#94a3b8', stepSize: 30 },
        border: { display: false }
      },
      y2: {
        position: 'right',
        min: 90, max: 100,
        grid: { drawOnChartArea: false },
        ticks: {
          font: { family: 'DM Mono', size: 10 }, color: '#94a3b8', stepSize: 2,
          callback: v => v + '%'
        },
        border: { display: false }
      }
    }
  }
});

// ---- Tab switching ----
document.querySelectorAll('.chart-tab').forEach((btn) => {
  btn.addEventListener('click', () => {
    document.querySelectorAll('.chart-tab').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');

    const showHR   = btn.id === 'tab-both' || btn.id === 'tab-hr';
    const showSpo2 = btn.id === 'tab-both' || btn.id === 'tab-spo2';

    // Toggle datasets
    chart.data.datasets[0].hidden = !showHR;
    chart.data.datasets[1].hidden = !showSpo2;

    // Toggle Y-axes: hide axis that has no visible dataset
    chart.options.scales.y.display  = showHR;
    chart.options.scales.y2.display = showSpo2;

    // Toggle legend items
    document.getElementById('legend-hr').style.display   = showHR   ? '' : 'none';
    document.getElementById('legend-spo2').style.display = showSpo2 ? '' : 'none';

    chart.update();
  });
});

// ---- Static sensor state (can be toggled to simulate) ----
// Set fingerDetected = false and signalGood = false to simulate abnormal
const fingerDetected = true;
const signalGood = true;

function updateSensorUI() {
  // Finger detection
  document.getElementById('finger-detected-svg').style.display  = fingerDetected ? '' : 'none';
  document.getElementById('finger-undetected-svg').style.display = fingerDetected ? 'none' : '';
  document.getElementById('finger-status-text').textContent = fingerDetected ? 'Jari Terdeteksi' : 'Jari Tidak Terdeteksi';
  const fingerBadge = document.getElementById('finger-badge');
  fingerBadge.className = 'sensor-state-badge ' + (fingerDetected ? 'detected' : 'undetected');
  document.getElementById('finger-badge-text').textContent = fingerDetected ? 'Terdeteksi' : 'Tidak Terdeteksi';
  document.getElementById('sensor-finger-icon').className = 'sensor-row-icon finger ' + (fingerDetected ? '' : 'bad');

  // Signal quality
  document.getElementById('signal-good-svg').style.display = signalGood ? '' : 'none';
  document.getElementById('signal-bad-svg').style.display  = signalGood ? 'none' : '';
  document.getElementById('signal-status-text').textContent = signalGood ? 'Sinyal Bagus' : 'Sinyal Buruk';
  const signalBadge = document.getElementById('signal-badge');
  signalBadge.className = 'sensor-state-badge ' + (signalGood ? 'good' : 'bad');
  document.getElementById('signal-badge-text').textContent = signalGood ? 'Bagus' : 'Buruk';
  document.getElementById('sensor-signal-icon').className = 'sensor-row-icon signal ' + (signalGood ? '' : 'bad');
}
updateSensorUI();

// ---- Condition card (static: normal) ----
// Change isNormal = false to simulate abnormal condition
const isNormal = true;

function updateConditionUI() {
  const card        = document.getElementById('condition-card');
  const iconNormal  = document.getElementById('condition-icon-normal');
  const iconAbnorm  = document.getElementById('condition-icon-abnormal');
  const iconWrap    = document.getElementById('condition-icon-wrap');
  const statusLabel = document.getElementById('condition-status-label');
  const statusSub   = document.getElementById('condition-status-sub');
  const warning     = document.getElementById('condition-warning-notice');
  const badge       = document.getElementById('condition-badge');
  const badgeText   = document.getElementById('condition-badge-text');

  if (isNormal) {
    iconNormal.style.display  = '';
    iconAbnorm.style.display  = 'none';
    iconWrap.className        = 'condition-icon-wrap normal';
    statusLabel.textContent   = 'Normal';
    statusLabel.className     = 'condition-status-label normal';
    statusSub.textContent     = 'Kondisi pasien baik dan stabil.';
    warning.style.display     = 'none';
    badge.className           = 'condition-badge normal';
    badgeText.textContent     = 'Normal';
    card.classList.remove('abnormal');
  } else {
    iconNormal.style.display  = 'none';
    iconAbnorm.style.display  = '';
    iconWrap.className        = 'condition-icon-wrap abnormal';
    statusLabel.textContent   = 'Tidak Normal';
    statusLabel.className     = 'condition-status-label abnormal';
    statusSub.textContent     = 'Kondisi pasien perlu perhatian.';
    warning.style.display     = 'flex';
    badge.className           = 'condition-badge abnormal';
    badgeText.textContent     = 'Tidak Normal';
    card.classList.add('abnormal');
  }
}
updateConditionUI();
</script>

<script>
// ===== PROFILE PANEL =====
const PF_CSRF = '{{ csrf_token() }}';

async function openProfilePanel() {
  document.getElementById('profilePanel').classList.add('open');
  document.getElementById('profileOverlay').classList.add('open');
  document.body.style.overflow = 'hidden';

  // Load fresh data from database every time panel opens
  try {
    const res  = await fetch('/profile', { headers: { 'Accept': 'application/json' } });
    const data = await res.json();
    if (data.success) {
      document.getElementById('pf-name').value = data.name || '';
      const initials = (data.name || 'U').split(' ').map(w => w[0]).join('').toUpperCase().slice(0, 2);
      document.getElementById('pf-initials').textContent = initials;
      if (data.dob) {
        document.getElementById('pf-dob').value = data.dob;
        document.getElementById('pf-age-display').value = pfCalcAge(data.dob) + ' tahun';
      } else {
        document.getElementById('pf-age-display').value = data.age ? data.age + ' tahun' : '—';
        document.getElementById('pf-dob').value = '';
      }
    }
  } catch (err) {
    console.error('Gagal load profile:', err);
  }
}

function closeProfilePanel() {
  document.getElementById('profilePanel').classList.remove('open');
  document.getElementById('profileOverlay').classList.remove('open');
  document.body.style.overflow = '';
  pfCancel();
}
document.addEventListener('keydown', function(e) {
  if (e.key === 'Escape') closeProfilePanel();
});

let pfOrigName = '', pfOrigDob = '';

function pfStartEdit() {
  pfOrigName = document.getElementById('pf-name').value;
  pfOrigDob  = document.getElementById('pf-dob').value;

  const nameEl = document.getElementById('pf-name');
  nameEl.removeAttribute('readonly');
  nameEl.classList.add('editable');
  nameEl.focus();

  document.getElementById('pf-age-display-wrap').style.display = 'none';
  document.getElementById('pf-age-date-wrap').style.display    = 'block';

  document.getElementById('pf-edit-btn').style.display   = 'none';
  document.getElementById('pf-save-btn').style.display   = 'flex';
  document.getElementById('pf-cancel-btn').style.display = 'block';
}

function pfCancel() {
  if (pfOrigName) document.getElementById('pf-name').value = pfOrigName;
  if (pfOrigDob)  document.getElementById('pf-dob').value  = pfOrigDob;

  const nameEl = document.getElementById('pf-name');
  nameEl.setAttribute('readonly', true);
  nameEl.classList.remove('editable');

  document.getElementById('pf-age-display-wrap').style.display = 'block';
  document.getElementById('pf-age-date-wrap').style.display    = 'none';

  document.getElementById('pf-edit-btn').style.display   = 'flex';
  document.getElementById('pf-save-btn').style.display   = 'none';
  document.getElementById('pf-cancel-btn').style.display = 'none';
}

async function pfSave() {
  const name = document.getElementById('pf-name').value.trim();
  const dob  = document.getElementById('pf-dob').value;
  if (!name) { pfShowToast('Nama tidak boleh kosong.'); return; }

  const saveBtn = document.getElementById('pf-save-btn');
  saveBtn.disabled = true;
  saveBtn.innerHTML = `<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4M4.93 19.07l2.83-2.83M16.24 7.76l2.83-2.83"/></svg> Menyimpan…`;

  try {
    const res  = await fetch('/profile', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': PF_CSRF, 'Accept': 'application/json' },
      body: JSON.stringify({ name, dob: dob || null }),
    });
    const data = await res.json();

    if (data.success) {
      document.getElementById('pf-name').value = data.name;
      const initials = data.name.split(' ').map(w => w[0]).join('').toUpperCase().slice(0, 2);
      document.getElementById('pf-initials').textContent = initials;
      if (data.age !== null && data.age !== undefined) {
        document.getElementById('pf-age-display').value = data.age + ' tahun';
      }

      const nameEl = document.getElementById('pf-name');
      nameEl.setAttribute('readonly', true);
      nameEl.classList.remove('editable');

      document.getElementById('pf-age-display-wrap').style.display = 'block';
      document.getElementById('pf-age-date-wrap').style.display    = 'none';
      document.getElementById('pf-edit-btn').style.display   = 'flex';
      document.getElementById('pf-save-btn').style.display   = 'none';
      document.getElementById('pf-cancel-btn').style.display = 'none';

      pfShowToast('Profile berhasil disimpan ✓');
    } else {
      pfShowToast(data.message || 'Gagal menyimpan.');
    }
  } catch (err) {
    pfShowToast('Terjadi kesalahan. Coba lagi.');
  } finally {
    saveBtn.disabled = false;
    saveBtn.innerHTML = `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg> Simpan`;
  }
}

function pfCalcAge(dob) {
  const today = new Date(), birth = new Date(dob);
  let age = today.getFullYear() - birth.getFullYear();
  const m = today.getMonth() - birth.getMonth();
  if (m < 0 || (m === 0 && today.getDate() < birth.getDate())) age--;
  return age;
}

function pfShowToast(msg) {
  const t = document.getElementById('pf-toast');
  t.textContent = msg;
  t.classList.add('show');
  setTimeout(() => t.classList.remove('show'), 2800);
}
</script>

<!-- ===== LOGOUT MODAL ===== -->
<style>
.logout-backdrop {
  position: fixed; inset: 0;
  background: rgba(26,32,44,0.45);
  backdrop-filter: blur(6px);
  -webkit-backdrop-filter: blur(6px);
  z-index: 500;
  display: flex; align-items: center; justify-content: center;
  opacity: 0; pointer-events: none;
  transition: opacity 0.28s ease;
}
.logout-backdrop.open { opacity: 1; pointer-events: all; }
.logout-modal {
  background: #fff;
  border-radius: 22px;
  padding: 36px 32px 28px;
  width: 100%; max-width: 380px; margin: 16px;
  box-shadow: 0 24px 80px rgba(0,0,0,0.18);
  transform: scale(0.93) translateY(12px);
  transition: transform 0.3s cubic-bezier(0.34,1.56,0.64,1), opacity 0.28s ease;
  opacity: 0;
  text-align: center;
}
.logout-backdrop.open .logout-modal { transform: scale(1) translateY(0); opacity: 1; }
.logout-modal-icon {
  width: 62px; height: 62px; border-radius: 50%;
  background: #fee2e2;
  display: flex; align-items: center; justify-content: center;
  margin: 0 auto 18px;
}
.logout-modal-icon svg { width: 28px; height: 28px; color: #ef4444; }
.logout-modal h3 { font-size: 18px; font-weight: 800; color: #1a202c; margin-bottom: 8px; letter-spacing: -0.3px; }
.logout-modal p { font-size: 13.5px; color: #94a3b8; line-height: 1.6; }
.logout-modal-actions { display: flex; gap: 10px; margin-top: 24px; }
.logout-cancel-btn {
  flex: 1; padding: 12px;
  border: 1.5px solid #e5eaf2; border-radius: 12px;
  background: transparent; color: #64748b;
  font-family: 'Inter', sans-serif; font-size: 13.5px; font-weight: 600;
  cursor: pointer; transition: background 0.15s, color 0.15s;
}
.logout-cancel-btn:hover { background: #f3f6fb; color: #1a202c; }
.logout-confirm-btn {
  flex: 1; padding: 12px;
  border: none; border-radius: 12px;
  background: linear-gradient(135deg, #ef4444, #dc2626);
  color: #fff;
  font-family: 'Inter', sans-serif; font-size: 13.5px; font-weight: 700;
  cursor: pointer; transition: opacity 0.18s, transform 0.12s;
  box-shadow: 0 4px 14px rgba(239,68,68,0.3);
}
.logout-confirm-btn:hover { opacity: 0.9; }
.logout-confirm-btn:active { transform: scale(0.97); }
</style>

<div class="logout-backdrop" id="logoutBackdrop">
  <div class="logout-modal" id="logoutModal">
    <div class="logout-modal-icon">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
        <polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/>
      </svg>
    </div>
    <h3>Keluar dari Rythmiq?</h3>
    <p>Kamu akan keluar dari sesi ini.<br>Yakin ingin melanjutkan?</p>
    <div class="logout-modal-actions">
      <button class="logout-cancel-btn" onclick="closeLogoutModal()">Batal</button>
      <button class="logout-confirm-btn" onclick="confirmLogout()">Ya, Keluar</button>
    </div>
  </div>
</div>

<script>
function openLogoutModal() {
  document.getElementById('logoutBackdrop').classList.add('open');
  document.body.style.overflow = 'hidden';
}
function closeLogoutModal() {
  document.getElementById('logoutBackdrop').classList.remove('open');
  document.body.style.overflow = '';
}
function confirmLogout() {
  window.location.href = '/login';
}
document.getElementById('logoutBackdrop').addEventListener('click', function(e) {
  if (e.target === this) closeLogoutModal();
});
document.addEventListener('keydown', function(e) {
  if (e.key === 'Escape') closeLogoutModal();
});
</script>
</body>
</html>
