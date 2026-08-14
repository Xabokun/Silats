<?php

namespace App\Http\Controllers;

use App\Models\Letter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LetterController extends Controller
{
    public function index(Request $request)
    {
        $letters = Letter::with('sender')
            ->whereHas('sender', fn ($query) => $query->where('laboratory_id', $request->user()->laboratory_id))
            ->latest('letter_date')
            ->paginate(10);

        return view('surat.index', compact('letters'));
    }

    public function create()
    {
        return view('surat.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'letter_number' => ['nullable', 'string', 'max:100'],
            'type' => ['required', 'in:masuk,keluar'],
            'subject' => ['required', 'string', 'max:255'],
            'recipient' => ['required', 'string', 'max:255'],
            'letter_date' => ['required', 'date'],
            'body' => ['nullable', 'string'],
            'status' => ['required', 'in:draft,diajukan,disetujui,arsip'],
            'attachment' => ['nullable', 'file', 'mimes:pdf,doc,docx', 'max:5120'],
        ]);

        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('letters', 'public');
        }

        Letter::create([
            'sender_id' => $request->user()->id,
            'letter_number' => $validated['letter_number'] ?? null,
            'type' => $validated['type'],
            'subject' => $validated['subject'],
            'recipient' => $validated['recipient'],
            'letter_date' => $validated['letter_date'],
            'body' => $validated['body'] ?? null,
            'attachment_path' => $attachmentPath,
            'status' => $validated['status'],
        ]);

        return redirect()->route('surat.index')->with('success', 'Surat berhasil disimpan.');
    }

    public function destroy(Request $request, Letter $letter)
    {
        $sameLab = $letter->sender()->where('laboratory_id', $request->user()->laboratory_id)->exists();
        abort_unless($sameLab, 403);

        if ($letter->attachment_path) {
            Storage::disk('public')->delete($letter->attachment_path);
        }

        $letter->delete();

        return back()->with('success', 'Surat berhasil dihapus.');
    }
}
