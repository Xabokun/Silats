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
        $student = User::create(['npm' => '2210001', 'name' => 'Budi Mahasiswa', 'email' => 'mahasiswa@silats.test', 'role' => 'mahasiswa', 'password' => 'password']);
        $student2 = User::create(['npm' => '2210002', 'name' => 'Siti Mahasiswa', 'email' => 'mahasiswa2@silats.test', 'role' => 'mahasiswa', 'password' => 'password']);
        $dosen = User::create(['name' => 'Dr. Ahmad, S.T., M.T.', 'email' => 'dosen@silats.test', 'role' => 'dosen', 'password' => 'password']);
        $labor = User::create(['name' => 'Laboran Beton', 'email' => 'labor@silats.test', 'role' => 'tenaga_labor', 'laboratory_id' => $beton->id, 'password' => 'password']);
        $kalab = User::create(['name' => 'Kepala Lab Beton', 'email' => 'kalab@silats.test', 'role' => 'kepala_labor', 'laboratory_id' => $beton->id, 'password' => 'password']);
        User::create(['name' => 'Laboran Tanah', 'email' => 'labor.tanah@silats.test', 'role' => 'tenaga_labor', 'laboratory_id' => $tanah->id, 'password' => 'password']);
        User::create(['name' => 'Kepala Lab Tanah', 'email' => 'kalab.tanah@silats.test', 'role' => 'kepala_labor', 'laboratory_id' => $tanah->id, 'password' => 'password']);
        User::create(['name' => 'Laboran Air', 'email' => 'labor.air@silats.test', 'role' => 'tenaga_labor', 'laboratory_id' => $air->id, 'password' => 'password']);
        User::create(['name' => 'Kepala Lab Air', 'email' => 'kalab.air@silats.test', 'role' => 'kepala_labor', 'laboratory_id' => $air->id, 'password' => 'password']);
        User::create(['name' => 'Program Studi Teknik Sipil', 'email' => 'prodi@silats.test', 'role' => 'prodi', 'password' => 'password']);
        $umum = User::create(['name' => 'Andi Masyarakat', 'email' => 'umum@silats.test', 'phone' => '081234567890', 'role' => 'umum', 'password' => 'password']);

        LetterheadSetting::create([
            'institution_name' => 'UNIVERSITAS CONTOH',
            'faculty_name' => 'FAKULTAS TEKNIK SIPIL',
            'unit_name' => 'PROGRAM STUDI TEKNIK SIPIL',
            'address' => 'Jl. Pendidikan No. 1, Palu, Sulawesi Tengah',
            'phone' => '(0451) 000000',
            'email' => 'tekniksipil@kampus.ac.id',
            'website' => 'www.kampus.ac.id',
            'city' => 'Palu',
        ]);

        $mkBeton = Course::create(['code' => 'TS-BTN', 'name' => 'Praktikum Teknologi Beton', 'credits' => 1]);
        $mkTanah = Course::create(['code' => 'TS-TNH', 'name' => 'Praktikum Mekanika Tanah', 'credits' => 1]);
        $mkAir = Course::create(['code' => 'TS-AIR', 'name' => 'Praktikum Hidrolika', 'credits' => 1]);

        foreach ([
            [$mkBeton, 'KRS Semester Aktif'],
            [$mkBeton, 'Bukti Pembayaran Praktikum'],
            [$mkTanah, 'KRS Semester Aktif'],
            [$mkTanah, 'KTM'],
            [$mkAir, 'KRS Semester Aktif'],
        ] as [$course, $title]) {
            PracticumRequirement::create([
                'course_id' => $course->id,
                'title' => $title,
                'description' => 'Unggah PDF/JPG yang jelas.',
            ]);
        }

        $bA = PracticumClass::create([
            'course_id' => $mkBeton->id,
            'laboratory_id' => $beton->id,
            'lecturer_id' => $dosen->id,
            'class_name' => 'A',
            'room' => 'Lab Beton 01',
            'day' => 'Senin',
            'start_time' => '08:00',
            'end_time' => '10:00',
            'capacity' => 40,
        ]);
        PracticumClass::create([
            'course_id' => $mkBeton->id,
            'laboratory_id' => $beton->id,
            'lecturer_id' => $dosen->id,
            'class_name' => 'B',
            'room' => 'Lab Beton 01',
            'day' => 'Senin',
            'start_time' => '10:00',
            'end_time' => '12:00',
            'capacity' => 40,
        ]);
        PracticumClass::create([
            'course_id' => $mkTanah->id,
            'laboratory_id' => $tanah->id,
            'lecturer_id' => $dosen->id,
            'class_name' => 'A',
            'room' => 'Lab Tanah',
            'day' => 'Selasa',
            'start_time' => '08:00',
            'end_time' => '10:00',
            'capacity' => 40,
        ]);
        PracticumClass::create([
            'course_id' => $mkAir->id,
            'laboratory_id' => $air->id,
            'lecturer_id' => $dosen->id,
            'class_name' => 'A',
            'room' => 'Lab Hidrolika',
            'day' => 'Rabu',
            'start_time' => '09:00',
            'end_time' => '11:00',
            'capacity' => 35,
        ]);
        PracticumRegistration::create([
            'student_id' => $student2->id,
            'practicum_class_id' => $bA->id,
            'final_class_id' => $bA->id,
            'status' => 'approved',
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
            'title' => 'Surat Keterangan Praktikum',
            'description' => 'Surat keterangan terkait kegiatan praktikum mahasiswa.',
            'default_subject' => 'Keterangan Praktikum',
            'attachment_text' => '1 Berkas',
            'number_format' => '{seq}/{code}/{month_roman}/{year}',
            'signatory_name' => 'Dr. Ahmad, S.T., M.T.',
            'signatory_position' => 'Kepala Laboratorium',
            'signatory_identifier' => 'NIP. 198000000000000001',
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
            'signatory_identifier' => 'NIP. 198000000000000002',
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
