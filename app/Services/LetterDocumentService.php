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
            '{{nidn}}' => $letter->applicant?->nidn ?? '-',
            '{{kepakaran}}' => $letter->applicant?->expertise ?? '-',
            '{{jabatan}}' => $letter->applicant?->position_title ?? '-',
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



    public function formatHijriDate(CarbonInterface|string $date, string $city = 'Pekanbaru'): string
    {
        $date = $date instanceof CarbonInterface ? $date : Carbon::parse($date);
        [$day, $month, $year] = $this->gregorianToHijri((int) $date->format('Y'), (int) $date->format('n'), (int) $date->format('j'));
        $months = [
            1 => 'Muharram', 2 => 'Safar', 3 => 'Rabiul Awal', 4 => 'Rabiul Akhir',
            5 => 'Jumadil Awal', 6 => 'Jumadil Akhir', 7 => 'Rajab', 8 => 'Syaban',
            9 => 'Ramadan', 10 => 'Syawal', 11 => 'Zulkaidah', 12 => 'Zulhijah',
        ];
        return sprintf('%s, %02d %s %d H', $city, $day, $months[$month] ?? '', $year);
    }

    private function gregorianToHijri(int $gy, int $gm, int $gd): array
    {
        // UIR reference document provided for this project uses 18 Aug 2026 = 05 Rabiul Awal 1448 H.
        // Shift the civil/tabular conversion by one day to match that convention.
        $jd = $this->gregorianToJulianDay($gy, $gm, $gd) + 1;
        $l = $jd - 1948440 + 10632;
        $n = intdiv($l - 1, 10631);
        $l = $l - 10631 * $n + 354;
        $j = (int) ((10985 - $l) / 5316) * (int) ((50 * $l) / 17719)
            + (int) ($l / 5670) * (int) ((43 * $l) / 15238);
        $l = $l - (int) ((30 - $j) / 15) * (int) ((17719 * $j) / 50)
            - (int) ($j / 16) * (int) ((15238 * $j) / 43) + 29;
        $m = (int) ((24 * $l) / 709);
        $d = $l - (int) ((709 * $m) / 24);
        $y = 30 * $n + $j - 30;
        return [$d, $m, $y];
    }

    private function gregorianToJulianDay(int $y, int $m, int $d): int
    {
        $a = intdiv(14 - $m, 12);
        $y2 = $y + 4800 - $a;
        $m2 = $m + 12 * $a - 3;
        return $d + intdiv(153 * $m2 + 2, 5) + 365 * $y2 + intdiv($y2, 4)
            - intdiv($y2, 100) + intdiv($y2, 400) - 32045;
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
