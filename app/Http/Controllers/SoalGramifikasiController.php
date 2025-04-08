<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSoalGramifikasiRequest;
use App\Http\Requests\UpdateSoalGramifikasiRequest;
use App\Models\Akademik;
use App\Models\GramifikasiAnswer;
use App\Models\Lencana;
use App\Models\Misi;
use App\Models\SoalGramifikasi;
use App\Models\TahunAjaran;
use App\Models\User;
use Illuminate\Http\Request;

class SoalGramifikasiController extends BaseController
{
    public function index(Request $request)
    {
        $module = 'Soal';
        $tahun_ajaran = TahunAjaran::where('status', true)->first();
        $akademik = Akademik::where('uuid_tahun', $tahun_ajaran->uuid)->where('uuid_guru', auth()->user()->uuid)->first();
        $misi = Misi::all();
        $data = SoalGramifikasi::where('uuid_akademik', $akademik->uuid)->where('uuid_misi', $request->uuid_misi)->get();
        return view('guru.soal.index', compact(
            'module',
            'misi',
            'data',
            'tahun_ajaran',
            'akademik',
        ));
    }

    public function add(Request $request)
    {
        $data = array();
        try {
            $data = new SoalGramifikasi();
            $data->uuid_akademik = $request->uuid_akademik;
            $data->uuid_misi = $request->uuid_misi;
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
        $data = SoalGramifikasi::where('uuid', $params)->first();
        try {
            $data->uuid_akademik = $request->uuid_akademik;
            $data->uuid_misi = $request->uuid_misi;
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
            $data = SoalGramifikasi::where('uuid', $params)->first();
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
        $misi = Misi::all();

        $data_akademik = Akademik::where('uuid', $request->uuid_akademik)->get();
        $uuid_misi = $request->uuid_misi;
        $data_akademik->map(function ($item) use ($uuid_misi) {
            $siswa = User::where('uuid', $item->uuid_siswa)->first();
            $item->siswa = $siswa->nama ?? '-';

            // Ambil semua soal yang termasuk dalam misi ini
            $soalDalamMisi = SoalGramifikasi::where('uuid_misi', $uuid_misi)->pluck('uuid');

            // Ambil semua jawaban dari soal-soal tersebut
            $answers = GramifikasiAnswer::whereIn('uuid_soal', $soalDalamMisi)->get();

            $item->skor = $answers->sum('point');

            return $item;
        });

        // dd($data_akademik);
        return view('guru.penialaian.index', compact(
            'module',
            'akademik',
            'tahun_ajaran',
            'misi',
            'data_akademik',
        ));
    }
}
