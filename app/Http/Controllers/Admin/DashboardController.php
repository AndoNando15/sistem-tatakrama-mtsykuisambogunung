<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalSiswa = DB::table('siswa')->where('is_active', true)->count();
        $totalUsers = DB::table('users')->where('is_active', true)->count();
        $totalAturan = DB::table('jenis_pelanggaran')->where('is_active', true)->count();

        return view('admin.dashboard', compact('totalSiswa', 'totalUsers', 'totalAturan'));
    }
}