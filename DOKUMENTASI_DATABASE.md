# Dokumentasi Database SILATS v4.2

## Modul Akademik
- `courses`: master mata kuliah.
- `practicum_classes`: kelas, dosen, laboratorium, ruangan, jadwal, kapasitas.
- `practicum_requirements`: syarat per mata kuliah praktikum.
- `practicum_registrations`: pilihan kelas awal dan kelas final setelah verifikasi Admin.
- `requirement_submissions`: berkas syarat mahasiswa dan hasil verifikasi.

## Modul Persuratan
- `letterhead_settings`: identitas kop surat global, kota penerbitan, dan logo.
- `letter_types`: master jenis surat, perihal default, lampiran, template isi, format nomor, dan penandatangan.
- `letter_form_fields`: data kebutuhan surat dinamis yang harus diisi pemohon.
- `letter_field_values`: snapshot nilai field kebutuhan untuk setiap pengajuan.
- `letter_requirements`: persyaratan berkas per jenis surat.
- `letter_workflow_steps`: urutan/jenjang dinamis per role.
- `letter_requests`: pengajuan surat, nomor tracking, nomor resmi, tanggal surat, isi final tergenerate, status, dan posisi tahapan aktif.
- `letter_requirement_submissions`: lampiran persyaratan surat.
- `letter_request_histories`: histori submit, approval, reject, dan penerbitan untuk tracking.

### Status dokumen surat
- `in_process`: draft tersedia, workflow belum selesai.
- `rejected`: pengajuan ditolak; dokumen tetap draft dan tidak mempunyai nomor resmi.
- `completed`: seluruh workflow disetujui dan surat resmi sudah diterbitkan.

### Penomoran surat
`letter_types.number_format` dapat menggunakan token `{seq}`, `{code}`, `{month}`, `{month_roman}`, `{year}`, dan `{lab}`.

## Modul Pengujian
- `testing_categories`: kategori fleksibel (Beton, Tanah, Air, dst.).
- `testing_services`: jenis layanan pengujian dan laboratorium tujuan.
- `testing_requests`: permohonan masyarakat dan status proses.
- `testing_samples`: sampel fisik yang diterima Laboran.
- `testing_histories`: timeline status sampel/pengujian.
- `testing_results`: surat/ringkasan hasil pengujian.

## Hak akses penting
- `users.role`: `admin`, `mahasiswa`, `dosen`, `tenaga_labor`, `kepala_labor`, `prodi`, `umum`.
- `users.laboratory_id` membatasi Tenaga Labor dan Kepala Labor pada laboratorium masing-masing.
- Admin adalah satu-satunya role yang membentuk struktur jenis surat, data kebutuhan, persyaratan, dan workflow.
- User yang menjadi role pada tahap aktif workflow dapat melihat dan memproses surat tersebut.
- Prodi dapat memonitor seluruh surat dan seluruh kelas praktikum.
