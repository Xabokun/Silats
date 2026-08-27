<?php

namespace App\Http\Controllers;

use App\Models\{
    Laboratory,
    LetterFieldValue,
    LetterRequest,
    LetterRequestHistory,
    LetterRequirementSubmission,
    LetterType,
    LetterheadSetting
};
use App\Services\LetterDocumentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class LetterProcessController extends Controller
{
    public function __construct(private LetterDocumentService $documents)
    {
    }

    public function index(Request $request)
    {
        $user = $request->user();
        $query = LetterRequest::with(['letterType.workflowSteps', 'applicant', 'laboratory']);

        if (in_array($user->role, ['admin', 'prodi'], true)) {
            // Admin dan Prodi dapat memonitor seluruh pengurusan surat.
        } else {
            $query->where(function ($builder) use ($user) {
                $builder->where('applicant_id', $user->id)
                    ->orWhereHas('histories', function ($historyQuery) use ($user) {
                        $historyQuery->where('actor_id', $user->id);
                    })
                    ->orWhereHas('letterType.workflowSteps', function ($stepQuery) use ($user) {
                        $stepQuery->where('role', $user->role)
                            ->whereColumn('letter_workflow_steps.step_order', 'letter_requests.current_step_order');
                    });

                if (in_array($user->role, ['kepala_labor', 'tenaga_labor'], true)) {
                    $builder->orWhere('laboratory_id', $user->laboratory_id);
                }
            });
        }

        $requests = $query->latest()->get();
        $pendingLetters = (clone $query)->where('status', 'in_process')->latest()->get();

        return view('surat.index', compact('requests', 'pendingLetters'));
    }

    public function create()
    {
        return view('surat.create', [
            'types' => LetterType::with(['requirements', 'workflowSteps', 'formFields'])
                ->where('is_active', true)
                ->get(),
            'laboratories' => Laboratory::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $base = $request->validate([
            'letter_type_id' => 'required|exists:letter_types,id',
            'laboratory_id' => 'nullable|exists:laboratories,id',
            'subject' => 'nullable|string|max:255',
            'notes' => 'nullable|string|max:2000',
        ]);

        $type = LetterType::with(['requirements', 'workflowSteps', 'formFields'])
            ->findOrFail($base['letter_type_id']);

        abort_if($type->workflowSteps->isEmpty(), 422, 'Jenis surat belum memiliki alur.');

        foreach ($type->requirements->where('is_required', true) as $requirement) {
            $request->validate([
                'letter_req_' . $requirement->id => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            ]);
        }

        $fieldRules = [];
        foreach ($type->formFields as $field) {
            $name = 'letter_field_' . $field->id;
            $rules = [$field->is_required ? 'required' : 'nullable'];

            $rules[] = match ($field->input_type) {
                'date' => 'date',
                'number' => 'numeric',
                default => 'string|max:5000',
            };

            $fieldRules[$name] = $rules;
        }
        $request->validate($fieldRules);

        $letter = null;

        DB::transaction(function () use ($request, $base, $type, &$letter) {
            $letter = LetterRequest::create([
                'letter_type_id' => $type->id,
                'laboratory_id' => $base['laboratory_id'] ?? null,
                'subject' => $base['subject'] ?: ($type->default_subject ?: $type->title),
                'notes' => $base['notes'] ?? null,
                'request_number' => 'SRT-' . now()->format('Ymd') . '-' . strtoupper(Str::random(5)),
                'applicant_id' => $request->user()->id,
                'status' => 'in_process',
                'current_step_order' => $type->workflowSteps->first()->step_order,
            ]);

            foreach ($type->requirements as $requirement) {
                $input = 'letter_req_' . $requirement->id;
                if ($request->hasFile($input)) {
                    $path = $request->file($input)->store('surat-syarat', 'public');
                    LetterRequirementSubmission::create([
                        'letter_request_id' => $letter->id,
                        'letter_requirement_id' => $requirement->id,
                        'file_path' => $path,
                    ]);
                }
            }

            foreach ($type->formFields as $field) {
                LetterFieldValue::create([
                    'letter_request_id' => $letter->id,
                    'letter_form_field_id' => $field->id,
                    'field_key' => $field->field_key,
                    'label' => $field->label,
                    'value' => $request->input('letter_field_' . $field->id),
                ]);
            }

            LetterRequestHistory::create([
                'letter_request_id' => $letter->id,
                'step_order' => null,
                'action' => 'submitted',
                'actor_id' => $request->user()->id,
                'actor_role' => $request->user()->role,
                'notes' => 'Permohonan surat dibuat dan draft surat tergenerate.',
            ]);

            // Jika tahap awal adalah role pemohon, tahap tersebut dianggap terpenuhi saat pengajuan dikirim.
            $steps = $type->workflowSteps->values();
            $currentIndex = 0;
            while (isset($steps[$currentIndex]) && $steps[$currentIndex]->role === $request->user()->role) {
                $step = $steps[$currentIndex];
                LetterRequestHistory::create([
                    'letter_request_id' => $letter->id,
                    'step_order' => $step->step_order,
                    'action' => 'approve',
                    'actor_id' => $request->user()->id,
                    'actor_role' => $request->user()->role,
                    'notes' => 'Tahap pengajuan pemohon selesai otomatis saat surat dikirim.',
                ]);
                $currentIndex++;
            }

            if (isset($steps[$currentIndex])) {
                $letter->update(['current_step_order' => $steps[$currentIndex]->step_order]);
            } else {
                $this->publish($letter);
            }
        });

        return redirect()->route('surat.show', $letter)
            ->with('success', 'Permohonan surat berhasil dibuat. Draft surat sudah tersedia.');
    }

    public function show(Request $request, LetterRequest $letterRequest)
    {
        $this->authorizeView($request, $letterRequest);
        $letterRequest->load([
            'letterType.workflowSteps', 'letterType.requirements', 'letterType.formFields',
            'applicant', 'laboratory', 'histories.actor', 'files.requirement', 'fieldValues',
        ]);

        $current = $letterRequest->letterType->workflowSteps
            ->firstWhere('step_order', $letterRequest->current_step_order);

        return view('surat.show', compact('letterRequest', 'current'));
    }

    public function action(Request $request, LetterRequest $letterRequest)
    {
        $this->authorizeView($request, $letterRequest);

        $data = $request->validate([
            'action' => 'required|in:approve,reject',
            'notes' => 'nullable|string|max:1000',
        ]);

        $letterRequest->load('letterType.workflowSteps');
        $current = $letterRequest->letterType->workflowSteps
            ->firstWhere('step_order', $letterRequest->current_step_order);

        abort_unless(
            $current && ($current->role === $request->user()->role || $request->user()->isRole('admin')),
            403,
            'Surat belum berada pada tahapan role Anda.'
        );

        DB::transaction(function () use ($request, $data, $letterRequest, $current) {
            LetterRequestHistory::create([
                'letter_request_id' => $letterRequest->id,
                'step_order' => $current->step_order,
                'action' => $data['action'],
                'actor_id' => $request->user()->id,
                'actor_role' => $request->user()->role,
                'notes' => $data['notes'] ?? null,
            ]);

            if ($data['action'] === 'reject') {
                $letterRequest->update(['status' => 'rejected']);
                return;
            }

            $next = $letterRequest->letterType->workflowSteps
                ->first(fn ($step) => $step->step_order > $current->step_order);

            if ($next) {
                $letterRequest->update(['current_step_order' => $next->step_order]);
            } else {
                $this->publish($letterRequest);
            }
        });

        return back()->with('success', 'Tahapan surat berhasil diproses.');
    }

    public function document(Request $request, LetterRequest $letterRequest)
    {
        $this->authorizeView($request, $letterRequest);

        $letterRequest->load([
            'letterType', 'letterType.formFields', 'applicant', 'laboratory', 'fieldValues',
        ]);

        $settings = LetterheadSetting::first() ?? new LetterheadSetting([
            'institution_name' => 'UNIVERSITAS ISLAM RIAU',
            'faculty_name' => 'PROGRAM STUDI TEKNIK SIPIL',
            'unit_name' => 'PROGRAM STUDI TEKNIK SIPIL',
            'city' => 'Pekanbaru',
            'header_image_path' => null,
        ]);

        $isOfficial = $letterRequest->status === 'completed' && filled($letterRequest->official_number);
        $body = $isOfficial && filled($letterRequest->generated_body)
            ? $letterRequest->generated_body
            : $this->documents->renderBody($letterRequest);

        $headerImageUrl = $settings->header_image_path
            ? asset('storage/' . $settings->header_image_path)
            : asset('images/kop-ft-uir.jpg');
        $date = $letterRequest->letter_date ?? now();
        $gregorianDate = $date->translatedFormat('d F Y');
        $hijriDate = $this->documents->formatHijriDate($date, $settings->city ?: 'Pekanbaru');

        return view('surat.document', compact(
            'letterRequest', 'settings', 'isOfficial', 'body', 'headerImageUrl',
            'gregorianDate', 'hijriDate'
        ));
    }

    private function publish(LetterRequest $letter): void
    {
        $letter->update([
            'status' => 'completed',
            'letter_date' => today(),
            'completed_at' => now(),
            'published_at' => now(),
        ]);

        $letter->loadMissing(['letterType', 'applicant', 'laboratory', 'fieldValues']);
        $number = $this->documents->makeOfficialNumber($letter);
        $letter->update(['official_number' => $number]);
        $letter->refresh();
        $letter->loadMissing(['letterType', 'applicant', 'laboratory', 'fieldValues']);
        $letter->update(['generated_body' => $this->documents->renderBody($letter)]);

        LetterRequestHistory::create([
            'letter_request_id' => $letter->id,
            'step_order' => null,
            'action' => 'published',
            'actor_id' => null,
            'actor_role' => 'system',
            'notes' => 'Seluruh tahapan disetujui. Nomor surat resmi diterbitkan: ' . $number,
        ]);
    }

    private function authorizeView(Request $request, LetterRequest $letter): void
    {
        $user = $request->user();

        if (in_array($user->role, ['admin', 'prodi'], true)) {
            return;
        }
        if ($letter->applicant_id === $user->id) {
            return;
        }

        if ($letter->histories()->where('actor_id', $user->id)->exists()) {
            return;
        }

        $letter->loadMissing('letterType.workflowSteps');
        $current = $letter->letterType->workflowSteps
            ->firstWhere('step_order', $letter->current_step_order);
        if ($letter->status === 'in_process' && $current?->role === $user->role) {
            return;
        }

        if (
            in_array($user->role, ['tenaga_labor', 'kepala_labor'], true)
            && $letter->laboratory_id === $user->laboratory_id
        ) {
            return;
        }

        abort(403);
    }
}
