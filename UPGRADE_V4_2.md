# Upgrade SILATS v4.1 → v4.2

Jika ingin mempertahankan database yang sudah ada:

```bash
php artisan migrate
php artisan storage:link
php artisan optimize:clear
```

Jangan menjalankan `php artisan migrate:fresh --seed` jika data lama harus dipertahankan.

Setelah migration selesai:

1. Login sebagai Admin.
2. Buka **Pengaturan Kop Surat** dan isi identitas fakultas/institusi.
3. Buka **Manajemen Surat**.
4. Klik **Atur Template** pada jenis surat lama.
5. Isi perihal, lampiran, template isi, format nomor, serta penandatangan.
6. Untuk jenis surat yang belum memiliki riwayat pengajuan, Admin juga dapat mengubah data kebutuhan, persyaratan, dan workflow.
7. Uji dari akun Mahasiswa/Dosen: Pengurusan Surat → Ajukan Surat → Preview Draft.
8. Selesaikan seluruh tahapan workflow untuk memastikan nomor surat resmi tergenerate.

Catatan: jenis surat yang sudah memiliki riwayat permohonan tetap dapat diubah templatenya, tetapi struktur persyaratan/field/workflow lama tidak ditimpa untuk menjaga data historis.
