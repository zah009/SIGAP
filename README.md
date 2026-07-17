# SIGAP — Sistem Informasi Gangguan & Aduan Pengguna

Aplikasi pencatatan dan pengelolaan tiket gangguan IT internal, dibangun sebagai portofolio pribadi dengan CodeIgniter 4. Menggantikan pelaporan masalah IT yang sebelumnya tidak terstruktur (lisan/chat pribadi) menjadi sistem terpusat dengan status yang bisa dilacak dan riwayat penanganan yang terdokumentasi.

## Latar Belakang

Departemen IT di banyak perusahaan masih menerima laporan gangguan secara tidak terstruktur, sehingga sulit dilacak statusnya dan tidak ada dokumentasi riwayat penyelesaian. SIGAP dirancang untuk menjawab masalah ini dengan alur kerja yang jelas: user melapor → admin menangani → riwayat tercatat.

## Fitur

**Autentikasi & Akses**
- Autentikasi berbasis session dengan role `user` dan `admin`
- Proteksi akses berbasis role lewat Filter (route admin tidak bisa diakses user biasa maupun yang belum login, teruji di dua skenario: belum login dan login-tapi-salah-role)
- Proteksi CSRF aktif di seluruh form
- Rate limiting pada percobaan login (mencegah brute-force), dua lapis:
  - Per-IP: maksimal 20 percobaan login/menit dari satu alamat IP (mencegah scanning banyak akun sekaligus)
  - Per-akun: maksimal 2 percobaan/menit ke satu username spesifik dari IP yang sama (mencegah brute-force ke satu akun)
- Reset password mandiri lewat email — user klik "lupa password", menerima tautan berisi token acak (di-hash SHA-256, berlaku 1 jam) untuk membuat password baru. Pesan konfirmasi disamarkan (sama baik email terdaftar atau tidak) untuk mencegah user enumeration

**Untuk User**
- Membuat laporan gangguan (kategori, judul, deskripsi) lengkap dengan lampiran file (JPG/PNG/PDF, maks 2MB)
- Memantau status laporan sendiri lewat dashboard dan riwayat laporan
- Notifikasi email otomatis saat status laporan diperbarui admin

**Untuk Admin**
- Melihat seluruh tiket dari semua user, dengan ringkasan jumlah per status
- Mengubah status tiket (`open` → `in_progress` → `closed`), **wajib disertai catatan penanganan** — tersimpan sebagai riwayat terpisah per tiket (audit trail)
- Mengelola akun user (tambah user baru)
- Admin sengaja **tidak bisa** membuat laporan untuk dirinya sendiri — keputusan desain, karena tiket merepresentasikan kesenjangan pengetahuan teknis antara pelapor dan penyelesai

**Keamanan**
- Password di-hash dengan bcrypt (`password_hash`)
- Validasi upload file: pengecekan MIME type asli (bukan sekadar ekstensi), nama file diacak (`getRandomName()`) untuk mencegah path traversal dan penimpaan file, serta `.htaccess` di folder upload untuk mencegah eksekusi file selain gambar/PDF
- Query database via Query Builder CodeIgniter (aman dari SQL injection)

## Tech Stack

- **Backend:** PHP 8.2, CodeIgniter 4
- **Database:** MySQL/MariaDB (XAMPP untuk development)
- **Frontend:** HTML, Tailwind CSS v4 (standalone CLI)
- **Email:** CodeIgniter Email Service (SMTP, testing via Mailtrap)
- **Deployment:** AWS EC2

## Struktur Database

4 tabel utama: `users` (dengan kolom `email` untuk notifikasi), `tickets`, `ticket_logs`. Relasi 1:n dari `users` ke `tickets`, dan 1:n dari `tickets` ke `ticket_logs`. `ticket_logs` sengaja dipisah dari `tickets` agar riwayat penanganan tetap tersimpan meski status akhir tiket berubah.

Detail rancangan awal (requirement analysis, ERD, flowchart, rencana pengujian) ada di [dokumen rancangan sistem](./docs/SIGAP_Dokumen_Rancangan.pdf).

## Instalasi Lokal

**Prasyarat:** PHP 8.2+, Composer, MySQL (disarankan lewat XAMPP), extension `intl` dan `zip` aktif.

```bash
git clone https://github.com/zah009/SIGAP.git
cd SIGAP
composer install
copy env .env
```

Buat database `sigap_db` lewat phpMyAdmin, lalu edit `.env`, sesuaikan bagian berikut:
database.default.hostname = localhost
database.default.database = sigap_db
database.default.username = root
database.default.password =
database.default.DBDriver = MySQLi

**(Opsional)** Untuk fitur notifikasi email, tambahkan konfigurasi SMTP (contoh pakai [Mailtrap](https://mailtrap.io) untuk testing):
email.protocol = smtp
email.SMTPHost = sandbox.smtp.mailtrap.io
email.SMTPUser = [username]
email.SMTPPass = [password]
email.SMTPPort = 2525
email.SMTPCrypto = tls

Jalankan migration dan seeder:

```bash
php spark migrate
php spark db:seed UserSeeder
php spark db:seed RegularUserSeeder
```

Jalankan server:

```bash
php spark serve
```

Akses di `http://localhost:8080`.

## Kredensial Testing

| Role  | Username  | Password |
| ----- | --------- | -------- |
| Admin | testadmin | test123  |
| User  | user1     | user123  |

## Status Pengembangan

Seluruh fitur yang direncanakan sudah selesai diimplementasikan:

- [x] Styling dengan Tailwind CSS
- [x] Notifikasi email saat status tiket berubah
- [x] Upload lampiran file pada tiket
- [x] Manajemen user oleh admin
- [x] Deployment ke AWS EC2
- [x] Rate limiting pada percobaan login (mencegah brute-force)
- [x] Reset password lewat email

## Lisensi

MIT License — lihat [LICENSE](./LICENSE).