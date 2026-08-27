<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AdminController,
    AuthController,
    DashboardController,
    HeadLabController,
    HomeController,
    LabStaffController,
    LecturerController,
    LetterProcessController,
    ProgramStudyController,
    PublicTestingController,
    StudentController
};

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::prefix('admin')->name('admin.')->middleware('role:admin')->group(function () {
        Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');

        // Manajemen akun - hanya Admin yang dapat membuat/register akun.
        Route::get('/akun', [AdminController::class, 'users'])->name('users');
        Route::get('/akun/buat', [AdminController::class, 'createUser'])->name('users.create');
        Route::post('/akun', [AdminController::class, 'storeUser'])->name('users.store');
        Route::get('/akun/{user}/edit', [AdminController::class, 'editUser'])->name('users.edit');
        Route::put('/akun/{user}', [AdminController::class, 'updateUser'])->name('users.update');
        Route::delete('/akun/{user}', [AdminController::class, 'destroyUser'])->name('users.destroy');

        Route::get('/kelas', [AdminController::class, 'classes'])->name('classes');
        Route::get('/kelas/buat', [AdminController::class, 'createClass'])->name('classes.create');
        Route::post('/kelas', [AdminController::class, 'storeClass'])->name('classes.store');
        Route::get('/kelas/{class}/edit', [AdminController::class, 'editClass'])->name('classes.edit');
        Route::put('/kelas/{class}', [AdminController::class, 'updateClass'])->name('classes.update');
        Route::delete('/kelas/{class}', [AdminController::class, 'destroyClass'])->name('classes.destroy');
        Route::put('/kelas/{class}/verifikasi', [AdminController::class, 'verifyClass'])->name('classes.verify');

        Route::get('/tipe-kelas', [AdminController::class, 'classTypes'])->name('class-types');
        Route::post('/tipe-kelas', [AdminController::class, 'storeClassType'])->name('class-types.store');
        Route::delete('/tipe-kelas/{classType}', [AdminController::class, 'destroyClassType'])->name('class-types.destroy');

        Route::get('/pendaftaran-praktikum', [AdminController::class, 'registrations'])->name('registrations');
        Route::put('/pendaftaran-praktikum/{registration}', [AdminController::class, 'verifyRegistration'])->name('registrations.verify');

        Route::get('/jenis-surat', [AdminController::class, 'letterTypes'])->name('letter-types');
        Route::get('/jenis-surat/buat', [AdminController::class, 'createLetterType'])->name('letter-types.create');
        Route::post('/jenis-surat', [AdminController::class, 'storeLetterType'])->name('letter-types.store');
        Route::get('/jenis-surat/{letterType}/edit', [AdminController::class, 'editLetterType'])->name('letter-types.edit');
        Route::put('/jenis-surat/{letterType}', [AdminController::class, 'updateLetterType'])->name('letter-types.update');
        Route::get('/pengaturan-surat', [AdminController::class, 'letterSettings'])->name('letter-settings');
        Route::get('/laboratorium', [AdminController::class, 'laboratories'])->name('laboratories');
        Route::post('/laboratorium', [AdminController::class, 'storeLaboratory'])->name('laboratories.store');
        Route::put('/laboratorium/{laboratory}', [AdminController::class, 'updateLaboratory'])->name('laboratories.update');
        Route::delete('/laboratorium/{laboratory}', [AdminController::class, 'destroyLaboratory'])->name('laboratories.destroy');
        Route::get('/mata-kuliah', [AdminController::class, 'courses'])->name('courses');
        Route::post('/mata-kuliah', [AdminController::class, 'storeCourse'])->name('courses.store');
        Route::delete('/mata-kuliah/{course}', [AdminController::class, 'destroyCourse'])->name('courses.destroy');
        Route::put('/pengaturan-surat', [AdminController::class, 'updateLetterSettings'])->name('letter-settings.update');

        // Admin dapat menambah kategori dan jenis pengujian secara dinamis.
        Route::get('/jenis-pengujian', [AdminController::class, 'services'])->name('services');
        Route::get('/alur-pengujian/{testingService}', [AdminController::class, 'testingWorkflow'])->name('testing-workflow');
        Route::post('/alur-pengujian/{testingService}', [AdminController::class, 'saveTestingWorkflow'])->name('testing-workflow.save');
        Route::post('/kategori-pengujian', [AdminController::class, 'storeCategory'])->name('categories.store');
        Route::post('/jenis-pengujian', [AdminController::class, 'storeService'])->name('services.store');
    });

    Route::prefix('mahasiswa')->name('mahasiswa.')->middleware('role:mahasiswa')->group(function () {
        Route::get('/', [StudentController::class, 'dashboard'])->name('dashboard');
        Route::get('/praktikum', [StudentController::class, 'practicums'])->name('practicums');
        Route::get('/praktikum/{class}/daftar', [StudentController::class, 'apply'])->name('apply');
        Route::post('/praktikum/{class}/daftar', [StudentController::class, 'store'])->name('store');
        Route::get('/praktikum/{registration}/surat-lolos', [StudentController::class, 'practicumCertificate'])->name('practicum-certificate');
    });

    Route::prefix('dosen')->name('dosen.')->middleware('role:dosen')->group(function () {
        Route::get('/', [LecturerController::class, 'dashboard'])->name('dashboard');
        Route::get('/kelas/{class}/mahasiswa', [LecturerController::class, 'students'])->name('students');
    });

    Route::prefix('tenaga-labor')->name('tenaga-labor.')->middleware('role:tenaga_labor')->group(function () {
        Route::get('/', [LabStaffController::class, 'dashboard'])->name('dashboard');
        Route::get('/pengujian/{testingRequest}', [LabStaffController::class, 'show'])->name('tests.show');
        Route::post('/pengujian/{testingRequest}/terima-sampel', [LabStaffController::class, 'receiveSample'])->name('tests.receive');
        Route::post('/pengujian/{testingRequest}/mulai', [LabStaffController::class, 'start'])->name('tests.start');
        Route::post('/pengujian/{testingRequest}/selesai', [LabStaffController::class, 'complete'])->name('tests.complete');
        Route::post('/praktikum/{registration}/nilai', [LabStaffController::class, 'updatePracticumScore'])->name('practicums.score');
        Route::post('/kelompok/{class}/atur', [LabStaffController::class, 'updatePracticumClass'])->name('practicums.update');
        Route::get('/kelompok/{class}/mahasiswa.xlsx', [LabStaffController::class, 'exportPracticumGroup'])->name('practicums.export');
    });

    Route::get('/kepala-labor', [HeadLabController::class, 'dashboard'])->name('kepala-labor.dashboard')->middleware('role:kepala_labor');
    Route::prefix('prodi')->name('prodi.')->middleware('role:prodi')->group(function () {
        Route::get('/', [ProgramStudyController::class, 'dashboard'])->name('dashboard');
        Route::get('/kelas-praktikum', [ProgramStudyController::class, 'classes'])->name('classes');
    });

    Route::prefix('umum')->name('umum.')->middleware('role:umum')->group(function () {
        Route::get('/', [PublicTestingController::class, 'dashboard'])->name('dashboard');
        Route::get('/pengujian/buat', [PublicTestingController::class, 'create'])->name('tests.create');
        Route::post('/pengujian', [PublicTestingController::class, 'store'])->name('tests.store');
        Route::get('/pengujian/{testingRequest}', [PublicTestingController::class, 'show'])->name('tests.show');
    });

    Route::prefix('pengurusan-surat')->name('surat.')->group(function () {
        Route::get('/', [LetterProcessController::class, 'index'])->name('index');
        Route::get('/buat', [LetterProcessController::class, 'create'])->name('create');
        Route::post('/', [LetterProcessController::class, 'store'])->name('store');
        Route::get('/{letterRequest}/dokumen', [LetterProcessController::class, 'document'])->name('document');
        Route::get('/{letterRequest}', [LetterProcessController::class, 'show'])->name('show');
        Route::post('/{letterRequest}/proses', [LetterProcessController::class, 'action'])->name('action');
    });
});
