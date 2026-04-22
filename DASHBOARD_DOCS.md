# Rhythmiq IoT Heart Rate & Oxygen Monitoring Dashboard

Dashboard web monitoring detak jantung dan kadar oksigen secara real-time yang terhubung dengan alat IoT.

## 🚀 Status Saat Ini

✅ **Frontend Dashboard - SELESAI (Statis)**

## 📋 Fitur yang Sudah Diimplementasikan

### 1. **Header Navigation**
- Logo Rhythmiq dengan ikon brand
- Jam dan tanggal real-time
- Status badge (Warning & Live indicator)
- User profile dengan nama dan umur
- Akses ke modal profil

### 2. **Info Banner Biru**
- Informasi singkat pasien
- Patient ID
- Update interval
- Sensor status

### 3. **Sidebar History** (Sebelah Kiri)
- Daftar riwayat monitoring sessions
- Informasi waktu dan vital signs preview
- Tombol Download History untuk mengunduh semua data riwayat

### 4. **Stats Cards** (Atas)
- Average Heart Rate (Session)
- Average SpO₂ (Session)
- Total Readings Today
- Session Uptime

### 5. **Live Vitals Cards** (4 Kartu)
- **Heart Rate**: Menampilkan BPM dengan circular progress indicator
- **SpO₂**: Menampilkan persentase O2 dengan circular progress
- **Overall Condition**: Status kesehatan dengan icon shield
- **Sensor Status**: Status sensor dengan indikator koneksi

### 6. **Real-Time Monitoring Chart**
- Dual-axis chart menampilkan Heart Rate dan SpO₂
- Toggle buttons untuk switch antara:
  - Both (HR + SpO₂)
  - Heart Rate only
  - SpO₂ only
- Data dengan trend lines bergradien

### 7. **Profile Modal** (Kanan Atas - Klik Profile Icon)
- Menampilkan avatar user (AF)
- Form untuk menampilkan/edit:
  - Full Name
  - Age
  - Patient ID (read-only)
- Tombol Edit Profile yang mengaktifkan input
- Tombol Save untuk menyimpan perubahan

### 8. **History Modal** (Klik History Item di Sidebar)
- Detail monitoring session
- Information:
  - Tanggal & waktu session
  - Average HR
  - Average SpO₂
  - Durasi session
  - Total readings
  - Status kondisi
- Tombol Download untuk export single session
- Tombol Back untuk kembali

## 📦 File-File yang Dibuat

```
resources/
├── views/
│   ├── dashboard-main.php          # Dashboard HTML lengkap
│   └── dashboard.php                # Original (masih ada)
├── css/
│   └── dashboard.css                # Styling dashboard (opsional)
└── js/
    └── app.js                       # Bootstrap file
routes/
└── web.php                          # Routes configuration
```

## 🎨 Desain & Styling

- **Warna Primary**: Blue (#0052CC)
- **Warna Warning**: Orange (#FFA500)
- **Warna Alert**: Red (#FF4444)
- **Warna Success**: Green (#00CC66)
- **Font**: Instrument Sans (custom font)
- **Icons**: Font Awesome 6.4.0
- **Chart**: Chart.js

## 🛠️ Teknologi

- Laravel 11 ✅
- HTML5 ✅
- CSS3 (Grid, Flexbox, Custom Properties) ✅
- JavaScript (Vanilla, No Framework) ✅
- Chart.js (Real-time charts) ✅
- Font Awesome Icons ✅
- Google Fonts ✅

## ⚡ Fitur Interaktif

### 1. **Click Profile Icon**
- Membuka modal profil di sebelah kanan
- Bisa melihat data user
- Bisa edit nama dan umur
- Save button untuk menyimpan

### 2. **Click History Item**
- Membuka modal history detail
- Menampilkan informasi lengkap session
- Download button untuk export session data

### 3. **Download History Button**
- Membuka file download untuk semua history

### 4. **Chart Controls**
- Toggle antara Both/HR/SpO₂
- Hover untuk melihat detail nilai

### 5. **Modal Overlay**
- Click diluar modal untuk close
- Close button (X) di header modal

## 🚀 Cara Menjalankan

1. **Setup Laravel**
   ```bash
   cd c:\laragon\www\iot_dashboard
   composer install
   ```

2. **Jalankan Server**
   ```bash
   php artisan serve
   ```

3. **Akses Dashboard**
   - Buka browser: `http://localhost:8000`
   atau
   - Langsung ke dashboard: `http://localhost:8000/dashboard`

## 📱 Responsive Design

- ✅ Desktop (Penuh dengan sidebar)
- ✅ Tablet (Sidebar tersembunyi, grid 2 kolom)
- ✅ Mobile (Single column layout)

## 🔄 Untuk Implementasi Berikutnya

### Yang Perlu Ditambahkan:

1. **Koneksi REST API**
   - Connect ke IoT device API
   - Real-time data fetching

2. **Database Integration**
   - Simpan riwayat monitoring
   - User profile management
   - History data persistence

3. **Backend API Endpoints**
   ```
   GET  /api/vitals/current       - Get real-time vitals
   GET  /api/vitals/history       - Get history data
   POST /api/profile/update       - Update user profile
   GET  /api/profile              - Get user profile
   POST /api/history/export       - Export history
   ```

4. **WebSocket untuk Real-Time**
   - Live update data setiap 3 detik (sesuai setting)
   - Automatic refresh chart

5. **Authentication**
   - Login system
   - Session management
   - User authorization

6. **Error Handling**
   - API error display
   - Connection failure handling
   - Offline mode

## 📊 Data Structure (Mock)

```javascript
{
  patient: {
    id: "EXH-2026-01",
    name: "Ahmad Farhan",
    age: 21
  },
  currentVitals: {
    heartRate: 108,
    spo2: 93,
    timestamp: "2026-04-14T13:43:03Z"
  },
  history: [
    {
      id: 1,
      name: "Morning Check-up",
      date: "2026-04-14T08:00:00Z",
      avgHeartRate: 75,
      avgSpo2: 97,
      duration: 45,
      readings: 1350
    }
  ]
}
```

## 🎯 Next Steps

1. Integrasikan REST API untuk IoT device
2. Setup database untuk menyimpan data
3. Implementasi WebSocket untuk real-time updates
4. Tambah authentication system
5. Deploy ke production

## 📝 Catatan

- Dashboard saat ini menggunakan **mock data statis**
- Data di chart di-generate secara random untuk demo
- Semua fungsi interaktif sudah bekerja
- Siap untuk integrasi dengan backend real API

---

**Version**: 1.0 - Static Frontend
**Last Updated**: 2026-04-14
