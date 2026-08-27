<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Surat Lolos Praktikum - {{ $registration->student->name }}</title>
    <style>
        *{box-sizing:border-box} body{margin:0;background:#e5e7eb;color:#111;font-family:"Times New Roman",serif}.toolbar{padding:12px;text-align:center;background:#fff;border-bottom:1px solid #d1d5db;font-family:Arial,sans-serif}.toolbar button{padding:9px 16px;border:1px solid #1d4ed8;border-radius:5px;background:#1d4ed8;color:#fff;cursor:pointer}.paper{width:210mm;min-height:297mm;margin:20px auto;padding:20mm 22mm;background:#fff;box-shadow:0 4px 24px rgba(0,0,0,.12)}.header{text-align:center;border-bottom:3px double #111;padding-bottom:8px;margin-bottom:28px}.header h1{font-size:18pt;margin:0 0 4px}.header p{margin:2px 0;font-size:11pt}.title{text-align:center;text-decoration:underline;font-size:14pt;margin:20px 0 4px}.number{text-align:center;margin-bottom:28px}.body{font-size:12pt;line-height:1.7;text-align:justify}.data{width:100%;margin:15px 0 20px;border-collapse:collapse}.data td{padding:4px 0}.data td:first-child{width:38%}.data td:nth-child(2){width:4%;text-align:center}.signature{width:45%;margin:38px 0 0 auto;text-align:center;font-size:12pt}.space{height:70px}.signature strong{text-decoration:underline}.stamp{margin-top:35px;border:1px dashed #777;padding:8px;font-family:Arial,sans-serif;font-size:9pt;text-align:center;color:#555}.note{margin-top:28px;font:9pt Arial,sans-serif;color:#555}@media(max-width:991px){.paper{width:100%;margin:0;min-height:auto;padding:14mm 12mm}}@media print{body{background:#fff}.toolbar{display:none}.paper{width:210mm;min-height:297mm;margin:0;box-shadow:none}}
    </style>
</head>
<body>
<div class="toolbar"><button onclick="window.print()">Download / Cetak PDF</button></div>
<div class="paper">
    <div class="header">
        <h1>{{ $registration->finalClass->laboratory->name }}</h1>
        <p>SILATS - Sistem Informasi Laboratorium Teknik Sipil</p>
    </div>
    <div class="title">SURAT KETERANGAN LOLOS PRAKTIKUM</div>
    <div class="number">Nomor: {{ 'SLP/'.str_pad($registration->id, 4, '0', STR_PAD_LEFT).'/'.now()->format('Y') }}</div>
    <div class="body">
        <p>Yang bertanda tangan di bawah ini, Kepala Laboratorium {{ $registration->finalClass->laboratory->name }}, menerangkan bahwa:</p>
        <table class="data">
            <tr><td>Nama</td><td>:</td><td>{{ $registration->student->name }}</td></tr>
            <tr><td>NPM</td><td>:</td><td>{{ $registration->student->npm ?: '-' }}</td></tr>
            <tr><td>Judul Praktikum</td><td>:</td><td>{{ $registration->finalClass->course->name }}</td></tr>
            <tr><td>Nilai Akhir</td><td>:</td><td><strong>{{ number_format((float) $registration->final_score, 2, ',', '.') }}</strong></td></tr>
        </table>
        <p>Mahasiswa tersebut dinyatakan <strong>LOLOS PRAKTIKUM</strong> karena memperoleh nilai akhir minimal 61.</p>
        <p>Demikian surat keterangan ini dibuat untuk dapat dipergunakan sebagaimana mestinya.</p>
    </div>
    <div class="signature">
        <div>{{ $registration->finalClass->laboratory->name }}, {{ now()->translatedFormat('d F Y') }}</div>
        <div>Kepala Laboratorium</div>
        <div class="space"></div>
        <strong>{{ $head?->name ?: '(Nama Kepala Laboratorium)' }}</strong>
        @if($head?->nidn)<div>NIDN. {{ $head->nidn }}</div>@endif
    </div>
    <div class="stamp">CAP BASAH LABORATORIUM WAJIB DIBUBUHKAN AGAR SURAT INI SAH.</div>
    <div class="note">Dokumen ini tersedia setelah nilai akhir diinput oleh tenaga laboratorium dan mahasiswa dinyatakan lulus.</div>
</div>
</body>
</html>
