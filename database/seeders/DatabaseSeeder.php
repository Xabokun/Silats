<?php

namespace Database\Seeders;

use App\Models\{
    Course,
    Laboratory,
    LetterFormField,
    LetterRequest,
    LetterRequestHistory,
    LetterRequirement,
    LetterType,
    LetterWorkflowStep,
    LetterheadSetting,
    PracticumClass,
    PracticumRegistration,
    PracticumRequirement,
    TestingCategory,
    TestingHistory,
    TestingRequest,
    TestingService,
    User
};
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $beton = Laboratory::create([
            'code' => 'LAB-BTN',
            'name' => 'Laboratorium Beton',
            'description' => 'Pengujian teknologi beton dan material konstruksi.',
        ]);
        $tanah = Laboratory::create([
            'code' => 'LAB-TNH',
            'name' => 'Laboratorium Tanah',
            'description' => 'Pengujian mekanika tanah dan geoteknik.',
        ]);
        $air = Laboratory::create([
            'code' => 'LAB-AIR',
            'name' => 'Laboratorium Air',
            'description' => 'Pengujian hidrolika dan kualitas air.',
        ]);

        $admin = User::create(['name' => 'Admin SILATS', 'email' => 'admin@silats.test', 'role' => 'admin', 'password' => 'password']);
        $student = User::create(['npm' => '2210001', 'name' => 'Budi Mahasiswa', 'email' => 'budi@student.uir.ac.id', 'role' => 'mahasiswa', 'password' => 'password']);
        $student2 = User::create(['npm' => '2210002', 'name' => 'Siti Mahasiswa', 'email' => 'siti@student.uir.ac.id', 'role' => 'mahasiswa', 'password' => 'password']);
        $dosenGeoteknik = User::create(['name' => 'Ir. Sy. Sarah Alwiah, ST., MT.', 'email' => 'sarah.alwiah@silats.test', 'nidn' => '0000000001', 'expertise' => 'Geoteknik dan Jalan Raya', 'role' => 'dosen', 'password' => 'password']);
        $dosenStruktur = User::create(['name' => 'Ir. Heri Ahmadi, ST., MT. IPM', 'email' => 'heri.ahmadi@silats.test', 'nidn' => '0000000002', 'expertise' => 'Struktur Material dan Komputer', 'role' => 'dosen', 'password' => 'password']);
        $dosenHidrolika = User::create(['name' => 'Dr. Ir. Yolly Adriati, ST., MT. IPM.', 'email' => 'yolly.adriati@silats.test', 'nidn' => '0000000003', 'expertise' => 'Hidrolika, Hidrologi, dan Lingkungan', 'role' => 'dosen', 'password' => 'password']);
        $labor = User::create(['name' => 'Laboran Beton', 'email' => 'labor@silats.test', 'role' => 'tenaga_labor', 'laboratory_id' => $beton->id, 'password' => 'password']);
        $kalab = User::create(['name' => 'Kepala Lab Beton', 'email' => 'kalab@silats.test', 'role' => 'kepala_labor', 'laboratory_id' => $beton->id, 'password' => 'password']);
        $laborTanah = User::create(['name' => 'Laboran Tanah', 'email' => 'labor.tanah@silats.test', 'role' => 'tenaga_labor', 'laboratory_id' => $tanah->id, 'password' => 'password']);
        $kalabTanah = User::create(['name' => 'Kepala Lab Tanah', 'email' => 'kalab.tanah@silats.test', 'role' => 'kepala_labor', 'laboratory_id' => $tanah->id, 'password' => 'password']);
        User::create(['name' => 'Laboran Air', 'email' => 'labor.air@silats.test', 'role' => 'tenaga_labor', 'laboratory_id' => $air->id, 'password' => 'password']);
        User::create(['name' => 'Kepala Lab Air', 'email' => 'kalab.air@silats.test', 'role' => 'kepala_labor', 'laboratory_id' => $air->id, 'password' => 'password']);
        User::create(['name' => 'Program Studi Teknik Sipil', 'email' => 'prodi@silats.test', 'role' => 'prodi', 'position_title' => 'Ketua Program Studi Teknik Sipil', 'position_start_date' => '2026-01-01', 'position_end_date' => '2029-01-01', 'password' => 'password']);
        $umum = User::create(['name' => 'Andi Masyarakat', 'email' => 'umum@silats.test', 'phone' => '081234567890', 'role' => 'umum', 'password' => 'password']);

        LetterheadSetting::create([
            'institution_name' => 'UNIVERSITAS CONTOH',
            'faculty_name' => 'PROGRAM STUDI TEKNIK SIPIL',
            'unit_name' => 'PROGRAM STUDI TEKNIK SIPIL',
            'address' => 'Jl. Pendidikan No. 1, Palu, Sulawesi Tengah',
            'phone' => '(0451) 000000',
            'email' => 'tekniksipil@kampus.ac.id',
            'website' => 'www.kampus.ac.id',
            'city' => 'Pekanbaru',
            'header_image_path' => null,
        ]);

        $mkMekanikaTanah1 = Course::create(['code' => 'TS-MT1', 'name' => 'Mekanika Tanah 1', 'credits' => 1]);
        $mkMekanikaTanah2 = Course::create(['code' => 'TS-MT2', 'name' => 'Mekanika Tanah 2', 'credits' => 1]);
        $mkPerkerasan = Course::create(['code' => 'TS-TPJ', 'name' => 'Teknik Perkerasan Jalan', 'credits' => 1]);
        $mkSurvey = Course::create(['code' => 'TS-TSW', 'name' => 'Teknik Survey Pengukuran Wilayah', 'credits' => 1]);
        $mkTeknologiBahan = Course::create(['code' => 'TS-TBB', 'name' => 'Teknologi Bahan', 'credits' => 1]);
        $mkKomputer = Course::create(['code' => 'TS-AKTS', 'name' => 'Aplikasi Komputer untuk Teknik Sipil', 'credits' => 1]);
        $mkHidrolika = Course::create(['code' => 'TS-HID', 'name' => 'Hidrolika', 'credits' => 1]);
        $mkHidrologi = Course::create(['code' => 'TS-HTR', 'name' => 'Hidrologi Terapan', 'credits' => 1]);

        foreach ([
            [$mkMekanikaTanah1, 'KRS Semester Aktif'], [$mkMekanikaTanah2, 'KRS Semester Aktif'],
            [$mkPerkerasan, 'KRS Semester Aktif'], [$mkSurvey, 'KRS Semester Aktif'],
            [$mkTeknologiBahan, 'KRS Semester Aktif'], [$mkKomputer, 'KRS Semester Aktif'],
            [$mkHidrolika, 'KRS Semester Aktif'], [$mkHidrologi, 'KRS Semester Aktif'],
        ] as [$course, $title]) {
            PracticumRequirement::create([
                'course_id' => $course->id,
                'title' => $title,
                'description' => 'Unggah PDF/JPG yang jelas.',
            ]);
        }

        $bA = PracticumClass::create([
            'course_id' => $mkMekanikaTanah1->id,
            'laboratory_id' => $tanah->id,
            'lecturer_id' => $dosenGeoteknik->id,
            'class_name' => 'A',
            'room' => 'Modul Mekanika Tanah 1',
            'day' => 'Senin',
            'start_time' => '08:00',
            'end_time' => '10:00',
            'capacity' => 40,
            'semester' => 'Ganjil',
        ]);
        foreach ([
            [$mkMekanikaTanah2, $tanah, $dosenGeoteknik, 'Genap'], [$mkPerkerasan, $tanah, $dosenGeoteknik, 'Genap'],
            [$mkSurvey, $tanah, $dosenGeoteknik, 'Ganjil'], [$mkTeknologiBahan, $beton, $dosenStruktur, 'Genap'],
            [$mkKomputer, $beton, $dosenStruktur, 'Genap'], [$mkHidrolika, $air, $dosenHidrolika, 'Ganjil'],
            [$mkHidrologi, $air, $dosenHidrolika, 'Genap'],
        ] as $index => [$course, $laboratory, $lecturer, $semester]) {
            PracticumClass::create([
                'course_id' => $course->id, 'laboratory_id' => $laboratory->id, 'lecturer_id' => $lecturer->id,
                'class_name' => 'A', 'room' => 'Modul '.$course->name, 'day' => ['Senin', 'Selasa', 'Rabu', 'Kamis'][$index % 4],
                'start_time' => '08:00', 'end_time' => '10:00', 'capacity' => 40, 'semester' => $semester,
            ]);
        }
        PracticumRegistration::create([
            'student_id' => $student2->id,
            'practicum_class_id' => $bA->id,
            'final_class_id' => $bA->id,
            'status' => 'approved',
            'final_score' => 85,
            'score_entered_by' => $laborTanah->id,
            'score_entered_at' => now(),
            'verified_by' => $admin->id,
            'verified_at' => now(),
        ]);

        $catBeton = TestingCategory::create(['name' => 'Beton', 'slug' => 'beton', 'description' => 'Layanan pengujian sampel beton.']);
        $catTanah = TestingCategory::create(['name' => 'Tanah', 'slug' => 'tanah', 'description' => 'Layanan pengujian mekanika tanah.']);
        $catAir = TestingCategory::create(['name' => 'Air', 'slug' => 'air', 'description' => 'Layanan pengujian air dan hidrolika.']);

        $svcBeton = TestingService::create(['testing_category_id' => $catBeton->id, 'laboratory_id' => $beton->id, 'code' => 'UJI-BTN-KT', 'name' => 'Uji Kuat Tekan Beton', 'description' => 'Pengujian kuat tekan benda uji beton.', 'requirements' => 'Bawa sampel silinder/kubus beton.']);
        $svcSlump = TestingService::create(['testing_category_id' => $catBeton->id, 'laboratory_id' => $beton->id, 'code' => 'UJI-BTN-SL', 'name' => 'Uji Slump Beton']);
        TestingService::create(['testing_category_id' => $catTanah->id, 'laboratory_id' => $tanah->id, 'code' => 'UJI-TNH-CBR', 'name' => 'Uji CBR Tanah']);
        TestingService::create(['testing_category_id' => $catAir->id, 'laboratory_id' => $air->id, 'code' => 'UJI-AIR-KUA', 'name' => 'Uji Kualitas Air']);

        foreach ([
            [$svcBeton, 'pending_sample'],
            [$svcBeton, 'testing'],
            [$svcSlump, 'completed'],
            [$svcBeton, 'completed'],
        ] as $i => $row) {
            [$service, $status] = $row;
            $testing = TestingRequest::create([
                'request_number' => 'UJI-DEMO-' . ($i + 1),
                'applicant_id' => $umum->id,
                'testing_service_id' => $service->id,
                'assigned_lab_staff_id' => $status === 'pending_sample' ? null : $labor->id,
                'status' => $status,
                'sample_description' => 'Sampel demo beton ' . ($i + 1),
                'submitted_at' => now(),
                'completed_at' => $status === 'completed' ? now() : null,
            ]);
            TestingHistory::create([
                'testing_request_id' => $testing->id,
                'status' => 'pending_sample',
                'description' => 'Permohonan dibuat.',
                'updated_by' => $umum->id,
            ]);
            if ($status !== 'pending_sample') {
                TestingHistory::create([
                    'testing_request_id' => $testing->id,
                    'status' => $status,
                    'description' => $status === 'testing' ? 'Pengujian sedang berlangsung.' : 'Pengujian selesai.',
                    'updated_by' => $labor->id,
                ]);
            }
        }

        $practicumLetter = LetterType::create([
            'code' => 'SKPRAK',
            'title' => 'Surat Lolos Praktikum',
            'description' => 'Surat keterangan terkait kegiatan praktikum mahasiswa.',
            'default_subject' => 'Keterangan Lolos Praktikum',
            'attachment_text' => '1 Berkas',
            'number_format' => '{seq}/{code}/{month_roman}/{year}',
            'signatory_name' => 'Kepala Laboratorium',
            'signatory_position' => 'Kepala Laboratorium',
            'signatory_identifier' => null,
            'body_template' => "Dengan hormat,\n\nDengan ini menerangkan bahwa:\n\nNama : {{nama}}\nNPM : {{npm}}\nSemester : {{field:semester}}\n\ntelah mengikuti kegiatan {{field:nama_praktikum}} pada {{laboratorium}}. Surat ini diterbitkan untuk keperluan {{field:keperluan}}.\n\nDemikian surat ini dibuat untuk dapat dipergunakan sebagaimana mestinya.",
            'created_by' => $admin->id,
        ]);
        LetterRequirement::create(['letter_type_id' => $practicumLetter->id, 'title' => 'KRS Semester Aktif']);
        foreach ([
            ['semester', 'Semester', 'text', 'Contoh: 6'],
            ['nama_praktikum', 'Nama Praktikum', 'text', 'Contoh: Praktikum Teknologi Beton'],
            ['keperluan', 'Keperluan Surat', 'textarea', 'Jelaskan tujuan penggunaan surat'],
        ] as $i => [$key, $label, $type, $placeholder]) {
            LetterFormField::create([
                'letter_type_id' => $practicumLetter->id,
                'sort_order' => $i + 1,
                'field_key' => $key,
                'label' => $label,
                'input_type' => $type,
                'placeholder' => $placeholder,
                'is_required' => true,
            ]);
        }
        foreach ([
            ['mahasiswa', 'Pengajuan Mahasiswa'],
            ['admin', 'Verifikasi Admin'],
            ['kepala_labor', 'Persetujuan Kepala Labor'],
            ['prodi', 'Persetujuan Prodi'],
        ] as $i => $step) {
            LetterWorkflowStep::create([
                'letter_type_id' => $practicumLetter->id,
                'step_order' => $i + 1,
                'role' => $step[0],
                'label' => $step[1],
            ]);
        }


        $lecturerLetter = LetterType::create([
            'code' => 'SRDOS',
            'title' => 'Surat Permohonan Dosen',
            'description' => 'Contoh jenis surat yang dapat diajukan oleh Dosen.',
            'default_subject' => 'Permohonan Dosen',
            'attachment_text' => '-',
            'number_format' => '{seq}/{code}/{month_roman}/{year}',
            'signatory_name' => 'Ketua Program Studi Teknik Sipil',
            'signatory_position' => 'Ketua Program Studi Teknik Sipil',
            'signatory_identifier' => 'NIDN. 0000000002',
            'body_template' => "Dengan hormat,\n\nSaya {{nama}} mengajukan permohonan terkait {{field:keperluan}} dengan tujuan {{field:tujuan}}.\n\nDemikian permohonan ini disampaikan untuk dapat diproses sebagaimana mestinya.",
            'created_by' => $admin->id,
        ]);
        foreach ([
            ['keperluan', 'Keperluan', 'textarea'],
            ['tujuan', 'Tujuan Surat', 'text'],
        ] as $i => [$key, $label, $type]) {
            LetterFormField::create([
                'letter_type_id' => $lecturerLetter->id,
                'sort_order' => $i + 1,
                'field_key' => $key,
                'label' => $label,
                'input_type' => $type,
                'is_required' => true,
            ]);
        }
        foreach ([
            ['dosen', 'Pengajuan Dosen'],
            ['admin', 'Verifikasi Admin'],
            ['prodi', 'Persetujuan Prodi'],
        ] as $i => $step) {
            LetterWorkflowStep::create([
                'letter_type_id' => $lecturerLetter->id,
                'step_order' => $i + 1,
                'role' => $step[0],
                'label' => $step[1],
            ]);
        }

        $labLetter = LetterType::create([
            'code' => 'SURATLAB',
            'title' => 'Surat Administrasi Laboratorium',
            'description' => 'Alur surat internal laboratorium.',
            'default_subject' => 'Administrasi Laboratorium',
            'attachment_text' => '-',
            'number_format' => '{seq}/{code}/{lab}/{month_roman}/{year}',
            'signatory_name' => 'Kepala Lab Beton',
            'signatory_position' => 'Kepala Laboratorium',
            'body_template' => "Dengan hormat,\n\nSehubungan dengan {{field:uraian}}, kami mengajukan surat administrasi laboratorium dengan tujuan {{field:tujuan}}.\n\nDemikian disampaikan untuk dipergunakan sebagaimana mestinya.",
            'created_by' => $admin->id,
        ]);
        foreach ([
            ['tujuan', 'Tujuan Surat', 'text'],
            ['uraian', 'Uraian Kebutuhan', 'textarea'],
        ] as $i => [$key, $label, $type]) {
            LetterFormField::create([
                'letter_type_id' => $labLetter->id,
                'sort_order' => $i + 1,
                'field_key' => $key,
                'label' => $label,
                'input_type' => $type,
                'is_required' => true,
            ]);
        }
        foreach ([
            ['tenaga_labor', 'Pengajuan Laboran'],
            ['kepala_labor', 'Persetujuan Kepala Labor'],
            ['prodi', 'Pencatatan Prodi'],
        ] as $i => $step) {
            LetterWorkflowStep::create([
                'letter_type_id' => $labLetter->id,
                'step_order' => $i + 1,
                'role' => $step[0],
                'label' => $step[1],
            ]);
        }

        $demoLetter = LetterRequest::create([
            'request_number' => 'SRT-DEMO-001',
            'letter_type_id' => $labLetter->id,
            'applicant_id' => $labor->id,
            'laboratory_id' => $beton->id,
            'subject' => 'Permohonan administrasi alat',
            'status' => 'in_process',
            'current_step_order' => 2,
        ]);
        LetterRequestHistory::create([
            'letter_request_id' => $demoLetter->id,
            'action' => 'submitted',
            'actor_id' => $labor->id,
            'actor_role' => 'tenaga_labor',
            'notes' => 'Surat dibuat.',
        ]);
        LetterRequestHistory::create([
            'letter_request_id' => $demoLetter->id,
            'step_order' => 1,
            'action' => 'approve',
            'actor_id' => $labor->id,
            'actor_role' => 'tenaga_labor',
            'notes' => 'Pengajuan diteruskan ke Kepala Labor.',
        ]);
    }
}
