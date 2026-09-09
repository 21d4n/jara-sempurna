# Jara - An Advanced To-Do List

## 1. Ringkasan Produk

Jara adalah aplikasi web untuk mengelola tugas pribadi maupun tugas tim. Pengguna dapat membuat project, menyusun task, menetapkan prioritas dan tenggat waktu, menugaskan task kepada beberapa anggota, memantau progress, dan berdiskusi melalui komentar.

Administrator bertanggung jawab mengelola akun pengguna dalam sistem.

## 2. Tujuan

- Menyediakan pengelolaan tugas pribadi dan kolaboratif dalam satu aplikasi.
- Membantu pengguna mengelompokkan task berdasarkan project atau daftar kerja.
- Membuat status pengerjaan dan progress project mudah dipantau.
- Menyediakan kontrol akun yang terpusat melalui administrator.
- Menyimpan komentar dan riwayat aktivitas sebagai konteks pekerjaan.

## 3. Aktor dan Hak Akses

### Administrator

- Login ke aplikasi.
- Menambah akun user.
- Menghapus akun user.
- Melihat daftar akun user.
- Mengelola role akun bila dibutuhkan oleh modul administrasi.

### Owner Project

- Membuat project.
- Mengubah informasi project.
- Menghapus project.
- Menambahkan user terdaftar ke project berdasarkan email.
- Menghapus member dari project.
- Membuat, mengubah, dan menghapus task dalam project.
- Menugaskan task kepada satu atau beberapa user yang memiliki akses ke project.
- Melihat progress project dan activity log.

### Member Project

- Melihat project tempat user menjadi member.
- Melihat task dalam project.
- Mengubah status task sesuai izin fitur.
- Mengelola task yang dapat diakses.
- Menambahkan komentar pada task.
- Melihat activity log project.

## 4. Persyaratan Fungsional

### FR-01 Autentikasi

- User dapat login dan logout.
- Fitur reset password, verifikasi email, 2FA, dan passkey mengikuti konfigurasi Fortify yang sudah tersedia.
- Registrasi publik dinonaktifkan.
- Akun baru hanya dapat dibuat oleh administrator.

### FR-02 Manajemen Akun

- Administrator dapat membuat akun dengan nama, email, password, dan role.
- Email user harus unik.
- Administrator dapat menghapus akun user.
- User yang masih menjadi owner project tidak dapat dihapus sebelum project dipindahkan ke owner lain.
- Penghapusan user menghapus membership dan assignment task miliknya.
- Komentar dan activity log yang dibuat user tetap tersimpan dengan identitas user yang sudah tidak tersedia.

### FR-03 Manajemen Project

- User dapat memiliki lebih dari satu project.
- Project memiliki satu owner.
- Project memiliki nama dan deskripsi opsional.
- Owner dapat memperbarui dan menghapus project.
- Penghapusan project menghapus task, membership, komentar, dan activity log yang terkait.

### FR-04 Kolaborasi Project

- Owner dapat menambahkan user yang sudah terdaftar dengan mencari email.
- User yang sama tidak dapat ditambahkan dua kali ke project.
- Owner dapat menghapus member dari project.
- User hanya dapat ditugaskan ke task jika memiliki akses ke project.
- Owner tetap memiliki akses penuh walaupun tidak tercatat sebagai member biasa.

### FR-05 Manajemen Task

- Task harus berada di dalam satu project.
- Task memiliki judul wajib dan deskripsi opsional.
- Task memiliki status `todo`, `in_progress`, atau `done`.
- Task memiliki prioritas `low`, `medium`, `high`, atau `urgent`.
- Task dapat memiliki tenggat waktu opsional.
- Task dapat ditugaskan kepada beberapa user.
- Task menyimpan user pembuat dan waktu selesai.
- Saat task berstatus `done`, `completed_at` diisi.
- Saat task dikembalikan ke status selain `done`, `completed_at` dikosongkan.

### FR-06 Progress Project

Progress dihitung otomatis dengan rumus:

```text
jumlah task berstatus done / jumlah seluruh task * 100
```

Project tanpa task memiliki progress 0 persen. Tidak ada persentase progress manual yang disimpan di database.

### FR-07 Komentar

- User yang memiliki akses ke project dapat menambahkan komentar pada task.
- Komentar terhubung ke task dan user pembuat.
- Komentar tetap tersimpan ketika akun pembuat dihapus.

