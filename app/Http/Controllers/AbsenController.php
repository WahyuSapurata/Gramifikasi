<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAbsenRequest;
use App\Http\Requests\UpdateAbsenRequest;
use App\Models\Absen;
use App\Models\Akademik;
use App\Models\TahunAjaran;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AbsenController extends BaseController
{
    public function index()
    {
        $module = 'Absen';
        $tahun_ajaran = TahunAjaran::where('status', true)->first();

        if (!$tahun_ajaran) {
            return back()->with('error', 'Tahun ajaran aktif tidak ditemukan.');
        }

        $akademiks = Akademik::where('uuid_tahun', $tahun_ajaran->uuid)
            ->where('uuid_guru', auth()->user()->uuid)
            ->get();

        // Ambil semua UUID akademik siswa dari guru tersebut
        $uuidAkademikList = $akademiks->pluck('uuid');

        // Ambil absensi + relasi ke akademik
        $data = Absen::whereIn('uuid_akademik', $uuidAkademikList)
            ->whereDate('tanggal', Carbon::today())
            ->with('akademik') // relasi ke akademik
            ->get();

        // Map data dan tambahkan nama siswa dari relasi akademik
        $data->transform(function ($item) {
            $item->siswa = $item->akademik->siswa->nama ?? '-'; // relasi dari akademik ke siswa
            return $item;
        });
        return view('guru.absen.index', compact('module', 'data'));
    }

    public function add()
    {
        $module = 'Tabah Absen';
        $tahun_ajaran = TahunAjaran::where('status', true)->first();
        $akademik = Akademik::where('uuid_tahun', $tahun_ajaran->uuid)->where('uuid_guru', auth()->user()->uuid)->get();
        $akademik->map(function ($item) {
            $siswa = User::where('uuid', $item->uuid_siswa)->first();
            $item->siswa = $siswa->nama ?? '-';
            return $item;
        });
        return view('guru.absen.add', compact('module', 'akademik'));
    }

    public function store(Request $request)
    {
        $uuid_akademik = $request->uuid_akademik;
        $status_list = $request->status;
        $keterangan_list = $request->keterangan;

        foreach ($uuid_akademik as $index => $uuid) {
            Absen::create([
                'uuid_akademik' => $uuid,
                'status' => $status_list[$index],
                'keterangan' => $keterangan_list[$index],
                'tanggal' => now(), // jika pakai tanggal hari ini
            ]);
        }

        return redirect()->route('guru.data-absen')->with('success', 'Absen berhasil ditambahkan.');
    }

    public function rekap_absen()
    {
        $module = 'Rekap Absen';
        $tahun_ajaran = TahunAjaran::where('status', true)->first();

        if (!$tahun_ajaran) {
            return back()->with('error', 'Tahun ajaran aktif tidak ditemukan.');
        }

        $akademiks = Akademik::where('uuid_tahun', $tahun_ajaran->uuid)
            ->where('uuid_guru', auth()->user()->uuid)
            ->get();

        // Ambil semua UUID akademik siswa dari guru tersebut
        $uuidAkademikList = $akademiks->pluck('uuid');

        // Ambil data absen untuk semua siswa dari akademik tersebut
        $rekap = Absen::whereIn('uuid_akademik', $uuidAkademikList)
            ->select(
                'uuid_akademik',
                DB::raw("SUM(CASE WHEN status = 'hadir' THEN 1 ELSE 0 END) as total_hadir"),
                DB::raw("SUM(CASE WHEN status = 'sakit' THEN 1 ELSE 0 END) as total_sakit"),
                DB::raw("SUM(CASE WHEN status = 'izin' THEN 1 ELSE 0 END) as total_izin"),
                DB::raw("SUM(CASE WHEN status = 'alfa' THEN 1 ELSE 0 END) as total_alfa")
            )
            ->groupBy('uuid_akademik')
            ->get()
            ->keyBy('uuid_akademik');

        // Gabungkan hasil rekap ke dalam data akademik (agar ada nama siswa juga)
        $akademiks->transform(function ($item) use ($rekap) {
            $item->siswa = User::where('uuid', $item->uuid_siswa)->first()->nama ?? '-';
            $item->total_hadir = $rekap[$item->uuid]->total_hadir ?? 0;
            $item->total_sakit = $rekap[$item->uuid]->total_sakit ?? 0;
            $item->total_izin  = $rekap[$item->uuid]->total_izin  ?? 0;
            $item->total_alfa  = $rekap[$item->uuid]->total_alfa  ?? 0;
            return $item;
        });

        return view('guru.absen.rekap', compact('module', 'tahun_ajaran', 'akademiks'));
    }
}
