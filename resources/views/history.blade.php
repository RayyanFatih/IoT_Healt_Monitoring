<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>History — Rythmiq IoT Health Monitoring</title>
<meta name="description" content="Riwayat data sensor Heart Rate dan SpO₂ dari perangkat IoT Rythmiq.">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
<link rel="stylesheet" href="/css/history.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.8.2/jspdf.plugin.autotable.min.js"></script>
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
      <a href="/dashboard" class="nav-item" id="nav-dashboard">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/>
          <rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/>
        </svg>
        Dashboard
      </a>
      <a href="/history" class="nav-item active" id="nav-history">
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
      <h1 class="page-title">History</h1>
    </div>

    <!-- SUMMARY CARDS -->
    <div class="summary-row">
      <div class="summary-card">
        <div class="summary-card-icon red">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>
          </svg>
        </div>
        <div class="summary-card-label">Avg Heart Rate</div>
        <div class="summary-card-value" id="avg-hr">—</div>
        <div class="summary-card-unit">bpm</div>
      </div>

      <div class="summary-card">
        <div class="summary-card-icon blue">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M12 2.69l5.66 5.66a8 8 0 1 1-11.31 0z"/>
          </svg>
        </div>
        <div class="summary-card-label">Avg SpO<sub>2</sub></div>
        <div class="summary-card-value" id="avg-spo2">—</div>
        <div class="summary-card-unit">%</div>
      </div>

      <div class="summary-card">
        <div class="summary-card-icon green">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
            <polyline points="9 12 11 14 15 10"/>
          </svg>
        </div>
        <div class="summary-card-label">Normal Readings</div>
        <div class="summary-card-value" id="count-normal">—</div>
        <div class="summary-card-unit">records</div>
      </div>

      <div class="summary-card">
        <div class="summary-card-icon amber">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
            <line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>
          </svg>
        </div>
        <div class="summary-card-label">Abnormal Readings</div>
        <div class="summary-card-value" id="count-abnormal">—</div>
        <div class="summary-card-unit">records</div>
      </div>
    </div>

    <!-- HISTORY TABLE -->
    <div class="table-card">
      <div class="table-card-header">
        <span class="table-card-title">Riwayat Data Sensor</span>
        <div style="display:flex;gap:10px;align-items:center;flex-wrap:wrap;">
          <!-- Search -->
          <div class="search-wrap">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
            </svg>
            <input type="text" class="search-input" id="search-input" placeholder="Telusiri">
          </div>
          <!-- Filter -->
          <select class="filter-select" id="filter-condition">
            <option value="all">Semua Kondisi</option>
            <option value="normal">Normal</option>
            <option value="warning">Peringatan</option>
            <option value="danger">Bahaya</option>
          </select>
          <!-- Download PDF Button -->
          <button class="btn-download-pdf" id="btn-download-pdf" onclick="downloadPDF()">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" width="15" height="15">
              <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
              <polyline points="7 10 12 15 17 10"/>
              <line x1="12" y1="15" x2="12" y2="3"/>
            </svg>
            Download PDF
          </button>
        </div>
      </div>

      <table class="history-table" id="history-table">
        <thead>
          <tr>
            <th data-col="no">#</th>
            <th data-col="time" class="sorted">Waktu <span class="sort-icon">↑</span></th>
            <th data-col="hr">Heart Rate <span class="sort-icon">↕</span></th>
            <th data-col="spo2">SpO<sub>2</sub> <span class="sort-icon">↕</span></th>
            <th data-col="condition">Kondisi <span class="sort-icon">↕</span></th>
          </tr>
        </thead>
        <tbody id="table-body"></tbody>
      </table>

      <!-- Empty state -->
      <div class="empty-state" id="empty-state" style="display:none;">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
          <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
        </svg>
        <p>Tidak ada data yang cocok.</p>
      </div>

      <!-- Footer / Pagination -->
      <div class="table-footer">
        <span class="table-info" id="table-info">Menampilkan 0 data</span>
        <div class="pagination" id="pagination"></div>
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

    <!-- Age -->
    <div class="pf-field-group">
      <div class="pf-field-label">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/>
          <line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
        </svg>
        Umur
      </div>
      <div id="pf-age-display-wrap">
        <input type="text" class="pf-field-value" id="pf-age-display" value="21 tahun" readonly>
      </div>
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

