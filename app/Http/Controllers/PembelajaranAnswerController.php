<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePembelajaranAnswerRequest;
use App\Http\Requests\UpdatePembelajaranAnswerRequest;
use App\Models\Akademik;
use App\Models\KategoriPembelajaran;
use App\Models\PembelajaranAnswer;
use App\Models\SoalPembelajaran;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;

class PembelajaranAnswerController extends BaseController
{
    public function soal_pembelajaran($params)
    {
        $kategori = KategoriPembelajaran::where('uuid', $params)->first();
        $module = 'Soal Pembelajaran';
        $tahun_ajaran = TahunAjaran::where('status', true)->first();
        $akademik = Akademik::where('uuid_tahun', $tahun_ajaran->uuid)->where('uuid_siswa', auth()->user()->uuid)->first();
        $soal = SoalPembelajaran::where('uuid_kategori', $kategori->uuid)->where('uuid_akademik', $akademik->uuid)->get();

        return view('siswa.soalpembelajaran.index', compact(
            'module',
            'soal',
            'kategori',
        ));
    }

    public function store(Request $request)
    {
        $data = $request->input('soal');

        foreach ($data as $uuid_soal => $jawabanData) {
            $soal = SoalPembelajaran::where('uuid', $uuid_soal)->first();
            $point = 0;
            // Cek jawaban benar atau salah
            if ($soal->jawaban_benar == $jawabanData['jawaban']) {
                $point = $soal->point;
            } else {
                $point = 0;
            }
            PembelajaranAnswer::create([
                'uuid_soal' => $uuid_soal,
                'jawaban' => $jawabanData['jawaban'],
                'point' => $point,
                'status' => true, // atau false, tergantung logika kamu
            ]);
        }

        return redirect()->route('siswa.dashboard-siswa')->with('success', 'Jawaban berhasil disimpan.');
    }
}
