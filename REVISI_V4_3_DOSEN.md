# SILATS v4.3 — Revisi Dosen

Perubahan pada versi ini:

1. Admin dapat membuat dan mengedit akun.
   - Edit nama, email, role sistem, NPM/NIDN, laboratorium, jabatan, periode jabatan, dan reset password.
2. Akun Dosen:
   - No. HP dihilangkan dari form.
   - Alamat dihilangkan dari form.
   - Ditambahkan NIDN.
   - Ditambahkan Kepakaran.
3. Jabatan Prodi:
   - Menyimpan jabatan, tanggal mulai, dan tanggal selesai.
   - Periode yang sudah lewat diberi penanda `Berakhir` pada daftar akun.
4. Kepala Labor:
   - Penugasan laboratoriumnya dapat diedit Admin.
5. Sidebar:
   - Lebar desktop bersifat fleksibel dan mengikuti konten/nama profil sampai batas aman.
6. Kop surat:
   - Default menggunakan kop Fakultas Teknik dari dokumen acuan yang diberikan pengguna.
   - Admin dapat mengganti gambar kop lengkap melalui Pengaturan Kop Surat.
7. Surat resmi:
   - Tanggal Masehi dan tanggal Hijriyah ditampilkan dua baris.
   - Format tata letak dibuat mendekati contoh surat UIR yang diberikan.
   - Penandatangan menampilkan Nama, Jabatan, dan NIDN.
8. Asset baru:
   - `public/images/kop-ft-uir.jpg`
9. Migration baru:
   - `2026_08_20_000024_add_profile_fields_to_users_table.php`
   - `2026_08_20_000025_add_header_image_to_letterhead_settings_table.php`

## Upgrade

Untuk database SILATS v4.2.1 yang sudah berjalan:

```bash
php artisan migrate
php artisan storage:link
php artisan optimize:clear
```

Tidak perlu `migrate:fresh` jika data lama ingin dipertahankan.
