<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $isOfficial ? 'Surat Resmi' : 'Draft Surat' }} - {{ $letterRequest->request_number }}</title>
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; background: #e9ecef; font-family: "Times New Roman", serif; color: #111; }
        .toolbar { position: sticky; top: 0; z-index: 20; background: #fff; border-bottom: 1px solid #ddd; padding: 12px 18px; display:flex; gap:10px; justify-content:center; font-family: Arial, sans-serif; }
        .btn { display:inline-block; padding:9px 14px; border-radius:6px; text-decoration:none; border:1px solid #0d6efd; color:#0d6efd; background:#fff; cursor:pointer; font-size:14px; }
        .btn-primary { background:#0d6efd; color:#fff; }
        .paper { width: 210mm; min-height: 297mm; margin: 24px auto; background: #fff; padding: 18mm 20mm 20mm; position:relative; box-shadow:0 4px 24px rgba(0,0,0,.12); }
        .draft-watermark { position:absolute; left:50%; top:48%; transform:translate(-50%,-50%) rotate(-35deg); font-family:Arial,sans-serif; font-size:54px; font-weight:800; color:rgba(220,53,69,.13); white-space:nowrap; border:6px solid rgba(220,53,69,.13); padding:12px 24px; z-index:0; }
        .document-content { position:relative; z-index:1; }
        .letterhead { display:grid; grid-template-columns:95px 1fr 95px; align-items:center; text-align:center; gap:10px; }
        .logo { max-width:82px; max-height:82px; object-fit:contain; margin:auto; }
        .logo-placeholder { width:72px; height:72px; border:2px solid #111; border-radius:50%; display:flex; align-items:center; justify-content:center; font-weight:700; margin:auto; font-family:Arial,sans-serif; }
        .institution { font-size:15px; font-weight:700; text-transform:uppercase; }
        .faculty { font-size:18px; font-weight:700; text-transform:uppercase; margin-top:2px; }
        .unit { font-size:14px; font-weight:700; text-transform:uppercase; margin-top:2px; }
        .contact { font-size:11px; margin-top:5px; line-height:1.35; }
        .head-line { border:0; border-top:3px solid #111; border-bottom:1px solid #111; height:5px; margin:7px 0 20px; }
        .date { text-align:right; margin-bottom:12px; }
        table.meta { width:100%; border-collapse:collapse; margin-bottom:22px; }
        table.meta td { vertical-align:top; padding:2px 0; font-size:12pt; }
        table.meta td:first-child { width:85px; }
        table.meta td:nth-child(2) { width:18px; }
        .body { font-size:12pt; line-height:1.55; text-align:justify; white-space:pre-line; }
        .signature { width:45%; margin-left:auto; margin-top:32px; font-size:12pt; }
        .signature-space { height:72px; }
        .sign-name { font-weight:700; text-decoration:underline; }
        .status-note { margin-top:36px; border-top:1px dashed #aaa; padding-top:8px; font-family:Arial,sans-serif; font-size:10px; color:#666; }
        @media print {
            @page { size:A4; margin:0; }
            body { background:#fff; }
            .toolbar { display:none !important; }
            .paper { margin:0; box-shadow:none; width:210mm; min-height:297mm; }
        }
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
        <div class="letterhead">
            <div>
                @if($settings->logo_path)
                    <img class="logo" src="{{ asset('storage/'.$settings->logo_path) }}" alt="Logo">
                @else
                    <div class="logo-placeholder">FTS</div>
                @endif
            </div>
            <div>
                <div class="institution">{{ $settings->institution_name }}</div>
                <div class="faculty">{{ $settings->faculty_name }}</div>
                @if($settings->unit_name)<div class="unit">{{ $settings->unit_name }}</div>@endif
                <div class="contact">
                    @if($settings->address)<div>{{ $settings->address }}</div>@endif
                    <div>{{ collect([$settings->phone, $settings->email, $settings->website])->filter()->join(' • ') }}</div>
                </div>
            </div>
            <div></div>
        </div>
        <div class="head-line"></div>

        <div class="date">{{ $settings->city ?: 'Palu' }}, {{ ($letterRequest->letter_date ?? now())->translatedFormat('d F Y') }}</div>

        <table class="meta">
            <tr><td>Nomor</td><td>:</td><td>{{ $isOfficial ? $letterRequest->official_number : 'DRAFT / Belum diterbitkan' }}</td></tr>
            <tr><td>Lampiran</td><td>:</td><td>{{ $letterRequest->letterType->attachment_text ?: '-' }}</td></tr>
            <tr><td>Perihal</td><td>:</td><td><strong>{{ $letterRequest->subject }}</strong></td></tr>
        </table>

        <div class="body">{{ $body }}</div>

        <div class="signature">
            <div>{{ $settings->city ?: 'Palu' }}, {{ ($letterRequest->letter_date ?? now())->translatedFormat('d F Y') }}</div>
            <div>{{ $letterRequest->letterType->signatory_position ?: 'Pejabat Berwenang' }},</div>
            <div class="signature-space"></div>
            <div class="sign-name">{{ $letterRequest->letterType->signatory_name ?: '(Nama Penandatangan)' }}</div>
            @if($letterRequest->letterType->signatory_identifier)
                <div>{{ $letterRequest->letterType->signatory_identifier }}</div>
            @endif
        </div>

        <div class="status-note">
            {{ $isOfficial ? 'Dokumen resmi SILATS. Nomor permohonan: '.$letterRequest->request_number : 'Dokumen ini masih berupa draft dan belum sah sebagai surat resmi.' }}
        </div>
    </div>
</div>

<script>
if (location.hash === '#print') {
    window.addEventListener('load', () => setTimeout(() => window.print(), 300));
}
</script>
</body>
</html>
