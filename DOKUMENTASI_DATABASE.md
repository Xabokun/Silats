# Dokumentasi Database SILATS v2

## Modul Akademik
- `courses`: master mata kuliah.
- `practicum_classes`: kelas, dosen, laboratorium, ruangan, jadwal, kapasitas.
- `practicum_requirements`: syarat per mata kuliah praktikum.
- `practicum_registrations`: pilihan kelas awal dan kelas final setelah verifikasi Admin.
- `requirement_submissions`: berkas syarat mahasiswa dan hasil verifikasi.

## Modul Persuratan
- `letter_types`: jenis/judul surat yang dibuat Admin.
- `letter_requirements`: syarat per jenis surat.
- `letter_workflow_steps`: urutan/jenjang dinamis per role.
- `letter_requests`: surat yang diajukan user dan posisi tahapan aktif.
- `letter_requirement_submissions`: lampiran syarat surat.
- `letter_request_histories`: histori approval/reject untuk tracking.

## Modul Pengujian
- `testing_categories`: subjudul/kategori fleksibel (Beton, Tanah, Air, dst.).
- `testing_services`: jenis layanan pengujian dan laboratorium tujuan.
- `testing_requests`: permohonan masyarakat dan status proses.
- `testing_samples`: sampel fisik yang diterima Laboran.
- `testing_histories`: timeline status sampel/pengujian.
- `testing_results`: surat/ringkasan hasil pengujian.

## Hak akses penting
- `users.role` menyimpan: `admin`, `mahasiswa`, `dosen`, `tenaga_labor`, `kepala_labor`, `prodi`, `umum`.
- `users.laboratory_id` membatasi Tenaga Labor dan Kepala Labor pada laboratorium masing-masing.
- Admin adalah satu-satunya role yang membuat struktur workflow surat.
