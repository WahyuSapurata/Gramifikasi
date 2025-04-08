<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAkademikRequest;
use App\Http\Requests\UpdateAkademikRequest;
use App\Models\Akademik;
use App\Models\Mapel;
use App\Models\TahunAjaran;
use App\Models\User;
use Illuminate\Http\Request;

class AkademikController extends BaseController
{
    public function index(Request $request)
    {
        $module = 'Akademik';
        $mapel = Mapel::all();
        $guru = User::where('role', 'guru')->get();
        $siswa = User::where('role', 'siswa')->get();
        $tahun_ajaran = TahunAjaran::where('status', true)->first();

        $data = Akademik::where('uuid_tahun', $request->uuid_tahun)->where('uuid_mapel', $request->uuid_mapel)->where('uuid_guru', $request->uuid_guru)->where('kelas', $request->kelas)->get();
        $data->map(function ($item) {
            $item->siswa = User::where('uuid', $item->uuid_siswa)->first()->nama;
            return $item;
        });
        return view('admin.akademik.index', compact(
            'module',
            'mapel',
            'guru',
            'siswa',
            'data',
            'tahun_ajaran',
        ));
    }

    public function add(StoreAkademikRequest $storeAkademikRequest)
    {
        $data = array();
        try {
            $data = new Akademik();
            $data->uuid_guru = $storeAkademikRequest->uuid_guru;
            $data->uuid_siswa = $storeAkademikRequest->uuid_siswa;
            $data->uuid_mapel = $storeAkademikRequest->uuid_mapel;
            $data->uuid_tahun = $storeAkademikRequest->uuid_tahun;
            $data->kelas = $storeAkademikRequest->kelas;
            $data->save();
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), $e->getMessage(), 400);
        }
        return $this->sendResponse($data, 'Add data success');
    }

    public function edit(StoreAkademikRequest $storeAkademikRequest, $params)
    {
        $data = Akademik::where('uuid', $params)->first();
        try {
            $data->uuid_guru = $storeAkademikRequest->uuid_guru;
            $data->uuid_siswa = $storeAkademikRequest->uuid_siswa;
            $data->uuid_mapel = $storeAkademikRequest->uuid_mapel;
            $data->uuid_tahun = $storeAkademikRequest->uuid_tahun;
            $data->kelas = $storeAkademikRequest->kelas;
            $data->save();
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), $e->getMessage(), 400);
        }
        return $this->sendResponse($data, 'Edit data success');
    }

    public function deleted($params)
    {
        try {
            $data = Akademik::where('uuid', $params)->first();
            $data->delete();
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), $e->getMessage(), 400);
        }

        return $this->sendResponse(null, 'Delete data success');
    }
}
