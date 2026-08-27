<?php

namespace App\Http\Controllers;

use App\Models\{
    Course,
    LetterFormField,
    LetterRequirement,
    LetterType,
    LetterWorkflowStep,
    LetterheadSetting,
    Laboratory,
    PracticumClass,
    PracticumClassType,
    PracticumRegistration,
    TestingCategory,
    TestingRequest,
    TestingService,
    TestingWorkflowStep,
    User
};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    public function users()
    {
        $users = User::with('laboratory')->orderBy('role')->orderBy('name')->get();
        return view('admin.users', compact('users'));
    }

    public function createUser()
    {
        $laboratories = Laboratory::orderBy('name')->get();
        return view('admin.user-form', ['laboratories' => $laboratories, 'user' => new User]);
    }

    public function storeUser(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'npm' => 'nullable|string|max:50|unique:users,npm',
            'nidn' => 'nullable|string|max:30|unique:users,nidn',
            'phone' => 'nullable|string|max:30',
            'address' => 'nullable|string|max:1000',
            'expertise' => 'nullable|string|max:2000',
            'position_title' => 'nullable|string|max:255',
            'position_start_date' => 'nullable|date',
            'position_end_date' => 'nullable|date|after_or_equal:position_start_date',
            'role' => 'required|in:admin,mahasiswa,dosen,tenaga_labor,kepala_labor,prodi,umum',
            'laboratory_id' => 'nullable|exists:laboratories,id',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($data['role'] === 'mahasiswa' && empty($data['npm'])) {
            return back()->withErrors(['npm' => 'NPM wajib diisi untuk akun mahasiswa.'])->withInput();
        }
        if ($data['role'] === 'dosen' && empty($data['nidn'])) {
            return back()->withErrors(['nidn' => 'NIDN wajib diisi untuk akun dosen.'])->withInput();
        }
        if ($data['role'] === 'dosen' && empty($data['expertise'])) {
            return back()->withErrors(['expertise' => 'Kepakaran wajib diisi untuk akun dosen.'])->withInput();
        }
        if ($data['role'] === 'prodi' && empty($data['position_title'])) {
            return back()->withErrors(['position_title' => 'Jabatan Prodi wajib diisi untuk akun Program Studi.'])->withInput();
        }
        if ($data['role'] === 'prodi' && empty($data['position_start_date'])) {
            return back()->withErrors(['position_start_date' => 'Tanggal mulai jabatan wajib diisi untuk akun Program Studi.'])->withInput();
        }
        if (in_array($data['role'], ['tenaga_labor', 'kepala_labor'], true) && empty($data['laboratory_id'])) {
            return back()->withErrors(['laboratory_id' => 'Laboratorium wajib dipilih untuk Tenaga Labor/Kepala Labor.'])->withInput();
        }

        if (! in_array($data['role'], ['tenaga_labor', 'kepala_labor'], true)) {
            $data['laboratory_id'] = null;
        }
        if ($data['role'] !== 'mahasiswa') {
            $data['npm'] = null;
        }
        if ($data['role'] !== 'dosen') {
            $data['nidn'] = $data['role'] === 'prodi' ? ($data['nidn'] ?? null) : null;
            $data['expertise'] = null;
        }
        if (! in_array($data['role'], ['dosen', 'prodi'], true)) {
            $data['position_title'] = null;
            $data['position_start_date'] = null;
            $data['position_end_date'] = null;
        }
        if ($data['role'] === 'dosen') {
            $data['phone'] = null;
            $data['address'] = null;
        }

        User::create($data);
        return redirect()->route('admin.users')->with('success', 'Akun baru berhasil dibuat oleh Admin.');
    }

    public function destroyUser(User $user)
    {
        if ($user->is(auth()->user())) {
            return back()->with('error', 'Akun Admin yang sedang digunakan tidak dapat dihapus.');
        }

        $user->delete();
        return back()->with('success', 'Akun berhasil dihapus.');
    }

    public function courses()
    {
        $courses = Course::orderBy('name')->get();
        return view('admin.courses', compact('courses'));
    }

    public function storeCourse(Request $request)
    {
        Course::create($request->validate([
            'code'=>'required|string|max:50|unique:courses,code',
            'name'=>'required|string|max:255',
            'credits'=>'nullable|integer',
            'description'=>'nullable|string'
        ]));
        return back()->with('success','Mata kuliah berhasil ditambahkan.');
    }

    public function destroyCourse(Course $course)
    {
        $course->delete();
        return back()->with('success','Mata kuliah berhasil dihapus.');
    }

    public function storeLaboratory(Request $request)
    {
        Laboratory::create($request->validate([
            'code'=>'nullable|string|max:50',
            'name'=>'required|string|max:255',
            'description'=>'nullable|string',
            'address'=>'nullable|string'
        ]));
        return back()->with('success','Laboratorium berhasil ditambahkan.');
    }

    public function destroyLaboratory(Laboratory $laboratory)
    {
        $laboratory->delete();
        return back()->with('success','Laboratorium berhasil dihapus.');
    }

    public function verifyClass(PracticumClass $class)
    {
        $class->update(['is_verified'=>true]);
        return back()->with('success','Kelas berhasil diverifikasi.');
    }

    public function destroyClass(PracticumClass $class)
    {
        $class->delete();
        return back()->with('success','Kelas berhasil dihapus.');
    }

    public function editUser(User $user)
    {
        $laboratories = Laboratory::orderBy('name')->get();
        return view('admin.user-form', compact('user', 'laboratories'));
    }

    public function updateUser(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required','email','max:255', Rule::unique('users','email')->ignore($user->id)],
            'npm' => ['nullable','string','max:50', Rule::unique('users','npm')->ignore($user->id)],
            'nidn' => ['nullable','string','max:30', Rule::unique('users','nidn')->ignore($user->id)],
            'phone' => 'nullable|string|max:30',
            'address' => 'nullable|string|max:1000',
            'expertise' => 'nullable|string|max:2000',
            'position_title' => 'nullable|string|max:255',
            'position_start_date' => 'nullable|date',
            'position_end_date' => 'nullable|date|after_or_equal:position_start_date',
            'role' => 'required|in:admin,mahasiswa,dosen,tenaga_labor,kepala_labor,prodi,umum',
            'laboratory_id' => 'nullable|exists:laboratories,id',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        if ($data['role'] === 'mahasiswa' && empty($data['npm'])) {
            return back()->withErrors(['npm' => 'NPM wajib diisi untuk akun mahasiswa.'])->withInput();
        }
        if ($data['role'] === 'dosen' && empty($data['nidn'])) {
            return back()->withErrors(['nidn' => 'NIDN wajib diisi untuk akun dosen.'])->withInput();
        }
        if ($data['role'] === 'dosen' && empty($data['expertise'])) {
            return back()->withErrors(['expertise' => 'Kepakaran wajib diisi untuk akun dosen.'])->withInput();
        }
        if ($data['role'] === 'prodi' && empty($data['position_title'])) {
            return back()->withErrors(['position_title' => 'Jabatan Ka/Sekretaris Program Studi wajib diisi.'])->withInput();
        }
        if ($data['role'] === 'prodi' && empty($data['position_start_date'])) {
            return back()->withErrors(['position_start_date' => 'Tanggal mulai jabatan Ka/Sekretaris Program Studi wajib diisi.'])->withInput();
        }
        if (in_array($data['role'], ['tenaga_labor', 'kepala_labor'], true) && empty($data['laboratory_id'])) {
            return back()->withErrors(['laboratory_id' => 'Laboratorium wajib dipilih untuk Tenaga Labor/Kepala Lab.'])->withInput();
        }

        if (! in_array($data['role'], ['tenaga_labor', 'kepala_labor'], true)) {
            $data['laboratory_id'] = null;
        }
        if ($data['role'] !== 'mahasiswa') {
            $data['npm'] = null;
        }
        if ($data['role'] !== 'dosen') {
            $data['nidn'] = $data['role'] === 'prodi' ? ($data['nidn'] ?? null) : null;
            $data['expertise'] = null;
        }
        if (! in_array($data['role'], ['dosen', 'prodi'], true)) {
            $data['position_title'] = null;
            $data['position_start_date'] = null;
            $data['position_end_date'] = null;
        }
        if ($data['role'] === 'dosen' && ($data['phone'] ?? null)) {
            $data['phone'] = null;
        }
        if ($data['role'] === 'dosen') {
            $data['address'] = null;
        }
        if (empty($data['password'])) {
            unset($data['password']);
        }

        $user->update($data);
        return redirect()->route('admin.users')->with('success', 'Data akun berhasil diperbarui.');
    }

    public function dashboard()
    {
        $testByCategory = TestingRequest::join('testing_services', 'testing_requests.testing_service_id', '=', 'testing_services.id')
            ->join('testing_categories', 'testing_services.testing_category_id', '=', 'testing_categories.id')
            ->select('testing_categories.name', DB::raw('COUNT(*) total'))
            ->groupBy('testing_categories.name')
            ->orderByDesc('total')
            ->get();

        $classChoices = PracticumClass::with('course')->withCount('registrations')->get();

        return view('admin.dashboard', [
            'studentCount' => User::where('role', 'mahasiswa')->count(),
            'activeClasses' => PracticumClass::where('is_active', true)->count(),
            'pendingRegistrations' => PracticumRegistration::where('status', 'pending_verification')->count(),
            'activeTests' => TestingRequest::whereIn('status', ['pending_sample', 'sample_received', 'testing'])->count(),
            'testByCategory' => $testByCategory,
            'classChoices' => $classChoices,
        ]);
    }

    public function classTypes()
    {
        $classTypes = PracticumClassType::orderBy('name')->get();
        return view('admin.class-types', compact('classTypes'));
    }

    public function storeClassType(Request $request)
    {
        $data = $request->validate([
            'code' => 'required|string|max:20|unique:practicum_class_types,code',
            'name' => 'required|string|max:100',
            'description' => 'nullable|string|max:500',
        ]);

        PracticumClassType::create($data);

        return redirect()->route('admin.class-types')->with('success', 'Tipe kelas berhasil ditambahkan.');
    }

    public function destroyClassType(PracticumClassType $classType)
    {
        $classType->delete();
        return redirect()->route('admin.class-types')->with('success', 'Tipe kelas berhasil dihapus.');
    }

    public function classes()
    {
        $classes = PracticumClass::with(['course', 'laboratory', 'lecturer', 'classType'])
            ->withCount(['registrations', 'finalRegistrations'])
            ->orderBy('day')
            ->get();
        return view('admin.classes', compact('classes'));
    }

    public function createClass()
    {
        return view('admin.class-form', [
            'class' => new PracticumClass,
            'courses' => Course::all(),
            'laboratories' => Laboratory::all(),
            'lecturers' => User::where('role', 'dosen')->get(),
        ]);
    }

    public function storeClass(Request $request)
    {
        PracticumClass::create($this->classData($request));
        return redirect()->route('admin.classes')->with('success', 'Jadwal/kelas praktikum berhasil ditambahkan.');
    }

    public function editClass(PracticumClass $class)
    {
        return view('admin.class-form', compact('class') + [
            'courses' => Course::all(),
            'laboratories' => Laboratory::all(),
            'lecturers' => User::where('role', 'dosen')->get(),
        ]);
    }

    public function updateClass(Request $request, PracticumClass $class)
    {
        $class->update($this->classData($request));
        return redirect()->route('admin.classes')->with('success', 'Jadwal/kelas berhasil diperbarui.');
    }

    private function classData(Request $request): array
    {
        $data = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'laboratory_id' => 'required|exists:laboratories,id',
            'lecturer_id' => 'nullable|exists:users,id',
            'class_type_id' => 'nullable|exists:practicum_class_types,id',
            'class_name' => 'required|string|max:20',
            'room' => 'required|string|max:100',
            'day' => 'required|string|max:20',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'practicum_date' => 'nullable|date',
            'enrollment_deadline' => 'nullable|date',
            'module_file' => 'nullable|file|mimes:pdf|max:10240',
            'capacity' => 'required|integer|min:1|max:300',
            'semester' => 'required|string|max:20',
            'academic_year' => 'required|string|max:20',
        ]);

        if ($request->hasFile('module_file')) {
            $data['module_path'] = $request->file('module_file')->store('modul-praktikum', 'public');
        }

        unset($data['module_file']);
        return $data;
    }

    public function registrations()
    {
        $registrations = PracticumRegistration::with([
            'student', 'preferredClass.course', 'preferredClass.laboratory',
            'finalClass', 'submissions.requirement',
        ])->latest()->get();
        $classes = PracticumClass::with('course')->where('is_active', true)->get();
        return view('admin.registrations', compact('registrations', 'classes'));
    }

    public function verifyRegistration(Request $request, PracticumRegistration $registration)
    {
        $data = $request->validate([
            'decision' => 'required|in:approved,rejected',
            'final_class_id' => 'nullable|required_if:decision,approved|exists:practicum_classes,id',
            'admin_note' => 'nullable|string|max:1000',
        ]);

        if ($data['decision'] === 'approved') {
            $target = PracticumClass::findOrFail($data['final_class_id']);
            $filled = $target->finalRegistrations()
                ->where('status', 'approved')
                ->where('id', '!=', $registration->id)
                ->count();
            if ($filled >= $target->capacity) {
                return back()->with('error', 'Kelas tujuan sudah penuh. Pilih kelas lain.');
            }
        }

        DB::transaction(function () use ($registration, $data, $request) {
            $registration->update([
                'status' => $data['decision'],
                'final_class_id' => $data['decision'] === 'approved' ? $data['final_class_id'] : null,
                'admin_note' => $data['admin_note'] ?? null,
                'verified_by' => $request->user()->id,
                'verified_at' => now(),
            ]);

            $registration->submissions()->update([
                'status' => $data['decision'] === 'approved' ? 'approved' : 'rejected',
                'verified_by' => $request->user()->id,
                'verified_at' => now(),
                'note' => $data['admin_note'] ?? null,
            ]);
        });

        return back()->with('success', 'Verifikasi pendaftaran praktikum diperbarui.');
    }

    public function letterTypes()
    {
        $types = LetterType::with(['requirements', 'workflowSteps', 'formFields'])
            ->withCount('requests')
            ->latest()
            ->get();
        return view('admin.letter-types', compact('types'));
    }

    public function createLetterType()
    {
        return view('admin.letter-type-form', [
            'type' => new LetterType,
            'hasRequests' => false,
        ]);
    }

    public function storeLetterType(Request $request)
    {
        $data = $this->validateLetterType($request);

        DB::transaction(function () use ($data, $request) {
            $type = LetterType::create($this->letterTypeDocumentData($data) + [
                'code' => strtoupper($data['code']),
                'title' => $data['title'],
                'description' => $data['description'] ?? null,
                'created_by' => $request->user()->id,
            ]);
            $this->syncLetterStructure($type, $data);
        });

        return redirect()->route('admin.letter-types')
            ->with('success', 'Jenis surat, template, data kebutuhan, dan workflow berhasil dibuat.');
    }

    public function editLetterType(LetterType $letterType)
    {
        $letterType->load(['requirements', 'workflowSteps', 'formFields']);
        return view('admin.letter-type-form', [
            'type' => $letterType,
            'hasRequests' => $letterType->requests()->exists(),
        ]);
    }

    public function updateLetterType(Request $request, LetterType $letterType)
    {
        $data = $this->validateLetterType($request, $letterType);
        $hasRequests = $letterType->requests()->exists();

        DB::transaction(function () use ($letterType, $data, $hasRequests) {
            $letterType->update($this->letterTypeDocumentData($data) + [
                'code' => strtoupper($data['code']),
                'title' => $data['title'],
                'description' => $data['description'] ?? null,
            ]);

            // Struktur tidak dihapus jika sudah ada riwayat surat agar data historis tetap aman.
            if (! $hasRequests) {
                $this->syncLetterStructure($letterType, $data);
            }
        });

        $message = $hasRequests
            ? 'Template surat berhasil diperbarui. Syarat, field, dan workflow tidak diubah karena jenis surat sudah memiliki riwayat pengajuan.'
            : 'Jenis surat dan seluruh strukturnya berhasil diperbarui.';

        return redirect()->route('admin.letter-types')->with('success', $message);
    }

    private function validateLetterType(Request $request, ?LetterType $type = null): array
    {
        $codeRule = Rule::unique('letter_types', 'code');
        if ($type) {
            $codeRule->ignore($type->id);
        }

        return $request->validate([
            'code' => ['required', 'string', 'max:30', $codeRule],
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:2000',
            'default_subject' => 'nullable|string|max:255',
            'attachment_text' => 'nullable|string|max:100',
            'body_template' => 'required|string|max:20000',
            'number_format' => 'required|string|max:150',
            'signatory_name' => 'required|string|max:255',
            'signatory_position' => 'required|string|max:255',
            'signatory_identifier' => 'nullable|string|max:100',
            'requirements' => 'nullable|array',
            'requirements.*' => 'nullable|string|max:255',
            'field_labels' => 'nullable|array',
            'field_labels.*' => 'nullable|string|max:255',
            'field_keys' => 'nullable|array',
            'field_keys.*' => ['nullable', 'string', 'max:80', 'regex:/^[a-z0-9_]+$/', 'distinct'],
            'field_types' => 'nullable|array',
            'field_types.*' => 'nullable|in:text,textarea,date,number',
            'field_placeholders' => 'nullable|array',
            'field_placeholders.*' => 'nullable|string|max:255',
            'field_required' => 'nullable|array',
            'workflow_roles' => 'required|array|min:1',
            'workflow_roles.*' => 'required|in:admin,mahasiswa,dosen,tenaga_labor,kepala_labor,prodi,umum',
            'workflow_labels' => 'required|array|min:1',
            'workflow_labels.*' => 'required|string|max:255',
        ]);
    }

    private function letterTypeDocumentData(array $data): array
    {
        return [
            'default_subject' => $data['default_subject'] ?? null,
            'attachment_text' => $data['attachment_text'] ?: '-',
            'body_template' => $data['body_template'],
            'number_format' => $data['number_format'] ?: '{seq}/{code}/{month_roman}/{year}',
            'signatory_name' => $data['signatory_name'],
            'signatory_position' => $data['signatory_position'],
            'signatory_identifier' => $data['signatory_identifier'] ?? null,
        ];
    }

    private function syncLetterStructure(LetterType $type, array $data): void
    {
        $type->requirements()->delete();
        $type->workflowSteps()->delete();
        $type->formFields()->delete();

        foreach (array_filter($data['requirements'] ?? []) as $requirement) {
            LetterRequirement::create([
                'letter_type_id' => $type->id,
                'title' => $requirement,
                'is_required' => true,
            ]);
        }

        $labels = $data['field_labels'] ?? [];
        $keys = $data['field_keys'] ?? [];
        $types = $data['field_types'] ?? [];
        $placeholders = $data['field_placeholders'] ?? [];
        $requiredIndexes = array_map('intval', array_keys($data['field_required'] ?? []));

        foreach ($labels as $index => $label) {
            if (! filled($label) || ! filled($keys[$index] ?? null)) {
                continue;
            }
            LetterFormField::create([
                'letter_type_id' => $type->id,
                'sort_order' => $index + 1,
                'field_key' => $keys[$index],
                'label' => $label,
                'input_type' => $types[$index] ?? 'text',
                'placeholder' => $placeholders[$index] ?? null,
                'is_required' => in_array($index, $requiredIndexes, true),
            ]);
        }

        foreach ($data['workflow_roles'] as $index => $role) {
            LetterWorkflowStep::create([
                'letter_type_id' => $type->id,
                'step_order' => $index + 1,
                'role' => $role,
                'label' => $data['workflow_labels'][$index] ?? ucwords(str_replace('_', ' ', $role)),
            ]);
        }
    }

    public function letterSettings()
    {
        $settings = LetterheadSetting::first() ?? new LetterheadSetting;
        return view('admin.letter-settings', compact('settings'));
    }

    public function updateLetterSettings(Request $request)
    {
        $data = $request->validate([
            'institution_name' => 'required|string|max:255',
            'faculty_name' => 'required|string|max:255',
            'unit_name' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:1000',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'website' => 'nullable|string|max:255',
            'city' => 'required|string|max:100',
            'logo' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'kop_image' => 'nullable|image|mimes:png,jpg,jpeg|max:4096',
        ]);

        $settings = LetterheadSetting::first() ?? new LetterheadSetting;

        if ($request->hasFile('logo')) {
            if ($settings->logo_path) {
                Storage::disk('public')->delete($settings->logo_path);
            }
            $data['logo_path'] = $request->file('logo')->store('letterhead', 'public');
        }
        unset($data['logo']);

        if ($request->hasFile('kop_image')) {
            if ($settings->header_image_path && ! str_starts_with($settings->header_image_path, 'images/')) {
                Storage::disk('public')->delete($settings->header_image_path);
            }
            $data['header_image_path'] = $request->file('kop_image')->store('letterhead', 'public');
        }
        unset($data['kop_image']);

        $settings->fill($data)->save();
        return back()->with('success', 'Pengaturan kop surat berhasil disimpan.');
    }

    public function services()
    {
        $categories = TestingCategory::with(['services.laboratory'])->get();
        $laboratories = Laboratory::all();
        return view('admin.services', compact('categories', 'laboratories'));
    }

    public function storeCategory(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'nullable|string',
        ]);
        TestingCategory::create([
            'name' => $data['name'],
            'slug' => Str::slug($data['name']) . '-' . Str::lower(Str::random(4)),
            'description' => $data['description'] ?? null,
        ]);
        return back()->with('success', 'Kategori pengujian ditambahkan.');
    }

    public function storeService(Request $request)
    {
        $data = $request->validate([
            'testing_category_id' => 'required|exists:testing_categories,id',
            'laboratory_id' => 'required|exists:laboratories,id',
            'code' => 'required|string|max:30|unique:testing_services,code',
            'name' => 'required|string|max:150',
            'description' => 'nullable|string',
            'requirements' => 'nullable|string',
        ]);
        TestingService::create($data);
        return back()->with('success', 'Jenis pengujian berhasil ditambahkan.');
    }
    public function testingWorkflow(TestingService $testingService)
    {
        $steps=$testingService->workflowSteps;
        return view('admin.testing-workflow', compact('testingService','steps'));
    }

    public function saveTestingWorkflow(Request $request, TestingService $testingService)
    {
        $request->validate(["roles"=>"required|array"]);
        TestingWorkflowStep::where("testing_service_id",$testingService->id)->delete();
        foreach($request->roles as $i=>$role){
            TestingWorkflowStep::create(["testing_service_id"=>$testingService->id,"step_order"=>$i+1,"role"=>$role]);
        }
        return back()->with("success","Alur pengujian berhasil diperbarui.");
    }

    public function laboratories()
    {
        $laboratories = Laboratory::orderBy('name')->get();
        return view('admin.laboratories', compact('laboratories'));
    }

    public function updateLaboratory(Request $request, Laboratory $laboratory)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:50',
            'description' => 'nullable|string|max:1000',
            'address' => 'nullable|string|max:1000',
        ]);
        $laboratory->update($data);
        return back()->with('success', 'Nama laboratorium berhasil diperbarui.');
    }

}