<script>
// ===== PROFILE PANEL =====
function openProfilePanel() {
  document.getElementById('profilePanel').classList.add('open');
  document.getElementById('profileOverlay').classList.add('open');
  document.body.style.overflow = 'hidden';
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

function pfSave() {
  const name = document.getElementById('pf-name').value.trim();
  const dob  = document.getElementById('pf-dob').value;
  if (!name) { pfShowToast('Nama tidak boleh kosong.'); return; }
  if (dob) {
    const age = pfCalcAge(dob);
    document.getElementById('pf-age-display').value = age + ' tahun';
  }
  const initials = name.split(' ').map(w => w[0]).join('').toUpperCase().slice(0, 2);
  document.getElementById('pf-initials').textContent = initials;
  const nameEl = document.getElementById('pf-name');
  nameEl.setAttribute('readonly', true);
  nameEl.classList.remove('editable');
  document.getElementById('pf-age-display-wrap').style.display = 'block';
  document.getElementById('pf-age-date-wrap').style.display    = 'none';
  document.getElementById('pf-edit-btn').style.display   = 'flex';
  document.getElementById('pf-save-btn').style.display   = 'none';
  document.getElementById('pf-cancel-btn').style.display = 'none';
  pfShowToast('Profile berhasil disimpan ✓');
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

<script>
// ---- Sample Data ----
const allData = [
  { time: '2026-04-17 03:02:08', hr: 105, spo2: 98.5 },
  { time: '2026-04-17 03:02:41', hr: 110, spo2: 98.2 },
  { time: '2026-04-17 03:03:17', hr: 115, spo2: 97.8 },
  { time: '2026-04-17 03:03:52', hr: 120, spo2: 97.5 },
  { time: '2026-04-17 03:04:29', hr: 117, spo2: 97.2 },
  { time: '2026-04-17 03:04:47', hr: 113, spo2: 97.0 },
  { time: '2026-04-17 03:05:14', hr: 119, spo2: 97.4 },
  { time: '2026-04-17 03:05:38', hr: 122, spo2: 97.1 },
  { time: '2026-04-17 03:06:01', hr: 115, spo2: 97.3 },
  { time: '2026-04-17 03:06:29', hr: 117, spo2: 97.0 },
  { time: '2026-04-17 03:07:05', hr: 88,  spo2: 98.8 },
  { time: '2026-04-17 03:07:43', hr: 72,  spo2: 99.1 },
  { time: '2026-04-17 03:08:10', hr: 68,  spo2: 99.3 },
  { time: '2026-04-17 03:08:55', hr: 75,  spo2: 98.9 },
  { time: '2026-04-17 03:09:30', hr: 78,  spo2: 98.5 },
  { time: '2026-04-17 03:10:02', hr: 145, spo2: 96.2 },
  { time: '2026-04-17 03:10:44', hr: 152, spo2: 95.8 },
  { time: '2026-04-17 03:11:19', hr: 160, spo2: 94.5 },
  { time: '2026-04-17 03:11:55', hr: 135, spo2: 96.8 },
  { time: '2026-04-17 03:12:30', hr: 80,  spo2: 98.2 },
  { time: '2026-04-17 03:13:08', hr: 73,  spo2: 99.0 },
  { time: '2026-04-17 03:13:45', hr: 70,  spo2: 99.2 },
  { time: '2026-04-17 03:14:22', hr: 76,  spo2: 98.7 },
  { time: '2026-04-17 03:15:00', hr: 82,  spo2: 98.4 },
  { time: '2026-04-17 03:15:38', hr: 91,  spo2: 97.9 },
];

// ---- Classify condition ----
function getCondition(hr, spo2) {
  if (hr > 140 || hr < 50 || spo2 < 95) return 'danger';
  if (hr > 120 || hr < 60 || spo2 < 97) return 'warning';
  return 'normal';
}

function conditionLabel(c) {
  return { normal: 'Normal', warning: 'Peringatan', danger: 'Bahaya' }[c];
}

// ---- Summary Stats ----
function computeSummary(data) {
  if (!data.length) return;
  const avgHr   = (data.reduce((s, d) => s + d.hr, 0) / data.length).toFixed(0);
  const avgSpo2 = (data.reduce((s, d) => s + d.spo2, 0) / data.length).toFixed(1);
  const cNormal   = data.filter(d => getCondition(d.hr, d.spo2) === 'normal').length;
  const cAbnormal = data.filter(d => getCondition(d.hr, d.spo2) !== 'normal').length;

  document.getElementById('avg-hr').textContent      = avgHr;
  document.getElementById('avg-spo2').textContent     = avgSpo2;
  document.getElementById('count-normal').textContent   = cNormal;
  document.getElementById('count-abnormal').textContent = cAbnormal;
}
computeSummary(allData);

// ---- Table state ----
const PER_PAGE = 10;
let currentPage = 1;
let sortCol = 'time';
let sortDir = 'asc';
let filteredData = [...allData];

// ---- Filtering ----
function applyFilters() {
  const q     = document.getElementById('search-input').value.toLowerCase();
  const cond  = document.getElementById('filter-condition').value;

  filteredData = allData.filter(d => {
    const c = getCondition(d.hr, d.spo2);
    const matchQ    = d.time.toLowerCase().includes(q) || conditionLabel(c).toLowerCase().includes(q);
    const matchCond = cond === 'all' || c === cond;
    return matchQ && matchCond;
  });

  // Sort
  filteredData.sort((a, b) => {
    let va = a[sortCol], vb = b[sortCol];
    if (sortCol === 'condition') { va = getCondition(a.hr, a.spo2); vb = getCondition(b.hr, b.spo2); }
    if (va < vb) return sortDir === 'asc' ? -1 : 1;
    if (va > vb) return sortDir === 'asc' ? 1  : -1;
    return 0;
  });

  currentPage = 1;
  renderTable();
}

// ---- Render table ----
function renderTable() {
  const tbody = document.getElementById('table-body');
  const empty = document.getElementById('empty-state');
  const start = (currentPage - 1) * PER_PAGE;
  const slice = filteredData.slice(start, start + PER_PAGE);

  if (!filteredData.length) {
    tbody.innerHTML = '';
    empty.style.display = '';
  } else {
    empty.style.display = 'none';
    tbody.innerHTML = slice.map((d, i) => {
      const c     = getCondition(d.hr, d.spo2);
      const label = conditionLabel(c);
      return `
        <tr style="animation-delay:${i * 0.03}s">
          <td class="td-time">${start + i + 1}</td>
          <td class="td-time">${d.time}</td>
          <td class="td-number hr">${d.hr} <span style="font-size:11px;font-weight:400;color:var(--text-muted)">bpm</span></td>
          <td class="td-number spo2">${d.spo2} <span style="font-size:11px;font-weight:400;color:var(--text-muted)">%</span></td>
          <td>
            <span class="status-badge ${c}">
              <span class="badge-dot"></span>${label}
            </span>
          </td>
        </tr>`;
    }).join('');
  }

  renderInfo();
  renderPagination();
}

// ---- Info text ----
function renderInfo() {
  const start = (currentPage - 1) * PER_PAGE + 1;
  const end   = Math.min(currentPage * PER_PAGE, filteredData.length);
  const info  = filteredData.length
    ? `Menampilkan ${start}–${end} dari ${filteredData.length} data`
    : 'Tidak ada data';
  document.getElementById('table-info').textContent = info;
}

// ---- Pagination ----
function renderPagination() {
  const totalPages = Math.max(1, Math.ceil(filteredData.length / PER_PAGE));
  const pag = document.getElementById('pagination');
  let html = '';

  html += `<button class="page-btn" id="pg-prev" ${currentPage === 1 ? 'disabled' : ''} onclick="goPage(${currentPage - 1})">
    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
  </button>`;

  const range = pageRange(currentPage, totalPages);
  range.forEach(p => {
    if (p === '…') {
      html += `<button class="page-btn" disabled style="border:none;background:none;color:var(--text-muted)">…</button>`;
    } else {
      html += `<button class="page-btn ${p === currentPage ? 'active' : ''}" onclick="goPage(${p})">${p}</button>`;
    }
  });

  html += `<button class="page-btn" id="pg-next" ${currentPage === totalPages ? 'disabled' : ''} onclick="goPage(${currentPage + 1})">
    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
  </button>`;

  pag.innerHTML = html;
}

function pageRange(cur, total) {
  if (total <= 7) return Array.from({length: total}, (_, i) => i + 1);
  if (cur <= 4) return [1,2,3,4,5,'…',total];
  if (cur >= total - 3) return [1,'…',total-4,total-3,total-2,total-1,total];
  return [1,'…',cur-1,cur,cur+1,'…',total];
}

function goPage(p) {
  const total = Math.ceil(filteredData.length / PER_PAGE);
  if (p < 1 || p > total) return;
  currentPage = p;
  renderTable();
}

// ---- Sorting ----
document.querySelectorAll('.history-table thead th[data-col]').forEach(th => {
  th.addEventListener('click', () => {
    const col = th.dataset.col;
    if (col === 'no') return;
    if (sortCol === col) {
      sortDir = sortDir === 'asc' ? 'desc' : 'asc';
    } else {
      sortCol = col;
      sortDir = 'asc';
    }
    document.querySelectorAll('.history-table thead th').forEach(h => {
      h.classList.remove('sorted');
      const icon = h.querySelector('.sort-icon');
      if (icon) icon.textContent = '↕';
    });
    th.classList.add('sorted');
    const icon = th.querySelector('.sort-icon');
    if (icon) icon.textContent = sortDir === 'asc' ? '↑' : '↓';
    applyFilters();
  });
});

// ---- Events ----
document.getElementById('search-input').addEventListener('input', applyFilters);
document.getElementById('filter-condition').addEventListener('change', applyFilters);

// ---- Init ----
applyFilters();

// ---- Download PDF (10 data terbaru) ----
function downloadPDF() {
  const { jsPDF } = window.jspdf;
  const doc = new jsPDF({ unit: 'mm', format: 'a4' });

  // Ambil 10 data terbaru (sort by time desc, ambil 10 pertama)
  const latest10 = [...allData]
    .sort((a, b) => b.time.localeCompare(a.time))
    .slice(0, 10);

  // Hitung ringkasan
  const avgHr   = (latest10.reduce((s, d) => s + d.hr,   0) / latest10.length).toFixed(2);
  const avgSpo2 = (latest10.reduce((s, d) => s + d.spo2, 0) / latest10.length).toFixed(2);
  const allNormal = latest10.every(d => getCondition(d.hr, d.spo2) === 'normal');
  const statusKesehatan = allNormal ? 'Normal' : 'Tidak Normal';

  // Tanggal & waktu generate
  const now  = new Date();
  const tgl  = String(now.getDate()).padStart(2,'0') + '-' +
               String(now.getMonth()+1).padStart(2,'0') + '-' + now.getFullYear();
  const jam  = String(now.getHours()).padStart(2,'0') + ':' +
               String(now.getMinutes()).padStart(2,'0') + ':' +
               String(now.getSeconds()).padStart(2,'0');

  const margin = 20;
  let y = 20;

  // ---- Judul ----
  doc.setFont('helvetica', 'bold');
  doc.setFontSize(16);
  doc.text('LAPORAN MONITORING KESEHATAN', doc.internal.pageSize.getWidth() / 2, y, { align: 'center' });
  y += 10;

  // ---- Sistem ----
  doc.setFont('helvetica', 'normal');
  doc.setFontSize(11);
  doc.text('Sistem Rythmiq (IoT Health Monitoring)', margin, y);
  y += 10;

  // ---- Tanggal & Waktu Generate ----
  doc.text('Tanggal: ' + tgl, margin, y);
  y += 6;
  doc.text('Waktu Generate: ' + jam, margin, y);
  y += 14;

  // ---- Ringkasan Data ----
  doc.setFont('helvetica', 'bold');
  doc.setFontSize(13);
  doc.text('Ringkasan Data:', margin, y);
  y += 8;

  doc.setFont('helvetica', 'normal');
  doc.setFontSize(11);
  doc.text('Rata-rata BPM: ' + avgHr, margin, y);   y += 6;
  doc.text('Rata-rata SpO2: ' + avgSpo2, margin, y); y += 6;
  doc.text('Status Kesehatan: ' + statusKesehatan, margin, y); y += 14;

  // ---- Data Monitoring ----
  doc.setFont('helvetica', 'bold');
  doc.setFontSize(13);
  doc.text('Data Monitoring:', margin, y);
  y += 6;

  // Tabel dengan autoTable
  const tableRows = latest10.map(d => [
    d.time,
    d.hr,
    d.spo2
  ]);

  doc.autoTable({
    startY: y,
    head: [['Waktu', 'BPM', 'SpO2']],
    body: tableRows,
    margin: { left: margin, right: margin },
    tableWidth: 'auto',
    styles: {
      font: 'helvetica',
      fontSize: 10,
      cellPadding: 4,
      halign: 'center',
      valign: 'middle',
    },
    headStyles: {
      fillColor: [80, 80, 80],
      textColor: 255,
      fontStyle: 'normal',
      halign: 'center',
    },
    columnStyles: {
      0: { halign: 'center', cellWidth: 70 },
      1: { halign: 'center', cellWidth: 30 },
      2: { halign: 'center', cellWidth: 30 },
    },
    alternateRowStyles: { fillColor: [255, 255, 255] },
    tableLineColor: [180, 180, 180],
    tableLineWidth: 0.3,
  });

  // ---- Footer ----
  const finalY = doc.lastAutoTable.finalY + 12;
  doc.setFont('helvetica', 'normal');
  doc.setFontSize(10);
  doc.text('Data diambil dari sistem IoT Rythmiq secara real-time.', margin, finalY);

  // Simpan PDF
  doc.save('Laporan_Monitoring_Rythmiq_' + tgl + '.pdf');
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
