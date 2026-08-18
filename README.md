# SILATS Laravel v3 — Teknik Sipil

Versi revisi berdasarkan evaluasi dosen. SILATS kini memiliki tiga modul utama: **Praktikum**, **Pengujian Material**, dan **Persuratan Berjenjang**.

## Fitur utama

- Admin: dashboard grafik, manajemen akun, pengaturan jadwal/kelas, verifikasi syarat praktikum, pemindahan kelas akhir, manajemen jenis surat + syarat + workflow, serta kategori dan jenis pengujian fleksibel.
- Mahasiswa: memilih praktikum, mengunggah syarat, menunggu ACC Admin, melihat kelas final. **Tidak ada fitur pembatalan KRS.**
- Dosen: melihat mata kuliah/kelas yang diajar dan jumlah/daftar mahasiswa.
- Tenaga Labor: menerima sampel masyarakat, mengubah status menjadi proses pengujian, menyelesaikan pengujian dan menerbitkan hasil.
- Kepala Labor: hanya melihat kelas, pengujian, surat, dan tenaga labor pada laboratoriumnya sendiri.
- Prodi: monitoring semua laboratorium.
- Masyarakat/Umum: akun dibuat oleh Admin, kemudian dapat mengajukan pengujian, membawa sampel, tracking proses, dan melihat surat hasil setelah selesai.
- Semua role: menu Pengurusan Surat dan tracking posisi surat; alur hanya dibuat oleh Admin.
- Registrasi mandiri/public dinonaktifkan. Hanya Admin yang dapat membuat akun melalui menu **Manajemen Akun**.
- Halaman publik hanya menampilkan tombol login pada bagian body; tombol login/daftar pada navbar dihilangkan.

## Instalasi

1. Ekstrak project dan masuk folder:
   ```bash
   cd SILATS_Laravel
   composer install
   copy .env.example .env
   php artisan key:generate
   ```
2. Buat database MySQL bernama `silats`.
3. Sesuaikan koneksi DB di `.env`.
4. Jalankan:
   ```bash
   php artisan migrate:fresh --seed
   php artisan storage:link
   php artisan serve
   ```
5. Buka `http://127.0.0.1:8000`.

> Karena struktur database berubah dari versi sebelumnya, gunakan `php artisan migrate:fresh --seed` pada database development. Perintah ini menghapus data lama.

## Akun demo

Semua password: `password`

| Role | Login |
|---|---|
| Admin | `admin@silats.test` |
| Mahasiswa | `2210001` atau `mahasiswa@silats.test` |
| Mahasiswa demo 2 | `2210002` atau `mahasiswa2@silats.test` |
| Dosen | `dosen@silats.test` |
| Tenaga Labor Beton | `labor@silats.test` |
| Kepala Labor Beton | `kalab@silats.test` |
| Prodi | `prodi@silats.test` |
| Umum/Masyarakat | `umum@silats.test` |

Laboran/Kepala Lab Tanah dan Air juga tersedia pada Seeder.

## Catatan teknis

- Frontend: Blade + Bootstrap 5 via CDN.
- Grafik: Chart.js via CDN.
- Upload syarat/hasil menggunakan disk `public`; jalankan `php artisan storage:link`.
- Project tidak menyertakan folder `vendor`; jalankan `composer install` setelah ekstraksi.
