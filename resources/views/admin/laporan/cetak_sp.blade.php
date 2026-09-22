<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Peringatan (SP) - {{ $siswa->nama_siswa }}</title>
    <style>
        body { font-family: 'Times New Roman', Times, serif; font-size: 13px; line-height: 1.5; margin: 40px; color: #000; }
        .header { text-align: center; border-bottom: 3px double #000; padding-bottom: 8px; margin-bottom: 20px; }
        .header h2 { margin: 0; font-size: 18px; text-transform: uppercase; }
        .header h3 { margin: 3px 0; font-size: 14px; font-weight: normal; }
        .header p { margin: 0; font-size: 11px; }
        .surat-title { text-align: center; margin-bottom: 20px; }
        .surat-title h4 { margin: 0; font-size: 15px; text-decoration: underline; text-transform: uppercase; }
        .surat-title p { margin: 2px 0 0 0; font-size: 12px; }
        table.meta { margin-bottom: 15px; width: 100%; border-collapse: collapse; }
        table.meta td { padding: 3px 5px; vertical-align: top; }
        table.data { width: 100%; border-collapse: collapse; margin: 15px 0; }
        table.data th, table.data td { border: 1px solid #000; padding: 5px 8px; text-align: left; font-size: 12px; }
        table.data th { background-color: #f2f2f2; text-align: center; }
        .sig-container { width: 100%; margin-top: 40px; }
        .sig-table { width: 100%; text-align: center; border-collapse: collapse; }
        .sig-table td { width: 50%; vertical-align: top; border: none; }
        .sig-space { height: 70px; }
        @media print {
            .no-print { display: none; }
        }
    </style>
</head>
<body>
    <div class="no-print" style="margin-bottom: 15px; text-align: right;">
        <button onclick="window.print()" style="padding: 8px 16px; background: #dc3545; color: #fff; border: none; border-radius: 4px; cursor: pointer;">Cetak Surat Peringatan</button>
    </div>

    {{-- KOP SURAT --}}
    <div class="header">
        <h2>{{ $settings->nama_sekolah }}</h2>
        <h3>TIM KEDISIPLINAN & TIM BK (BIMBINGAN KONSELING)</h3>
        <p>{{ $settings->alamat_sekolah }} | NPSN: {{ $settings->npsn }}</p>
    </div>

    {{-- JUDUL SURAT --}}
    <div class="surat-title">
        <h4>SURAT PERINGATAN KEDISIPLINAN SISWA</h4>
        <p>Nomor: SP/{{ date('Y') }}/{{ str_pad($siswa->id, 4, '0', STR_PAD_LEFT) }}</p>
    </div>

    <p>Kepada Yth.<br>
    Bapak/Ibu Orang Tua / Wali dari:<br>
    <strong>{{ $siswa->nama_orang_tua ?? 'Orang Tua Siswa' }}</strong><br>
    di Tempat</p>

    <p>Assalamu'alaikum Wr. Wb.</p>
    <p>Dengan ini kami beritahukan bahwa siswa yang tercantum di bawah ini:</p>

    <table class="meta">
        <tr>
            <td width="150"><strong>Nama Siswa</strong></td>
            <td width="10">:</td>
            <td><strong>{{ $siswa->nama_siswa }}</strong></td>
        </tr>
        <tr>
            <td><strong>NISN / NIS</strong></td>
            <td>:</td>
            <td>{{ $siswa->nis_nisn }}</td>
        </tr>
        <tr>
            <td><strong>Kelas</strong></td>
            <td>:</td>
            <td>{{ $siswa->kelas->nama_kelas ?? '-' }}</td>
        </tr>
        <tr>
            <td><strong>Total Akumulasi Poin</strong></td>
            <td>:</td>
            <td><strong style="color: red;">{{ $totalPoin }} Poin</strong></td>
        </tr>
        <tr>
            <td><strong>Status Tindakan / Sanksi</strong></td>
            <td>:</td>
            <td><strong><u>{{ $sanksi->tindakan ?? 'Peringatan Kedisiplinan' }}</u></strong></td>
        </tr>
    </table>

    <p>Telah mencatatkan akumulasi pelanggaran tata tertib madrasah dengan rincian riwayat sebagai berikut:</p>

    <table class="data">
        <thead>
            <tr>
                <th width="30">#</th>
                <th width="80">Tanggal</th>
                <th>Jenis Pelanggaran</th>
                <th width="40">Poin</th>
                <th>Sanksi / Tindak Lanjut</th>
            </tr>
        </thead>
        <tbody>
            @foreach($riwayatPelanggaran as $index => $r)
            <tr>
                <td style="text-align: center;">{{ $index + 1 }}</td>
                <td style="text-align: center;">{{ $r->tanggal ? $r->tanggal->format('d/m/Y') : '-' }}</td>
                <td>{{ $r->jenisPelanggaran->uraian_pelanggaran ?? '-' }}</td>
                <td style="text-align: center;">+{{ $r->poin }}</td>
                <td>{{ $r->tindak_lanjut ?? '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <p>Demikian surat pemberitahuan ini kami sampaikan agar menjadi perhatian dan pembinaan bersama demi kebaikan putra/putri Bapak/Ibu di sekolah. Atas perhatian dan kerja samanya kami ucapkan terima kasih.</p>
    <p>Wassalamu'alaikum Wr. Wb.</p>

    <div class="sig-container">
        <table class="sig-table">
            <tr>
                <td>
                    <p>Wali Kelas,</p>
                    <div class="sig-space"></div>
                    <p><strong><u>{{ $siswa->kelas->waliKelas->nama_lengkap ?? 'Wali Kelas' }}</u></strong><br>NIP. {{ $siswa->kelas->waliKelas->nip_nik ?? '-' }}</p>
                </td>
                <td>
                    <p>Mengetahui,<br>Kepala Sekolah</p>
                    <div class="sig-space"></div>
                    <p><strong><u>{{ $settings->nama_kepala_sekolah }}</u></strong><br>NIP. {{ $settings->nip_kepala_sekolah }}</p>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
