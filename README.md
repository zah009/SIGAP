# SIGAP — Sistem Informasi Gangguan & Aduan Pengguna

Aplikasi pencatatan dan pengelolaan tiket gangguan IT internal, dibangun sebagai portofolio pribadi dengan CodeIgniter 4. Menggantikan pelaporan masalah IT yang sebelumnya tidak terstruktur (lisan/chat pribadi) menjadi sistem terpusat dengan status yang bisa dilacak dan riwayat penanganan yang terdokumentasi.

## Latar Belakang

Departemen IT di banyak perusahaan masih menerima laporan gangguan secara tidak terstruktur, sehingga sulit dilacak statusnya dan tidak ada dokumentasi riwayat penyelesaian. SIGAP dirancang untuk menjawab masalah ini dengan alur kerja yang jelas: user melapor → admin menangani → riwayat tercatat.

## Fitur

- Autentikasi berbasis session dengan role `user` dan `admin`
- User dapat membuat laporan gangguan (kategori, judul, deskripsi) dan memantau statusnya
- Admin dapat melihat seluruh tiket, mengubah status (`open` → `in_progress` → `closed`)
- Setiap perubahan status **wajib disertai catatan penanganan**, tersimpan sebagai riwayat terpisah per tiket
- Proteksi akses berbasis role lewat Filter (route admin tidak bisa diakses user biasa maupun yang belum login)

## Tech Stack

- **Backend:** PHP 8.2, CodeIgniter 4
- **Database:** MySQL/MariaDB (XAMPP untuk development)
- **Frontend:** HTML, (Tailwind CSS — dalam pengembangan)

## Struktur Database

3 tabel utama: `users`, `tickets`, `ticket_logs`. Relasi 1:n dari `users` ke `tickets`, dan 1:n dari `tickets` ke `ticket_logs`. `ticket_logs` sengaja dipisah dari `tickets` agar riwayat penanganan tetap tersimpan meski status akhir tiket berubah.

Detail rancangan (requirement analysis, ERD, flowchart, rencana pengujian) ada di [dokumen rancangan sistem](./docs/SIGAP_Dokumen_Rancangan.pdf).

## Instalasi Lokal

**Prasyarat:** PHP 8.2+, Composer, MySQL (disarankan lewat XAMPP), extension `intl` dan `zip` aktif.

```bash
git clone https://github.com/zah009/SIGAP.git
cd SIGAP
composer install
copy env .env
```

Edit `.env`, sesuaikan bagian database:
