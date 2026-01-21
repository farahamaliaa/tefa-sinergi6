<h1 align="center">TEFA - Teaching Factory SMK6</h1>

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel">
  <img src="https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP">
  <img src="https://img.shields.io/badge/MySQL-005C84?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL">
</p>


<p align="center">
  <strong>Sistem Informasi Manajemen Sekolah Terpadu</strong><br>
  <em>Solusi digital untuk pengelolaan sekolah modern yang efisien dan terintegrasi</em>
</p>

---

## Tentang TEFA

**TEFA (Teaching Factory)** adalah platform sistem informasi manajemen sekolah yang dikembangkan untuk **SMK Negeri 6** dengan pendekatan *Learning by Doing*. Proyek ini merupakan implementasi nyata dari konsep Teaching Factory, di mana siswa belajar sambil mengerjakan proyek yang bermanfaat untuk kebutuhan sekolah.

> *"Belajar sambil berkarya, menciptakan solusi nyata untuk sekolah"*

---

## Fitur Utama

### Manajemen Orang Tua & Siswa
- Pengelolaan data orang tua dan siswa secara terintegrasi
- Hubungan relasi parent-student yang fleksibel
- Monitoring perkembangan siswa oleh orang tua

### Manajemen Ekstrakurikuler
- Dashboard khusus untuk pembina ekstrakurikuler
- Pencatatan kehadiran anggota eskul
- Jurnal kegiatan ekstrakurikuler
- Pengajuan izin siswa

### Dashboard Multi-Role
- **Admin** - Pengelolaan seluruh sistem
- **Guru** - Manajemen kelas dan pembelajaran
- **Orang Tua** - Monitoring anak
- **Ekstrakurikuler** - Pengelolaan kegiatan eskul

### Fitur Tambahan
- Sistem absensi digital
- Manajemen jurnal kegiatan
- Laporan dan statistik real-time
- UI/UX modern dan responsif

---

## Tech Stack

| Kategori | Teknologi |
|----------|-----------|
| **Backend** | Laravel 10+ |
| **Frontend** | Blade, Bootstrap |
| **Database** | MySQL |
| **API** | RESTful API |

---

## Instalasi

```bash
# Clone repository
git clone https://github.com/farahamaliaa/tefa-sinergi6.git

# Masuk ke direktori proyek
cd tefa-sinergi6

# Install dependencies
composer install
npm install

# Setup environment
cp .env.example .env
php artisan key:generate

# Migrasi database
php artisan migrate --seed

# Jalankan server
php artisan serve
```

---

## Lisensi

Proyek ini dikembangkan untuk keperluan internal SMK Negeri 6.

---

<p align="center">
  <strong>Dibuat oleh Tim TEFA SMK Negeri 6</strong>
</p>
