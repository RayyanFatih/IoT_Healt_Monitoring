## 🚀 QUICK START GUIDE - Rhythmiq Dashboard

### Akses Langsung

**Dashboard sudah siap diakses di:**
- Home: `http://localhost:8000`
- Dashboard: `http://localhost:8000/dashboard`

### 🎯 Fitur-Fitur Utama

#### 1️⃣ **Profile (Kanan Atas)**
```
Klik pada profile icon (AF) di header kanan atas
→ Akan membuka modal Account Settings
→ Edit nama dan umur
→ Save untuk menyimpan perubahan
```

#### 2️⃣ **History (Sebelah Kiri)**
```
Di sidebar, ada daftar monitoring history
Klik pada setiap item untuk melihat detail
→ Akan membuka modal history detail
→ Tombol Download untuk export session
→ Tombol Back untuk kembali ke dashboard

Tombol "Download History" untuk download semua riwayat
```

#### 3️⃣ **Real-Time Chart**
```
Di bagian bawah dashboard
Ada chart yang menampilkan Heart Rate dan SpO₂
Gunakan tombol untuk switch view:
- Both: Tampilkan HR dan SpO₂
- Heart Rate: HR saja
- SpO₂: SpO₂ saja
```

#### 4️⃣ **Vital Signs Cards**
```
4 kartu besar di tengah yang menampilkan:
1. Heart Rate (BPM) - dengan progress circle
2. SpO₂ (%) - dengan progress circle
3. Overall Condition - status kesehatan
4. Sensor Status - status koneksi sensor
```

#### 5️⃣ **Stats Overview**
```
Di paling atas (di bawah banner biru):
- Average HR (session)
- Average SpO₂ (session)
- Readings Today
- Session Uptime
```

### 📁 File-File Utama

```
resources/views/
  ├── dashboard-main.php ← Dashboard frontend (GUNAKAN INI)
  └── dashboard.php ← Original (masih ada)

resources/css/
  └── dashboard.css ← CSS styling

routes/
  └── web.php ← Routes configured
```

### ⚙️ Setup Instructions

**Jika belum setup:**

```bash
# 1. Navigate ke folder project
cd c:\laragon\www\iot_dashboard

# 2. Install dependencies (jika belum)
composer install
npm install

# 3. Copy .env file (jika belum)
cp .env.example .env

# 4. Generate app key
php artisan key:generate

# 5. Start Laravel server
php artisan serve
```

**Akses di browser:**
```
http://localhost:8000
atau
http://127.0.0.1:8000
```

### 🎨 Struktur Layout

```
┌──────────────────────────────────────────────────────────────┐
│  HEADER: Logo | Time/Date | Status Badges | Profile          │
├──────────────────────────────────────────────────────────────┤
│  INFO BANNER: Patient ID | Update Interval | Sensor Status   │
├──────────────────────────────────────────────────────────────┤
│ SIDEBAR   │  MAIN CONTENT                                    │
│ History   │  ┌─ Stats Cards (4 items) ─────────────────┐    │
│ Items     │  │ HR | SpO2 | Today | Uptime               │    │
│           │  └──────────────────────────────────────────┘    │
│ [Download]│  ┌─ Live Vitals (4 cards) ─────────────────┐    │
│           │  │ HR Card | SpO2 | Condition | Sensor      │    │
│           │  └──────────────────────────────────────────┘    │
│           │  ┌─ Real-Time Chart ────────────────────────┐    │
│           │  │ Dual-axis chart (HR + SpO2)              │    │
│           │  └──────────────────────────────────────────┘    │
└──────────────────────────────────────────────────────────────┘
```

### 🔧 Troubleshooting

**Q: Dashboard tidak muncul?**
```
A: Pastikan sudah akses http://localhost:8000 atau /dashboard
   Server harus sudah running (php artisan serve)
```

**Q: Chart tidak muncul?**
```
A: Pastikan internet connection aktif (Chart.js dari CDN)
   Jika offline, download Chart.js dan host lokal
```

**Q: Modal tidak bisa dibuka?**
```
A: Cek browser console untuk error
   Pastikan JavaScript tidak disabled
```

**Q: Responsive layout tidak work?**
```
A: Coba resize browser atau buka di device lain
   Mobile view: max-width 768px
   Tablet view: max-width 1024px
```

### 📝 Mock Data

Saat ini semua data adalah **mock/demo data**:
- Chart menampilkan data random yang realistic
- History items adalah sample data
- Profile data: Ahmad Farhan, 21 tahun
- Patient ID: EXH-2026-01

### 🔗 Linked Resources

**External CDNs yang digunakan:**
- Font Awesome: `cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0`
- Chart.js: `cdn.jsdelivr.net/npm/chart.js`
- Google Fonts: `fonts.googleapis.com`

### ✅ Checklist Fitur

- [x] Header Navigation
- [x] Profile Modal (dengan edit)
- [x] History Sidebar
- [x] History Detail Modal
- [x] Download History
- [x] Stats Cards
- [x] Live Vitals Cards
- [x] Responsive Design
- [x] Real-Time Chart (Chart.js)
- [x] Modal Overlay Effects
- [x] Form Validation (basic)

### 🎓 Untuk Developer

**Struktur JavaScript:**
```javascript
// Update time every second
updateTime()
setInterval(updateTime, 1000)

// Profile modal functions
openProfileModal()
closeProfileModal()
toggleEditMode()
saveProfile()

// History modal functions
openHistoryDetail(element)
closeHistoryModal()
openDownloadHistory()

// Chart functions
initChart()
switchChart(type)
```

**CSS Grid/Flex:**
```css
.stats-row:         grid (auto-fit, minmax)
.vitals-grid:       grid (auto-fit, minmax)
.header-right:      flex (gap, items-center)
.modal-overlay:     flex (center, justify-end)
```

### 🎁 Bonus Features untuk Masa Depan

```
1. Dark mode toggle
2. Notifications system
3. Alerts untuk abnormal vitals
4. Session pausing/resuming
5. Multiple patient support
6. Export to PDF
7. Data analytics pagejQuery export as CSV
8. Push notifications
9. Mobile app
10. Telemedicine integration
```

---

**Happy Monitoring! 💓**

Pertanyaan? Lihat DASHBOARD_DOCS.md untuk dokumentasi lengkap.
