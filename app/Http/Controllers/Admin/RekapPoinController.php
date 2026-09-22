<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AturanSanksiKumulasi;
use App\Models\Kelas;
use App\Models\PelanggaranSiswa;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RekapPoinController extends Controller
{
    public function index(Request $request): View
    {
        $query = Siswa::aktif()->with('kelas')->withSum('pelanggaranSiswa as total_poin', 'poin');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_siswa', 'ILIKE', "%{$search}%")
                  ->orWhere('nis_nisn', 'ILIKE', "%{$search}%");
            });
        }

        if ($request->filled('kelas_id')) {
            $query->where('kelas_id', $request->kelas_id);
        }

        $siswaList = $query->orderByDesc('total_poin')->paginate(15)->withQueryString();

        $kelasList = Kelas::where('is_active', true)->orderBy('nama_kelas')->get();
        $aturanSanksi = AturanSanksiKumulasi::orderBy('min_poin')->get();

        return view('admin.rekap.index', compact('siswaList', 'kelasList', 'aturanSanksi'));
    }

    public function show(string $id): View
    {
        $siswa = Siswa::aktif()->with('kelas')->findOrFail($id);
        $riwayatPelanggaran = PelanggaranSiswa::with(['jenisPelanggaran.kategori', 'pelapor'])
            ->where('siswa_id', $siswa->id)
            ->orderByDesc('tanggal')
            ->get();

        $totalPoin = $riwayatPelanggaran->sum('poin');
        $sanksiBerlaku = AturanSanksiKumulasi::where('min_poin', '<=', $totalPoin)
            ->where('max_poin', '>=', $totalPoin)
            ->first();

        return view('admin.rekap.show', compact('siswa', 'riwayatPelanggaran', 'totalPoin', 'sanksiBerlaku'));
    }
}
