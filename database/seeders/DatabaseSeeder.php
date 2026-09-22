<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // ==========================================
        // 1. SEED ROLES
        // ==========================================
        $adminRoleId = DB::table('roles')->insertGetId([
            'nama_role'  => 'admin',
            'keterangan' => 'Administrator Utama Sistem',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $guruRoleId = DB::table('roles')->insertGetId([
            'nama_role'  => 'guru',
            'keterangan' => 'Guru Pengajar / Pendidik',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $walikelasRoleId = DB::table('roles')->insertGetId([
            'nama_role'  => 'wali_kelas',
            'keterangan' => 'Wali Kelas',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $kepsekRoleId = DB::table('roles')->insertGetId([
            'nama_role'  => 'kepsek',
            'keterangan' => 'Kepala Madrasah / Pimpinan',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        // ==========================================
        // 2. SEED USERS (ADMIN & GURU)
        // ==========================================
        $adminUserId = DB::table('users')->insertGetId([
            'name'         => 'Maf’ulah, S.Pd.I',
            'nama_lengkap' => 'Maf’ulah, S.Pd.I',
            'username'     => 'admin',
            'email'        => 'admin@mtsykuisambogunung.sch.id',
            'password'     => Hash::make('admin123'),
            'nip_nik'      => '-',
            'no_hp'        => '081234567890',
            'is_active'    => true,
            'created_at'   => now(),
            'updated_at'   => now()
        ]);

        $guru1Id = DB::table('users')->insertGetId([
            'name'         => 'Ahmad Fauzi, S.Pd',
            'nama_lengkap' => 'Ahmad Fauzi, S.Pd',
            'username'     => 'guru_fauzi',
            'email'        => 'fauzi@sekolah.sch.id',
            'password'     => Hash::make('password123'),
            'nip_nik'      => '198505122010011002',
            'no_hp'        => '081298765432',
            'is_active'    => true,
            'created_at'   => now(),
            'updated_at'   => now()
        ]);

        $guru2Id = DB::table('users')->insertGetId([
            'name'         => 'Siti Aminah, S.Ag',
            'nama_lengkap' => 'Siti Aminah, S.Ag',
            'username'     => 'guru_aminah',
            'email'        => 'aminah@sekolah.sch.id',
            'password'     => Hash::make('password123'),
            'nip_nik'      => '198803152012022001',
            'no_hp'        => '081387654321',
            'is_active'    => true,
            'created_at'   => now(),
            'updated_at'   => now()
        ]);

        $guru3Id = DB::table('users')->insertGetId([
            'name'         => 'Budi Santoso, M.Pd',
            'nama_lengkap' => 'Budi Santoso, M.Pd',
            'username'     => 'guru_budi',
            'email'        => 'budi@sekolah.sch.id',
            'password'     => Hash::make('password123'),
            'nip_nik'      => '199107202015031003',
            'no_hp'        => '081456789012',
            'is_active'    => true,
            'created_at'   => now(),
            'updated_at'   => now()
        ]);

        // Assign Roles
        DB::table('user_roles')->insert([
            ['user_id' => $adminUserId, 'role_id' => $adminRoleId,    'created_at' => now(), 'updated_at' => now()],
            ['user_id' => $guru1Id,     'role_id' => $guruRoleId,      'created_at' => now(), 'updated_at' => now()],
            ['user_id' => $guru1Id,     'role_id' => $walikelasRoleId, 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => $guru2Id,     'role_id' => $guruRoleId,      'created_at' => now(), 'updated_at' => now()],
            ['user_id' => $guru2Id,     'role_id' => $walikelasRoleId, 'created_at' => now(), 'updated_at' => now()],
            ['user_id' => $guru3Id,     'role_id' => $guruRoleId,      'created_at' => now(), 'updated_at' => now()],
            ['user_id' => $guru3Id,     'role_id' => $walikelasRoleId, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // ==========================================
        // 3. SEED TAHUN AJARAN
        // ==========================================
        DB::table('tahun_ajaran')->insert([
            ['tahun' => '2024/2025', 'semester' => 'ganjil', 'is_active' => false, 'created_at' => now(), 'updated_at' => now()],
            ['tahun' => '2024/2025', 'semester' => 'genap',  'is_active' => false, 'created_at' => now(), 'updated_at' => now()],
            ['tahun' => '2025/2026', 'semester' => 'ganjil', 'is_active' => true,  'created_at' => now(), 'updated_at' => now()],
            ['tahun' => '2025/2026', 'semester' => 'genap',  'is_active' => false, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // ==========================================
        // 4. SEED MATA PELAJARAN
        // ==========================================
        $mapelList = [
            ['kode_mapel' => 'MTK-01', 'nama_mapel' => 'Matematika'],
            ['kode_mapel' => 'BIN-01', 'nama_mapel' => 'Bahasa Indonesia'],
            ['kode_mapel' => 'BIG-01', 'nama_mapel' => 'Bahasa Inggris'],
            ['kode_mapel' => 'PAI-01', 'nama_mapel' => 'Pendidikan Agama Islam'],
            ['kode_mapel' => 'IPA-01', 'nama_mapel' => 'Ilmu Pengetahuan Alam'],
            ['kode_mapel' => 'IPS-01', 'nama_mapel' => 'Ilmu Pengetahuan Sosial'],
        ];
        foreach ($mapelList as $m) {
            DB::table('mata_pelajaran')->insert([
                'kode_mapel' => $m['kode_mapel'],
                'nama_mapel' => $m['nama_mapel'],
                'is_active'  => true,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        // ==========================================
        // 5. SEED KELAS
        // ==========================================
        $kelas7AId = DB::table('kelas')->insertGetId([
            'nama_kelas'    => 'VII-A',
            'wali_kelas_id' => $guru1Id,
            'is_active'     => true,
            'created_at'    => now(),
            'updated_at'    => now()
        ]);

        $kelas7BId = DB::table('kelas')->insertGetId([
            'nama_kelas'    => 'VII-B',
            'wali_kelas_id' => $guru2Id,
            'is_active'     => true,
            'created_at'    => now(),
            'updated_at'    => now()
        ]);

        $kelas8AId = DB::table('kelas')->insertGetId([
            'nama_kelas'    => 'VIII-A',
            'wali_kelas_id' => $guru3Id,
            'is_active'     => true,
            'created_at'    => now(),
            'updated_at'    => now()
        ]);

        // ==========================================
        // 6. SEED SISWA
        // ==========================================
        $siswaList = [
            ['kelas_id' => $kelas7AId, 'nis_nisn' => '0071234501', 'nama_siswa' => 'Muhammad Rizky',    'jenis_kelamin' => 'L', 'nama_orang_tua' => 'Bambang Supriyadi', 'no_hp_orang_tua' => '081298765432'],
            ['kelas_id' => $kelas7AId, 'nis_nisn' => '0071234502', 'nama_siswa' => 'Aisyah Putri',       'jenis_kelamin' => 'P', 'nama_orang_tua' => 'Hendra Wijaya',     'no_hp_orang_tua' => '081387654321'],
            ['kelas_id' => $kelas7AId, 'nis_nisn' => '0071234503', 'nama_siswa' => 'Ahmad Zaki',         'jenis_kelamin' => 'L', 'nama_orang_tua' => 'Abdullah',          'no_hp_orang_tua' => '081234123412'],
            ['kelas_id' => $kelas7BId, 'nis_nisn' => '0071234504', 'nama_siswa' => 'Fatimah Az-Zahra',   'jenis_kelamin' => 'P', 'nama_orang_tua' => 'Umar Faruq',        'no_hp_orang_tua' => '085612345678'],
            ['kelas_id' => $kelas7BId, 'nis_nisn' => '0071234505', 'nama_siswa' => 'Bilal Ramadhan',     'jenis_kelamin' => 'L', 'nama_orang_tua' => 'Usman Harun',       'no_hp_orang_tua' => '085787654321'],
            ['kelas_id' => $kelas8AId, 'nis_nisn' => '0061234506', 'nama_siswa' => 'Dewi Lestari',       'jenis_kelamin' => 'P', 'nama_orang_tua' => 'Suharto',           'no_hp_orang_tua' => '081890123456'],
        ];
        foreach ($siswaList as $s) {
            DB::table('siswa')->insert([
                'kelas_id'        => $s['kelas_id'],
                'nis_nisn'        => $s['nis_nisn'],
                'nama_siswa'      => $s['nama_siswa'],
                'jenis_kelamin'   => $s['jenis_kelamin'],
                'nama_orang_tua'  => $s['nama_orang_tua'],
                'no_hp_orang_tua' => $s['no_hp_orang_tua'],
                'is_active'       => true,
                'created_at'      => now(),
                'updated_at'      => now()
            ]);
        }

        // ==========================================
        // 7. SEED KATEGORI PELANGGARAN K1 - K7 (Sesuai Pasal 15)
        // ==========================================
        $kategoriList = [
            ['kode' => 'K1', 'nama_kategori' => 'Pelanggaran Kerapian',             'sifat_akumulasi' => 'semester'],
            ['kode' => 'K2', 'nama_kategori' => 'Pelanggaran Kebersihan Diri',       'sifat_akumulasi' => 'semester'],
            ['kode' => 'K3', 'nama_kategori' => 'Pelanggaran Kedisiplinan',          'sifat_akumulasi' => 'tahunan'],
            ['kode' => 'K4', 'nama_kategori' => 'Pelanggaran Sopan Santun',          'sifat_akumulasi' => 'tahunan'],
            ['kode' => 'K5', 'nama_kategori' => 'Pelanggaran Keamanan',              'sifat_akumulasi' => 'tahunan'],
            ['kode' => 'K6', 'nama_kategori' => 'Pelanggaran Kegiatan Ekstra',       'sifat_akumulasi' => 'tahunan'],
            ['kode' => 'K7', 'nama_kategori' => 'Pelanggaran Khusus',                'sifat_akumulasi' => 'selamanya'],
        ];

        $kategoriIds = [];
        foreach ($kategoriList as $kat) {
            $kategoriIds[$kat['kode']] = DB::table('kategori_pelanggaran')->insertGetId([
                'kode'            => $kat['kode'],
                'nama_kategori'   => $kat['nama_kategori'],
                'sifat_akumulasi' => $kat['sifat_akumulasi'],
                'created_at'      => now(),
                'updated_at'      => now()
            ]);
        }

        // ==========================================
        // 8. SEED JENIS PELANGGARAN & POIN (Sesuai Pasal 14 MTs YKUI Sambogunung)
        // ==========================================
        $jenisList = [
            // --- K1: Kerapian ---
            ['kategori_kode' => 'K1', 'kode_pelanggaran' => 'K1-01', 'uraian_pelanggaran' => 'Tidak memakai seragam sesuai ketentuan', 'poin' => 5, 'sanksi_default' => '1x ditegur, 2x pembinaan BP/BK, 3x pembinaan BP & Orang Tua'],
            ['kategori_kode' => 'K1', 'kode_pelanggaran' => 'K1-02', 'uraian_pelanggaran' => 'Tidak memakai kelengkapan seragam (Bed OSIS, Lokasi, Kelas, Dasi, Topi)', 'poin' => 5, 'sanksi_default' => 'Ditegur / diperingatkan s.d pembinaan BP dan Orang Tua'],
            ['kategori_kode' => 'K1', 'kode_pelanggaran' => 'K1-03', 'uraian_pelanggaran' => 'Memakai baju tidak dimasukkan', 'poin' => 5, 'sanksi_default' => 'Ditegur dan diperingatkan'],
            ['kategori_kode' => 'K1', 'kode_pelanggaran' => 'K1-04', 'uraian_pelanggaran' => 'Tidak mengenakan ikat pinggang yang ditentukan sekolah', 'poin' => 5, 'sanksi_default' => 'Ditegur dan diperingatkan'],
            ['kategori_kode' => 'K1', 'kode_pelanggaran' => 'K1-05', 'uraian_pelanggaran' => 'Tidak memakai sepatu dan kaus kaki sesuai ketentuan', 'poin' => 5, 'sanksi_default' => 'Ditegur dan diperingatkan'],
            ['kategori_kode' => 'K1', 'kode_pelanggaran' => 'K1-06', 'uraian_pelanggaran' => 'Mengenakan baju dan celana yang disobek-sobek', 'poin' => 10, 'sanksi_default' => '1x ditegur/disuruh melepas, 2x disita sekolah bisa diambil orang tua'],
            ['kategori_kode' => 'K1', 'kode_pelanggaran' => 'K1-07', 'uraian_pelanggaran' => 'Mengenakan aksesoris yang berlebihan', 'poin' => 5, 'sanksi_default' => '1x ditegur/disuruh melepas, 2x disita sekolah bisa diambil orang tua'],

            // --- K2: Kebersihan Diri ---
            ['kategori_kode' => 'K2', 'kode_pelanggaran' => 'K2-01', 'uraian_pelanggaran' => 'Siswa Laki-laki: Berambut panjang, berkuncir, disemir, pakai kalung/anting/gelang, bertindik', 'poin' => 5, 'sanksi_default' => 'Ditegur, diperingatkan untuk dipangkas / disita barangnya'],
            ['kategori_kode' => 'K2', 'kode_pelanggaran' => 'K2-02', 'uraian_pelanggaran' => 'Siswa Perempuan: Make up berlebihan, perhiasan/gelang kaki berlebihan, rambut disemir, berkuku panjang', 'poin' => 5, 'sanksi_default' => 'Ditegur, diperingatkan, dan pembinaan BP/BK'],
            ['kategori_kode' => 'K2', 'kode_pelanggaran' => 'K2-03', 'uraian_pelanggaran' => 'Bertato di tubuh', 'poin' => 30, 'sanksi_default' => 'Pembinaan BP dan orang tua untuk dihapus, serta skorsing'],

            // --- K3: Kedisiplinan ---
            ['kategori_kode' => 'K3', 'kode_pelanggaran' => 'K3-01', 'uraian_pelanggaran' => 'Tidak membawa buku, perangkat belajar, dan tidak mengerjakan tugas', 'poin' => 5, 'sanksi_default' => 'Ditegur, diberikan tugas, atau dikeluarkan dari kelas jika 3 kali'],
            ['kategori_kode' => 'K3', 'kode_pelanggaran' => 'K3-02', 'uraian_pelanggaran' => 'Terlambat masuk sekolah / kelas (1-10 menit: 5p, 11-15 menit: 5p, >16 menit: 10p)', 'poin' => 10, 'sanksi_default' => 'Dicatat piket, tugas, pembinaan wali kelas / BP dan orang tua'],
            ['kategori_kode' => 'K3', 'kode_pelanggaran' => 'K3-03', 'uraian_pelanggaran' => 'Meninggalkan jam pelajaran tanpa izin', 'poin' => 5, 'sanksi_default' => 'Ditegur, diperingatkan, pembinaan BP/BK dan orang tua'],
            ['kategori_kode' => 'K3', 'kode_pelanggaran' => 'K3-04', 'uraian_pelanggaran' => 'Pulang sebelum jam berakhir', 'poin' => 5, 'sanksi_default' => 'Ditegur dan pembinaan BP'],
            ['kategori_kode' => 'K3', 'kode_pelanggaran' => 'K3-05', 'uraian_pelanggaran' => 'Istirahat di dalam kelas saat jam istirahat', 'poin' => 5, 'sanksi_default' => 'Ditegur dan diperingatkan'],
            ['kategori_kode' => 'K3', 'kode_pelanggaran' => 'K3-06', 'uraian_pelanggaran' => 'Tidak memperhatikan saat Kegiatan Belajar Mengajar (KBM)', 'poin' => 5, 'sanksi_default' => 'Ditegur dan diperingatkan'],
            ['kategori_kode' => 'K3', 'kode_pelanggaran' => 'K3-07', 'uraian_pelanggaran' => 'Membuat gaduh / ramai di dalam kelas', 'poin' => 5, 'sanksi_default' => 'Dicatat/dikeluarkan dari kelas, dibina BP'],
            ['kategori_kode' => 'K3', 'kode_pelanggaran' => 'K3-08', 'uraian_pelanggaran' => 'Mengganggu teman saat Kegiatan Belajar Mengajar', 'poin' => 5, 'sanksi_default' => 'Dicatat dan dibina guru/BP'],

            // --- K4: Sopan Santun ---
            ['kategori_kode' => 'K4', 'kode_pelanggaran' => 'K4-01', 'uraian_pelanggaran' => 'Tidak sopan pada guru', 'poin' => 5, 'sanksi_default' => 'Ditegur, diminta langsung minta maaf, pembinaan BP dan orang tua'],
            ['kategori_kode' => 'K4', 'kode_pelanggaran' => 'K4-02', 'uraian_pelanggaran' => 'Berkata-kata kotor/kasar, cacian dan porno pada teman, guru, atau orang lain', 'poin' => 5, 'sanksi_default' => 'Ditegur, pembinaan BP, surat pernyataan'],
            ['kategori_kode' => 'K4', 'kode_pelanggaran' => 'K4-03', 'uraian_pelanggaran' => 'Menghina teman, guru dan atau orang lain', 'poin' => 5, 'sanksi_default' => 'Ditegur, pembinaan BP dan orang tua'],
            ['kategori_kode' => 'K4', 'kode_pelanggaran' => 'K4-04', 'uraian_pelanggaran' => 'Melawan guru', 'poin' => 15, 'sanksi_default' => 'Dilakukan pembinaan BP dan pemanggilan orang tua'],

            // --- K5: Keamanan & Lingkungan ---
            ['kategori_kode' => 'K5', 'kode_pelanggaran' => 'K5-01', 'uraian_pelanggaran' => 'Membuang sampah tidak pada tempatnya', 'poin' => 5, 'sanksi_default' => 'Ditegur dan diperingatkan'],
            ['kategori_kode' => 'K5', 'kode_pelanggaran' => 'K5-02', 'uraian_pelanggaran' => 'Tidak melaksanakan tugas kelas (piket)', 'poin' => 5, 'sanksi_default' => 'Ditegur dan diperingatkan'],
            ['kategori_kode' => 'K5', 'kode_pelanggaran' => 'K5-03', 'uraian_pelanggaran' => 'Menggunakan fasilitas sekolah tanpa izin', 'poin' => 10, 'sanksi_default' => 'Ditegur dan pembinaan BP'],
            ['kategori_kode' => 'K5', 'kode_pelanggaran' => 'K5-04', 'uraian_pelanggaran' => 'Merusak fasilitas sekolah', 'poin' => 15, 'sanksi_default' => 'Disuruh mengganti fasilitas yang rusak'],

            // --- K6: Kegiatan Ekstra, Upacara & Keagamaan ---
            ['kategori_kode' => 'K6', 'kode_pelanggaran' => 'K6-01', 'uraian_pelanggaran' => 'Tidak mengikuti kegiatan pengembangan diri (ekstrakurikuler)', 'poin' => 5, 'sanksi_default' => 'Ditegur dan pembinaan BP'],
            ['kategori_kode' => 'K6', 'kode_pelanggaran' => 'K6-02', 'uraian_pelanggaran' => 'Tidak mengikuti upacara bendera', 'poin' => 5, 'sanksi_default' => 'Ditegur dan pembinaan BP'],
            ['kategori_kode' => 'K6', 'kode_pelanggaran' => 'K6-03', 'uraian_pelanggaran' => 'Tidak mengikuti kegiatan keagamaan (Sholat Dhuha, Jamaah Dzuhur, PHBI, Tadarus, dll)', 'poin' => 5, 'sanksi_default' => 'Ditegur, pembinaan BP dan surat pernyataan'],

            // --- K7: Pelanggaran Khusus ---
            ['kategori_kode' => 'K7', 'kode_pelanggaran' => 'K7-01', 'uraian_pelanggaran' => 'Mencuri milik teman/sekolah (25p) s.d berurusan dengan polisi (50p)', 'poin' => 50, 'sanksi_default' => 'Diperingatkan, dikembalikan, skorsing, atau dikeluarkan'],
            ['kategori_kode' => 'K7', 'kode_pelanggaran' => 'K7-02', 'uraian_pelanggaran' => 'Melawan atau mengancam guru dan siswa lainnya', 'poin' => 25, 'sanksi_default' => 'Pembinaan BP, skorsing, atau dikeluarkan'],
            ['kategori_kode' => 'K7', 'kode_pelanggaran' => 'K7-03', 'uraian_pelanggaran' => 'Membawa senjata tajam untuk menakut-nakuti/mengancam', 'poin' => 25, 'sanksi_default' => 'Disita, pembinaan BP/Orang tua, skorsing, dikeluarkan'],
            ['kategori_kode' => 'K7', 'kode_pelanggaran' => 'K7-04', 'uraian_pelanggaran' => 'Merokok di sekolah (15p), Minuman keras (50p), Narkoba/obat terlarang (100p)', 'poin' => 100, 'sanksi_default' => 'Peringatan, skorsing, atau dikeluarkan dari sekolah'],
            ['kategori_kode' => 'K7', 'kode_pelanggaran' => 'K7-05', 'uraian_pelanggaran' => 'Berpacaran atau berdua-duaan lain jenis di tempat sepi', 'poin' => 15, 'sanksi_default' => 'Peringatan, pembinaan, skorsing, atau dikeluarkan'],
            ['kategori_kode' => 'K7', 'kode_pelanggaran' => 'K7-06', 'uraian_pelanggaran' => 'Berkelahi dengan teman (25p) atau ikut tawuran/geng (50p)', 'poin' => 50, 'sanksi_default' => 'Skorsing atau dikeluarkan dari sekolah'],
            ['kategori_kode' => 'K7', 'kode_pelanggaran' => 'K7-07', 'uraian_pelanggaran' => 'Menyimpan/membawa/menyebarkan bacaan, gambar, audio/video porno', 'poin' => 25, 'sanksi_default' => 'Skorsing atau dikeluarkan'],
            ['kategori_kode' => 'K7', 'kode_pelanggaran' => 'K7-08', 'uraian_pelanggaran' => 'Membawa kartu dan bermain judi di lingkungan sekolah', 'poin' => 30, 'sanksi_default' => 'Skorsing atau dikeluarkan'],
            ['kategori_kode' => 'K7', 'kode_pelanggaran' => 'K7-09', 'uraian_pelanggaran' => 'Mengikuti kelompok geng atau sejenisnya', 'poin' => 25, 'sanksi_default' => 'Skorsing atau dikeluarkan'],
            ['kategori_kode' => 'K7', 'kode_pelanggaran' => 'K7-10', 'uraian_pelanggaran' => 'Memalsukan tanda tangan kepala madrasah, guru, dan orang tua', 'poin' => 25, 'sanksi_default' => 'Skorsing atau dikeluarkan'],
            ['kategori_kode' => 'K7', 'kode_pelanggaran' => 'K7-11', 'uraian_pelanggaran' => 'Berbuat asusila', 'poin' => 100, 'sanksi_default' => 'Dikeluarkan dari sekolah'],
        ];

        foreach ($jenisList as $j) {
            DB::table('jenis_pelanggaran')->insert([
                'kategori_id'        => $kategoriIds[$j['kategori_kode']],
                'kode_pelanggaran'   => $j['kode_pelanggaran'],
                'uraian_pelanggaran' => $j['uraian_pelanggaran'],
                'poin'               => $j['poin'],
                'sanksi_default'     => $j['sanksi_default'],
                'is_active'          => true,
                'created_at'         => now(),
                'updated_at'         => now()
            ]);
        }

        // ==========================================
        // 9. SEED ATURAN SANKSI KUMULASI (Sesuai Pasal 14 & 15)
        // ==========================================
        $sanksiList = [
            ['min_poin' => 0,   'max_poin' => 5,   'tindakan' => 'Peringatan Lisan / Teguran Biasa', 'nilai_sikap' => 'A'], // Nilai Rapor A (0-5)
            ['min_poin' => 6,   'max_poin' => 24,  'tindakan' => 'Peringatan dan Pembinaan Guru/BP', 'nilai_sikap' => 'B'], // Nilai Rapor B (6-50)
            ['min_poin' => 25,  'max_poin' => 49,  'tindakan' => 'Panggilan Orang Tua / Wali Murid ke-1 (Kumulasi 25)', 'nilai_sikap' => 'B'],
            ['min_poin' => 50,  'max_poin' => 50,  'tindakan' => 'Panggilan Orang Tua / Wali Murid ke-2 (Kumulasi 50)', 'nilai_sikap' => 'B'],
            ['min_poin' => 51,  'max_poin' => 75,  'tindakan' => 'Panggilan Orang Tua ke-3 & Skorsing (Nilai Rapor C / Cukup)', 'nilai_sikap' => 'C'], // Nilai Rapor C (51-75)
            ['min_poin' => 76,  'max_poin' => 99,  'tindakan' => 'Skorsing & Peringatan Terakhir (Nilai Rapor D / Kurang)', 'nilai_sikap' => 'D'], // Nilai Rapor D (76-100)
            ['min_poin' => 100, 'max_poin' => 999, 'tindakan' => 'Panggilan Orang Tua ke-4 & Dikembalikan kepada Orang Tua (Dikeluarkan)', 'nilai_sikap' => 'E'],
        ];

        foreach ($sanksiList as $sanksi) {
            DB::table('aturan_sanksi_kumulasi')->insert([
                'min_poin'    => $sanksi['min_poin'],
                'max_poin'    => $sanksi['max_poin'],
                'tindakan'    => $sanksi['tindakan'],
                'nilai_sikap' => $sanksi['nilai_sikap'],
                'created_at'  => now(),
                'updated_at'  => now()
            ]);
        }

        // ==========================================
        // 10. SEED PENGATURAN SISTEM
        // ==========================================
        DB::table('pengaturan_sistem')->insert([
            'nama_sekolah'        => 'MTs. YKUI Sambogunung',
            'npsn'                => '20261901',
            'alamat_sekolah'      => 'Sambogunung Dukun Gresik',
            'nama_kepala_sekolah' => 'MAF’ULAH, S.Pd.I',
            'nip_kepala_sekolah'  => '-',
            'nama_guru_bk'        => 'Tim Bimbingan Konseling (BK)',
            'nip_guru_bk'         => '-',
            'created_at'          => now(),
            'updated_at'          => now(),
        ]);

        // ==========================================
        // 11. SEED TRANSAKSI PELANGGARAN SISWA
        // ==========================================
        $siswaRizky  = DB::table('siswa')->where('nama_siswa', 'Muhammad Rizky')->first();
        $siswaAisyah = DB::table('siswa')->where('nama_siswa', 'Aisyah Putri')->first();
        $siswaZaki   = DB::table('siswa')->where('nama_siswa', 'Ahmad Zaki')->first();
        $taAktif     = DB::table('tahun_ajaran')->where('is_active', true)->first();

        $jenisTerlambat = DB::table('jenis_pelanggaran')->where('kode_pelanggaran', 'K3-02')->first();
        $jenisAtribut   = DB::table('jenis_pelanggaran')->where('kode_pelanggaran', 'K1-02')->first();
        $jenisRokok     = DB::table('jenis_pelanggaran')->where('kode_pelanggaran', 'K7-04')->first();

        if ($siswaRizky && $jenisRokok) {
            DB::table('pelanggaran_siswa')->insert([
                'siswa_id'             => $siswaRizky->id,
                'jenis_pelanggaran_id' => $jenisRokok->id,
                'tahun_ajaran_id'      => $taAktif?->id,
                'user_id'              => $adminUserId,
                'poin'                 => $jenisRokok->poin,
                'tanggal'              => now()->subDays(2)->toDateString(),
                'catatan'              => 'Ketahuan merokok di lingkungan sekolah',
                'tindak_lanjut'        => 'Peringatan dan pembinaan BP / Orang tua',
                'created_at'           => now(),
                'updated_at'           => now()
            ]);
        }

        if ($siswaAisyah && $jenisTerlambat) {
            DB::table('pelanggaran_siswa')->insert([
                'siswa_id'             => $siswaAisyah->id,
                'jenis_pelanggaran_id' => $jenisTerlambat->id,
                'tahun_ajaran_id'      => $taAktif?->id,
                'user_id'              => $adminUserId,
                'poin'                 => $jenisTerlambat->poin,
                'tanggal'              => now()->subDays(5)->toDateString(),
                'catatan'              => 'Terlambat masuk sekolah lebih dari 15 menit',
                'tindak_lanjut'        => 'Dicatat piket & diberikan peringatan',
                'created_at'           => now(),
                'updated_at'           => now()
            ]);
        }

        if ($siswaZaki && $jenisAtribut) {
            DB::table('pelanggaran_siswa')->insert([
                'siswa_id'             => $siswaZaki->id,
                'jenis_pelanggaran_id' => $jenisAtribut->id,
                'tahun_ajaran_id'      => $taAktif?->id,
                'user_id'              => $adminUserId,
                'poin'                 => $jenisAtribut->poin,
                'tanggal'              => now()->subDays(10)->toDateString(),
                'catatan'              => 'Tidak memakai kelengkapan atribut (dasi dan topi)',
                'tindak_lanjut'        => 'Ditegur dan diperingatkan',
                'created_at'           => now(),
                'updated_at'           => now()
            ]);
        }
    }
}