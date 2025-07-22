<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGramifikasiAnswerRequest;
use App\Http\Requests\UpdateGramifikasiAnswerRequest;
use App\Models\Akademik;
use App\Models\GramifikasiAnswer;
use App\Models\KategoriPembelajaran;
use App\Models\Lencana;
use App\Models\Misi;
use App\Models\PembelajaranAnswer;
use App\Models\SoalGramifikasi;
use App\Models\SoalPembelajaran;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;

class GramifikasiAnswerController extends BaseController
{
    public function detail($params)
    {
        $module = 'Detail Misi Dan Kategori';
        $tahun_ajaran = TahunAjaran::where('status', true)->first();
        $akademik = Akademik::where('uuid_tahun', $tahun_ajaran->uuid)->where('uuid_mapel', $params)->where('uuid_siswa', auth()->user()->uuid)->first();
        // Ambil semua soal dengan uuid_akademik terkait
        $soal_gramifikasi_all = SoalGramifikasi::where('uuid_mapel', $akademik->uuid_mapel)->orderBy('created_at', 'desc')->get();

        // Kelompokkan berdasarkan uuid_misi dan ambil satu data dari masing-masing
        $soal_gramifikasi = $soal_gramifikasi_all->unique('uuid_misi')->values();

        // Ambil semua lencana
        $lencana = Lencana::all();

        // Proses tiap soal untuk menambahkan informasi misi, skor, dan lencana
        $soal_gramifikasi->map(function ($item) use ($lencana) {
            // Ambil data misi
            $misi = Misi::where('uuid', $item->uuid_misi)->first();
            $item->misi = $misi->misi ?? '-';

            // Ambil semua soal yang termasuk dalam misi ini
            $soalDalamMisi = SoalGramifikasi::where('uuid_misi', $item->uuid_misi)->pluck('uuid');

            // Ambil semua jawaban dari soal-soal tersebut
            $answers = GramifikasiAnswer::whereIn('uuid_soal', $soalDalamMisi)->get();

            $item->skor = $answers->sum('point');

            // Cari lencana dengan target tertinggi yang kurang dari atau sama dengan skor
            $item->lencana = $lencana
                ->filter(fn($l) => (int) $l->target <= $answers->sum('point'))
                ->sortByDesc('target')
                ->first();

            return $item;
        });

        $soal_pembelajaran_all = SoalPembelajaran::where('uuid_mapel', $akademik->uuid_mapel)->orderBy('created_at', 'desc')->get();

        // Kelompokkan berdasarkan uuid_kategori dan ambil satu data dari masing-masing
        $soal_pembelajaran = $soal_pembelajaran_all->unique('uuid_kategori')->values();

        // Proses tiap soal untuk menambahkan informasi kategori, skor, dan lencana
        $soal_pembelajaran->map(function ($item) {
            // Ambil data kategori
            $kategori = KategoriPembelajaran::where('uuid', $item->uuid_kategori)->first();
            $item->kategori = $kategori->kategori ?? '-';

            // Ambil semua soal yang termasuk dalam kategori ini
            $soalDalamKategori = SoalPembelajaran::where('uuid_kategori', $item->uuid_kategori)->pluck('uuid');

            // Ambil semua jawaban dari soal-soal tersebut
            $answers = PembelajaranAnswer::whereIn('uuid_soal', $soalDalamKategori)->get();

            $item->skor = $answers->sum('point');

            return $item;
        });

        return view('siswa.detail.index', compact(
            'module',
            'soal_gramifikasi',
            'soal_pembelajaran',
        ));
    }

    public function soal_gramifikasi($params)
    {
        $misi = Misi::where('uuid', $params)->first();
        $module = 'Soal Gramifikasi';
        $tahun_ajaran = TahunAjaran::where('status', true)->first();
        $akademik = Akademik::where('uuid_tahun', $tahun_ajaran->uuid)->where('uuid_siswa', auth()->user()->uuid)->first();
        $soal = SoalGramifikasi::where('uuid_misi', $misi->uuid)->where('uuid_mapel', $akademik->uuid_mapel)->get();

        return view('siswa.soalgramifikasi.index', compact(
            'module',
            'soal',
            'misi',
        ));
    }

    public function store(Request $request)
    {
        $data = $request->input('soal');

        foreach ($data as $uuid_soal => $jawabanData) {
            $soal = SoalGramifikasi::where('uuid', $uuid_soal)->first();
            $point = 0;
            // Cek jawaban benar atau salah
            if ($soal->jawaban_benar == $jawabanData['jawaban']) {
                $point = $soal->point;
            } else {
                $point = 0;
            }
            GramifikasiAnswer::create([
                'uuid_siswa' => auth()->user()->uuid,
                'uuid_soal' => $uuid_soal,
                'jawaban' => $jawabanData['jawaban'],
                'point' => $point,
                'status' => true, // atau false, tergantung logika kamu
            ]);
        }

        return redirect()->route('siswa.dashboard-siswa')->with('success', 'Jawaban berhasil disimpan.');
    }
}
