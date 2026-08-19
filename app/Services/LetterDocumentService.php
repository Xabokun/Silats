<?php

namespace App\Services;

use App\Models\LetterRequest;
use Carbon\Carbon;
use Carbon\CarbonInterface;

class LetterDocumentService
{
    public function renderBody(LetterRequest $letter): string
    {
        $letter->loadMissing(['letterType.formFields', 'applicant', 'laboratory', 'fieldValues']);

        $template = $letter->letterType->body_template ?: $this->defaultTemplate();
        $date = $letter->letter_date ?? now();

        $replacements = [
            '{{nama}}' => $letter->applicant?->name ?? '-',
            '{{npm}}' => $letter->applicant?->npm ?? '-',
            '{{email}}' => $letter->applicant?->email ?? '-',
            '{{telepon}}' => $letter->applicant?->phone ?? '-',
            '{{alamat}}' => $letter->applicant?->address ?? '-',
            '{{perihal}}' => $letter->subject ?: ($letter->letterType->default_subject ?? '-'),
            '{{laboratorium}}' => $letter->laboratory?->name ?? '-',
            '{{tanggal_pengajuan}}' => optional($letter->created_at)->translatedFormat('d F Y') ?? '-',
            '{{tanggal_surat}}' => $this->formatDate($date),
            '{{nomor_permohonan}}' => $letter->request_number,
            '{{nomor_surat}}' => $letter->official_number ?? 'DRAFT',
            '{{catatan}}' => $letter->notes ?: '-',
        ];

        foreach ($letter->fieldValues as $value) {
            $replacements['{{field:' . $value->field_key . '}}'] = (string) ($value->value ?? '-');
        }

        return strtr($template, $replacements);
    }

    public function makeOfficialNumber(LetterRequest $letter): string
    {
        $letter->loadMissing(['letterType', 'laboratory']);
        $date = $letter->letter_date ?? now();
        $year = (int) $date->format('Y');

        $sequence = LetterRequest::query()
            ->where('letter_type_id', $letter->letter_type_id)
            ->whereNotNull('official_number')
            ->whereYear('letter_date', $year)
            ->lockForUpdate()
            ->count() + 1;

        $format = $letter->letterType->number_format ?: '{seq}/{code}/{month_roman}/{year}';

        return strtr($format, [
            '{seq}' => str_pad((string) $sequence, 3, '0', STR_PAD_LEFT),
            '{code}' => strtoupper($letter->letterType->code),
            '{month}' => $date->format('m'),
            '{month_roman}' => $this->romanMonth((int) $date->format('n')),
            '{year}' => $date->format('Y'),
            '{lab}' => strtoupper($letter->laboratory?->code ?? 'FTS'),
        ]);
    }

    public function defaultTemplate(): string
    {
        return "Dengan hormat,\n\nDengan ini menerangkan bahwa:\n\nNama : {{nama}}\nNPM : {{npm}}\n\ntelah mengajukan keperluan surat terkait {{perihal}}.\n\nDemikian surat ini dibuat untuk dapat dipergunakan sebagaimana mestinya.";
    }

    private function romanMonth(int $month): string
    {
        return [1 => 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'][$month];
    }

    private function formatDate(CarbonInterface|string $date): string
    {
        return $date instanceof CarbonInterface
            ? $date->translatedFormat('d F Y')
            : Carbon::parse($date)->translatedFormat('d F Y');
    }
}
