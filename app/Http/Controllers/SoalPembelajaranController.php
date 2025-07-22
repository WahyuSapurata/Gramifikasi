<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSoalPembelajaranRequest;
use App\Http\Requests\UpdateSoalPembelajaranRequest;
use App\Models\Akademik;
use App\Models\KategoriPembelajaran;
use App\Models\PembelajaranAnswer;
use App\Models\SoalPembelajaran;
use App\Models\TahunAjaran;
use App\Models\User;
use Illuminate\Http\Request;

class SoalPembelajaranController extends BaseController
{
    public function index(Request $request)
    {
        $module = 'Soal';
        $tahun_ajaran = TahunAjaran::where('status', true)->first();
        $akademik = Akademik::where('uuid_tahun', $tahun_ajaran->uuid)->where('uuid_guru', auth()->user()->uuid)->first();
        $kategori = KategoriPembelajaran::all();
        $data = SoalPembelajaran::where('uuid_mapel', $akademik->uuid_mapel)->where('uuid_kategori', $request->uuid_kategori)->get();
        return view('guru.soalpembelajaran.index', compact(
            'module',
            'tahun_ajaran',
            'akademik',
            'kategori',
            'data',
        ));
    }

    public function add(Request $request)
    {
        $data = array();
        try {
            $data = new SoalPembelajaran();
            $data->uuid_mapel = $request->uuid_mapel;
            $data->uuid_kategori = $request->uuid_kategori;
            $data->soal = $request->soal;
            $data->jawaban = $request->jawaban;
            $data->jawaban_benar = $request->jawaban_benar;
            $data->point = $request->point;
            $data->save();
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), $e->getMessage(), 400);
        }
        return $this->sendResponse($data, 'Add data success');
    }

    public function edit(Request $request, $params)
    {
        $data = SoalPembelajaran::where('uuid', $params)->first();
        try {
            $data->uuid_mapel = $request->uuid_mapel;
            $data->uuid_kategori = $request->uuid_kategori;
            $data->soal = $request->soal;
            $data->jawaban = $request->jawaban;
            $data->jawaban_benar = $request->jawaban_benar;
            $data->point = $request->point;
            $data->save();
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), $e->getMessage(), 400);
        }
        return $this->sendResponse($data, 'Edit data success');
    }

    public function deleted($params)
    {
        try {
            $data = SoalPembelajaran::where('uuid', $params)->first();
            $data->delete();
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), $e->getMessage(), 400);
        }

        return $this->sendResponse(null, 'Delete data success');
    }

    public function penilaian(Request $request)
    {
        $module = 'Penilaian';
        $tahun_ajaran = TahunAjaran::where('status', true)->first();
        $akademik = Akademik::where('uuid_tahun', $tahun_ajaran->uuid)->where('uuid_guru', auth()->user()->uuid)->first();
        $kategori = KategoriPembelajaran::all();

        $data_akademik = Akademik::where('uuid', $request->uuid_akademik)->get();
        $uuid_kategori = $request->uuid_kategori;
        $data_akademik->map(function ($item) use ($uuid_kategori) {
            $siswa = User::where('uuid', $item->uuid_siswa)->first();
            $item->siswa = $siswa->nama ?? '-';

            // Ambil semua soal yang termasuk dalam misi ini
            $soalDalamMisi = SoalPembelajaran::where('uuid_kategori', $uuid_kategori)->pluck('uuid');

            // Ambil semua jawaban dari soal-soal tersebut
            $answers = PembelajaranAnswer::whereIn('uuid_soal', $soalDalamMisi)->get();

            $item->skor = $answers->sum('point');

            return $item;
        });
        // dd($data_akademik);
        return view('guru.soalpembelajaran.penilaian', compact(
            'module',
            'tahun_ajaran',
            'akademik',
            'kategori',
            'data_akademik',
        ));
    }
}
