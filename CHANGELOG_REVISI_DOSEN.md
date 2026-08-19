# Changelog Revisi Dosen — SILATS v3

## Admin
- Role Admin ditambahkan.
- Dashboard grafik jumlah pengujian dan pemilihan kelas praktikum.
- CRUD dasar jadwal/kelas: mata kuliah, dosen, laboratorium, ruangan, hari, jam, kapasitas.
- Verifikasi syarat pendaftaran praktikum dan penentuan kelas final.
- Mahasiswa dapat dipindahkan ke kelas lain oleh Admin saat kelas pilihan penuh.
- Manajemen jenis surat: judul/kode, syarat, dan workflow/jenjang role secara dinamis.
- Master kategori pengujian dan jenis pengujian fleksibel; Admin dapat menambah jenis pengujian dari dashboard.
- Menu Manajemen Akun; hanya Admin yang dapat membuat/register akun semua role.

## Mahasiswa
- Pendaftaran praktikum dengan upload persyaratan.
- Status menunggu verifikasi Admin.
- Menampilkan kelas pilihan dan kelas final setelah ACC.
- Fitur pembatalan KRS dihapus.

## Dosen
- Melihat kelas/mata kuliah yang diajar.
- Melihat jumlah dan daftar mahasiswa terverifikasi.

## Pengguna Umum
- Tidak ada registrasi mandiri. Akun masyarakat dibuat oleh Admin.
- Ajukan layanan pengujian Beton/Tanah/Air atau kategori lain yang dibuat Admin.
- Tracking: menunggu sampel → sampel diterima → pengujian → selesai.
- Melihat ringkasan/surat hasil pengujian setelah selesai.

## Tenaga Labor
- Hanya memproses pengujian pada laboratoriumnya.
- Input penerimaan sampel.
- Mulai proses pengujian.
- Selesaikan pengujian dan terbitkan hasil/PDF opsional.

## Kepala Labor
- Scope data dibatasi oleh `laboratory_id`.
- Melihat kelas, pengujian, surat, dan tenaga labor pada lab-nya.

## Prodi
- Monitoring lintas semua laboratorium.

## Persuratan
- Semua user login memiliki menu Pengurusan Surat.
- Admin saja yang membuat struktur jenis/syarat/alur surat.
- Tracking posisi surat berdasarkan step aktif.
- Approval/reject sesuai role pada step workflow.

## Landing Page & Login
- Tombol Login dan Daftar pada navbar publik dihilangkan.
- Tombol login hanya tersedia pada bagian body/hero halaman utama.
- Route registrasi publik `/daftar` dinonaktifkan.

## Revisi v4
- Seluruh menu user terautentikasi dipindahkan dari navbar atas ke sidebar kiri.
- Sidebar dibuat responsif untuk desktop dan mobile.
- Tombol keluar dipindahkan ke bagian bawah sidebar.
- Prodi mendapat menu **Semua Kelas Praktikum**.
- Prodi dapat melihat seluruh kelas dari semua laboratorium beserta mata kuliah, kelas, laboratorium, dosen, ruangan, jadwal, jumlah mahasiswa final, jumlah pilihan awal, kapasitas, semester/tahun akademik, dan status kelas.
- Dashboard Prodi menampilkan ringkasan total kelas praktikum dan kelas aktif.

## v4.1 - Perbaikan Pengajuan Surat
- Memperbaiki ParseError pada halaman `pengurusan-surat/buat` yang disebabkan ekspresi closure bertingkat di dalam directive `@json` Blade.
- Data jenis surat, persyaratan, dan workflow sekarang diproses terlebih dahulu pada blok `@php`, kemudian dikirim ke JavaScript melalui `@json` sederhana.
- Menambahkan rendering persyaratan dan alur surat yang lebih aman serta dukungan nilai form lama setelah validasi gagal.
- Merapikan pola serupa pada Dashboard Admin agar tidak memunculkan ParseError yang sama pada label grafik kelas.

## v4.2 - Automatic Letter Generator
- Menambahkan menu Admin **Pengaturan Kop Surat**: nama institusi, fakultas, unit, alamat, telepon, email, website, kota penerbitan, dan logo.
- Jenis surat sekarang memiliki perihal default, lampiran, template isi, format nomor surat, dan data penandatangan.
- Admin dapat membuat **Data Kebutuhan Surat** dinamis (text, textarea, tanggal, angka) yang diisi pemohon ketika mengajukan surat.
- Data kebutuhan dapat dipanggil di template dengan placeholder `{{field:key}}`.
- Menambahkan placeholder otomatis pemohon seperti `{{nama}}`, `{{npm}}`, `{{email}}`, `{{laboratorium}}`, `{{tanggal_surat}}`, dan `{{nomor_surat}}`.
- Setelah pengajuan dikirim, sistem langsung menyediakan **Preview Draft** dengan watermark `DRAFT • BELUM DISAHKAN`.
- Tahap pertama yang sama dengan role pemohon otomatis dianggap selesai pada saat pengajuan dikirim.
- Setelah approval terakhir, sistem otomatis menerbitkan tanggal surat dan nomor surat resmi.
- Menambahkan layout surat A4 resmi yang memuat Kop Surat, Tanggal, Nomor, Lampiran, Perihal, Isi, dan Penandatangan.
- Surat resmi dapat dicetak atau disimpan sebagai PDF melalui dialog print browser tanpa dependency PDF tambahan.
- User yang sedang menjadi pemroses workflow dapat melihat surat masuk pada menu Pengurusan Surat; user yang pernah memproses surat tetap dapat melihat riwayat surat tersebut.
- Menambahkan jenis surat demo khusus Dosen agar alur pengajuan surat dari akun Dosen dapat langsung diuji setelah seeding.
