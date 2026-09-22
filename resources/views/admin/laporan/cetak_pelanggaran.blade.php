<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Rekapitulasi Pelanggaran Siswa - {{ $settings->nama_sekolah }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; margin: 20px; color: #333; }
        .header { text-align: center; border-bottom: 3px double #000; padding-bottom: 10px; margin-bottom: 20px; }
        .header h2 { margin: 0; font-size: 18px; text-transform: uppercase; }
        .header h3 { margin: 5px 0; font-size: 14px; font-weight: normal; }
        .header p { margin: 0; font-size: 11px; color: #555; }
        .title { text-align: center; font-size: 14px; font-weight: bold; margin-bottom: 15px; text-decoration: underline; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #333; padding: 6px 8px; text-align: left; }
        th { background-color: #f2f2f2; text-align: center; }
        .text-center { text-align: center; }
        .footer-sig { width: 100%; margin-top: 30px; display: flex; justify-content: space-between; page-break-inside: avoid; }
        .sig-box { width: 40%; text-align: center; }
        .sig-space { height: 60px; }
        @media print {
            .no-print { display: none; }
        }
    </style>
</head>
<body>
    <div class="no-print" style="margin-bottom: 15px; text-align: right;">
        <button onclick="window.print()" style="padding: 8px 16px; background: #0d6efd; color: #fff; border: none; border-radius: 4px; cursor: pointer;">Cetak Dokumen</button>
    </div>

    {{-- KOP SURAT --}}
    <div class="header">
        <h2>{{ $settings->nama_sekolah }}</h2>
        <h3>SISTEM INFORMASI TATAKRAMA & KEDISIPLINAN SISWA</h3>
        <p>{{ $settings->alamat_sekolah }} | NPSN: {{ $settings->npsn }}</p>
    </div>

    <div class="title">LAPORAN REKAPITULASI PELANGGARAN SISWA</div>

    <table>
        <thead>
            <tr>
                <th width="30">#</th>
                <th width="80">Tanggal</th>
                <th>NISN</th>
                <th>Nama Siswa</th>
                <th>Kelas</th>
                <th>Jenis Pelanggaran</th>
                <th width="40">Poin</th>
                <th>Tindak Lanjut</th>
            </tr>
        </thead>
        <tbody>
            @forelse($laporanList as $index => $row)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td class="text-center">{{ $row->tanggal ? $row->tanggal->format('d/m/Y') : '-' }}</td>
                <td>{{ $row->siswa->nis_nisn ?? '-' }}</td>
                <td><strong>{{ $row->siswa->nama_siswa ?? '-' }}</strong></td>
                <td class="text-center">{{ $row->siswa->kelas->nama_kelas ?? '-' }}</td>
                <td>{{ $row->jenisPelanggaran->uraian_pelanggaran ?? '-' }}</td>
                <td class="text-center"><strong>+{{ $row->poin }}</strong></td>
                <td>{{ $row->tindak_lanjut ?? '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="text-center">Tidak ada data laporan.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top: 20px; float: right; width: 300px; text-align: center;">
        <p>Dicetak Pada: {{ date('d F Y') }}</p>
        <p>Kepala Sekolah,</p>
        <div style="height: 60px;"></div>
        <p><strong><u>{{ $settings->nama_kepala_sekolah }}</u></strong><br>NIP. {{ $settings->nip_kepala_sekolah }}</p>
    </div>
</body>
</html>