### FR-08 Activity Log

- Sistem menyimpan aktivitas penting project, seperti pembuatan, perubahan, penyelesaian task, perubahan member, dan komentar.
- Setiap activity log memiliki project, action, user pemicu opsional, subject opsional, metadata opsional, dan timestamp.
- Activity log tetap tersimpan ketika user pemicu dihapus.

## 5. Status dan Prioritas Task

### Status

- `todo`: task belum dikerjakan.
- `in_progress`: task sedang dikerjakan.
- `done`: task telah selesai.

### Prioritas

- `low`: prioritas rendah.
- `medium`: prioritas normal.
- `high`: perlu segera dikerjakan.
- `urgent`: harus diprioritaskan.

## 6. Model Data

### users

Menyimpan akun dengan role `admin` atau `user`.

### projects

Menyimpan project, owner, nama, dan deskripsi.

### project_user

Pivot antara project dan user untuk membership kolaborasi.

### tasks

Menyimpan task, project, pembuat, judul, deskripsi, status, prioritas, tenggat waktu, dan waktu selesai.

### task_user

Pivot antara task dan user untuk assignment beberapa user.

### comments

Menyimpan komentar task dan user pembuatnya.

### activity_logs

Menyimpan riwayat aktivitas project dengan subject polymorphic dan metadata JSON.

## 7. Aturan Penghapusan Data

- Owner project tidak dapat dihapus sebelum ownership dipindahkan.
- Menghapus project menghapus task, membership, komentar, dan activity log terkait.
- Menghapus user menghapus membership project.
- Menghapus user menghapus assignment task.
- `created_by_id` pada task menjadi null jika pembuat task dihapus.
- `user_id` pada komentar dan activity log menjadi null jika user dihapus.

## 8. Persyaratan Non-Fungsional

- Database utama menggunakan MySQL.
- Aplikasi harus dapat diakses melalui jaringan lokal sesuai `APP_URL` dan konfigurasi host server.
- Semua endpoint yang mengubah data harus memiliki autentikasi, authorization, validasi, dan proteksi CSRF.
- Query daftar project dan task harus menggunakan eager loading untuk mencegah N+1 query.
- Antarmuka harus dapat digunakan pada desktop dan perangkat mobile.
- Password tidak boleh ditampilkan atau disimpan dalam bentuk plaintext oleh aplikasi.

## 9. Ruang Lingkup MVP

- Autentikasi user.
- Manajemen akun oleh admin.
- CRUD project oleh owner.
- Pengelolaan member project.
- CRUD task.
- Assignment task ke beberapa user.
- Status, prioritas, dan tenggat waktu task.
- Perhitungan progress otomatis.
- Komentar task.
- Activity log project.

## 10. Di Luar Scope MVP

- Undangan user melalui email.
- Notifikasi real-time.
- Lampiran file pada task.
- Task berulang.
- Kalender dan sinkronisasi eksternal.
- Sistem multi-tenant organisasi.
- Role project selain owner dan member.

## 11. Kriteria Penerimaan MVP

- User tanpa role admin tidak dapat membuat akun baru.
- Admin dapat membuat akun user dengan email unik.
- Owner dapat membuat project dan menambahkan user terdaftar berdasarkan email.
- Member project dapat melihat task project tersebut dan tidak dapat mengakses project lain.
- Satu task dapat memiliki beberapa assignee.
- Progress project berubah otomatis ketika status task berubah.
- Task selesai menyimpan `completed_at`.
- Penghapusan member menghapus assignment tetapi tidak menghapus komentar dan activity log yang sudah dibuat.
- Project owner tidak dapat dihapus selama masih memiliki project.
- Semua migration dapat dijalankan dari database kosong.

## 12. Status Implementasi Fondasi

- Model, enum, factory, dan relasi Eloquent telah dibuat.
- Seeder admin lokal telah disiapkan dengan akun `admin@gmail.com` dan password `admin`.
- Registrasi publik Fortify telah dinonaktifkan.
- Test SQLite telah lulus untuk schema, relasi, seeder, aturan penghapusan, dan registrasi publik.
- Migrasi ke MySQL masih perlu dijalankan setelah kredensial user MySQL `dehar` tersedia dan memiliki akses ke database `jara`.
