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
