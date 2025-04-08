<?php

namespace App\Http\Controllers;

use App\Models\Akademik;
use App\Models\Forum;
use App\Models\GramifikasiAnswer;
use App\Models\Mapel;
use App\Models\SoalGramifikasi;
use App\Models\TahunAjaran;
use App\Models\User;
use Illuminate\Http\Request;

class Dashboard extends BaseController
{
    public function index()
    {
        if (auth()->check()) {
            return redirect()->back();
        }
        return redirect()->route('login.login-akun');
    }

    public function dashboard_admin()
    {
        $module = 'Dashboard';
        $data_guru = User::where('role', 'guru')->count();
        $data_siswa = User::where('role', 'siswa')->count();
        $data_mapel = Mapel::count();
        $data_tahun_ajaran = TahunAjaran::where('status', true)->first();
        return view('admin.dashboard.index', compact(
            'module',
            'data_guru',
            'data_siswa',
            'data_mapel',
            'data_tahun_ajaran'
        ));
    }

    public function dashboard_guru()
    {
        $module = 'Dashboard';
        $tahun_ajaran = TahunAjaran::where('status', true)->first();
        $akademik = Akademik::where('uuid_tahun', $tahun_ajaran->uuid)->where('uuid_guru', auth()->user()->uuid)->first();
        $mapel = Mapel::where('uuid', $akademik->uuid_mapel)->first();
        $siswa = User::where('role', 'siswa')->where('uuid', $akademik->uuid_siswa)->count();

        $forum = Forum::all();
        return view('guru.dashboard.index', compact(
            'module',
            'tahun_ajaran',
            'akademik',
            'mapel',
            'siswa',
            'forum',
        ));
    }

    public function dashboard_siswa()
    {
        $module = 'Dashboard';
        $tahun_ajaran = TahunAjaran::where('status', true)->first();
        $akademik = Akademik::where('uuid_tahun', $tahun_ajaran->uuid)->where('uuid_siswa', auth()->user()->uuid)->get();
        $akademik->map(function ($item) {
            $mapel = Mapel::where('uuid', $item->uuid_mapel)->first();

            $item->mapel = $mapel->mapel;

            return $item;
        });
        $forum = Forum::all();
        return view('siswa.dashboard.index', compact(
            'module',
            'akademik',
            'forum',
        ));
    }
}
