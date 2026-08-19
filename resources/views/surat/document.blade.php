<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $isOfficial ? 'Surat Resmi' : 'Draft Surat' }} - {{ $letterRequest->request_number }}</title>
    <style>
        *{box-sizing:border-box}
        body{margin:0;background:#e5e7eb;color:#111;font-family:"Times New Roman",serif}
        .toolbar{position:sticky;top:0;z-index:30;background:#fff;border-bottom:1px solid #d1d5db;padding:10px 16px;display:flex;gap:10px;justify-content:center;font-family:Arial,sans-serif}
        .btn{display:inline-block;padding:9px 14px;border-radius:6px;text-decoration:none;border:1px solid #1d4ed8;color:#1d4ed8;background:#fff;cursor:pointer;font-size:14px}
        .btn-primary{background:#1d4ed8;color:#fff}
        .paper{width:210mm;min-height:297mm;margin:20px auto;background:#fff;padding:16mm 19mm 18mm;position:relative;box-shadow:0 4px 24px rgba(0,0,0,.12)}
        .draft-watermark{position:absolute;left:50%;top:48%;transform:translate(-50%,-50%) rotate(-35deg);font-family:Arial,sans-serif;font-size:48px;font-weight:800;color:rgba(220,53,69,.12);white-space:nowrap;border:5px solid rgba(220,53,69,.12);padding:10px 22px;z-index:0}
        .document-content{position:relative;z-index:1}
        .header-image{display:block;width:100%;height:auto;max-height:47mm;object-fit:contain;object-position:left top;margin:0 0 7mm}
        .date{font-size:12pt;line-height:1.4;text-align:right;margin:0 0 8mm}
        .meta{width:100%;border-collapse:collapse;margin-bottom:13mm;font-size:12pt}
        .meta td{padding:0 0 2px;vertical-align:top}
        .meta td:first-child{width:25mm}
        .meta td:nth-child(2){width:5mm;text-align:center}
        .body{font-size:12pt;line-height:1.55;text-align:justify;white-space:pre-line}
        .signature{width:45%;margin-left:auto;margin-top:28mm;font-size:12pt;text-align:left}
        .signature-space{height:26mm}
        .sign-name{font-weight:700;text-decoration:underline}
        .status-note{margin-top:20mm;border-top:1px dashed #aaa;padding-top:6px;font-family:Arial,sans-serif;font-size:9.5px;color:#666}
        @media(max-width:991px){.paper{width:100%;min-height:auto;margin:0;padding:14mm 12mm 16mm}.header-image{max-height:none}.signature{width:54%}}
        @media print{ @page{size:A4;margin:0} body{background:#fff}.toolbar{display:none!important}.paper{margin:0;box-shadow:none;width:210mm;min-height:297mm;padding:16mm 19mm 18mm}.status-note{display:none} }
    </style>
</head>
<body>
<div class="toolbar">
    <a class="btn" href="{{ route('surat.show', $letterRequest) }}">Kembali ke Tracking</a>
    <button class="btn btn-primary" onclick="window.print()">{{ $isOfficial ? 'Cetak / Simpan PDF' : 'Cetak Draft' }}</button>
</div>

<div class="paper">
    @unless($isOfficial)<div class="draft-watermark">DRAFT • BELUM DISAHKAN</div>@endunless
    <div class="document-content">
        <img class="header-image" src="{{ $headerImageUrl }}" alt="Kop Surat Fakultas Teknik">

        <div class="date">
            <div>{{ $settings->city ?: 'Pekanbaru' }}, {{ $gregorianDate }}</div>
            <div>{{ $hijriDate }}</div>
        </div>

        <table class="meta">
            <tr><td>Nomor</td><td>:</td><td>{{ $isOfficial ? $letterRequest->official_number : 'DRAFT / Belum diterbitkan' }}</td></tr>
            <tr><td>Lampiran</td><td>:</td><td>{{ $letterRequest->letterType->attachment_text ?: '-' }}</td></tr>
            <tr><td>Perihal</td><td>:</td><td><strong>{{ $letterRequest->subject }}</strong></td></tr>
        </table>

        <div class="body">{{ $body }}</div>

        <div class="signature">
            <div>Hormat Kami,</div>
            <div>{{ $letterRequest->letterType->signatory_position ?: 'Pejabat Berwenang' }}</div>
            <div class="signature-space"></div>
            <div class="sign-name">{{ $letterRequest->letterType->signatory_name ?: '(Nama Penandatangan)' }}</div>
            @if($letterRequest->letterType->signatory_identifier)
                <div>NIDN. {{ preg_replace('/^NIDN\.\s*/i', '', $letterRequest->letterType->signatory_identifier) }}</div>
            @endif
        </div>

        <div class="status-note">
            {{ $isOfficial ? 'Dokumen resmi SILATS. Nomor permohonan: '.$letterRequest->request_number : 'Dokumen ini masih berupa draft dan belum sah sebagai surat resmi.' }}
        </div>
    </div>
</div>

<script>
if (location.hash === '#print') { window.addEventListener('load', () => setTimeout(() => window.print(), 300)); }
</script>
</body>
</html>
