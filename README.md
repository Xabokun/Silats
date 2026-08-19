# SILATS Laravel v4.2 — Sidebar, Prodi, dan Automatic Letter Generator

SILATS adalah Sistem Informasi Laboratorium Teknik Sipil berbasis **Laravel + Blade + Bootstrap**. Modul utama: **Praktikum**, **Pengujian Material**, dan **Persuratan Berjenjang**.

## Fitur utama

- **Admin**: dashboard grafik, manajemen akun, jadwal/kelas praktikum, verifikasi persyaratan dan kelas final mahasiswa, kategori/jenis pengujian, manajemen jenis surat, workflow surat, data kebutuhan surat, template surat, penomoran surat, penandatangan, serta pengaturan kop surat.
- **Mahasiswa**: pendaftaran praktikum, upload persyaratan, menunggu verifikasi Admin, melihat kelas final, dan mengajukan surat. Tidak ada fitur pembatalan KRS.
- **Dosen**: melihat mata kuliah/kelas yang diajar, jumlah mahasiswa, daftar mahasiswa, serta memproses surat jika role Dosen ditempatkan pada workflow.
- **Tenaga Labor**: menerima sampel masyarakat, memproses pengujian, menyelesaikan hasil, serta menangani surat sesuai workflow.
- **Kepala Labor**: melihat aktivitas laboratoriumnya sendiri dan menangani surat pada tahap Kepala Labor.
- **Prodi**: monitoring semua laboratorium, melihat semua kelas praktikum, dan menangani/monitor surat.
- **Masyarakat/Umum**: akun dibuat Admin, mengajukan pengujian, tracking sampel, melihat hasil, serta dapat menggunakan modul persuratan bila jenis surat mengizinkan.
- Semua navigasi user login berada pada **sidebar kiri responsif**.
- Registrasi mandiri dinonaktifkan; hanya Admin dapat membuat akun.

## Automatic Letter Generator v4.2

Setiap jenis surat dapat memiliki:

1. Kop surat global (institusi, fakultas, unit, alamat, telepon, email, website, kota, logo).
2. Perihal default.
3. Teks lampiran.
4. Format nomor surat otomatis.
5. Isi surat berbasis template.
6. Data kebutuhan surat dinamis yang diisi pemohon.
7. Penandatangan (nama, jabatan, NIP/identitas).
8. Persyaratan berkas.
9. Workflow antar-role.

Saat permohonan dibuat, SILATS langsung membuat **Draft Surat** dengan watermark. Setelah seluruh workflow disetujui, sistem otomatis memberikan tanggal dan nomor surat resmi serta menyimpan isi final surat.

### Placeholder template

Placeholder standar:

- `{{nama}}`
- `{{npm}}`
- `{{email}}`
- `{{telepon}}`
- `{{alamat}}`
- `{{perihal}}`
- `{{laboratorium}}`
- `{{tanggal_pengajuan}}`
- `{{tanggal_surat}}`
- `{{nomor_permohonan}}`
- `{{nomor_surat}}`
- `{{catatan}}`

Field buatan Admin dipanggil dengan format:

```text
{{field:keperluan}}
{{field:semester}}
{{field:nama_praktikum}}
```

Token format nomor surat:

```text
{seq} {code} {month} {month_roman} {year} {lab}
```

Contoh:

```text
{seq}/{code}/{lab}/{month_roman}/{year}
```

menjadi:

```text
001/SKPRAK/LAB-BTN/VIII/2026
```

## Instalasi baru

```bash
cd SILATS_Laravel
composer install
copy .env.example .env
php artisan key:generate
```

Buat database MySQL `silats`, sesuaikan `.env`, lalu:

```bash
php artisan migrate:fresh --seed
php artisan storage:link
php artisan serve
```

Buka `http://127.0.0.1:8000`.

## Upgrade dari SILATS v4.1 tanpa menghapus data

Jika database v4.1 sudah berisi data yang ingin dipertahankan, **jangan** gunakan `migrate:fresh`.

Setelah mengganti source code dengan v4.2, jalankan:

```bash
php artisan migrate
php artisan storage:link
php artisan optimize:clear
php artisan serve
```

Migration baru akan menambahkan tabel/kolom Automatic Letter Generator tanpa menghapus tabel lama.

## Cetak / PDF

Dokumen surat menggunakan layout A4 siap cetak. Klik **Cetak / Simpan PDF**, kemudian pada Chrome/Edge pilih printer **Save as PDF**. Tidak diperlukan package PDF tambahan.

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

## Catatan teknis

- Laravel 12/13 compatible sesuai `composer.json`.
- Frontend: Blade + Bootstrap via CDN.
- Grafik: Chart.js via CDN.
- Upload kop/lampiran menggunakan disk `public`; jalankan `php artisan storage:link`.
- Folder `vendor` tidak disertakan; jalankan `composer install` setelah ekstraksi.
