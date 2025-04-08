<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDataSiswaRequest;
use App\Http\Requests\UpdateDataSiswaRequest;
use App\Models\DataSiswa;
use App\Models\User;
use Illuminate\Http\Request;

class DataSiswaController extends BaseController
{
    public function index()
    {
        $module = 'Data Guru';

        $dataSiswa = User::where('role', 'siswa')->get();
        $dataSiswa->map(function ($item) {
            $data = DataSiswa::where('uuid_user', $item->uuid)->first();

            $item->nis_nisn = $data->nis_nisn ?? null;
            $item->jenis_kelamin = $data->jenis_kelamin ?? null;
            $item->tempat_lahir = $data->tempat_lahir ?? null;
            $item->tanggal_lahir = $data->tanggal_lahir ?? null;
            $item->alamat = $data->alamat ?? null;
            $item->nomor = $data->nomor ?? null;

            return $item;
        });
        return view('admin.siswa.index', compact('module', 'dataSiswa'));
    }

    public function add(Request $request)
    {
        $request->validate(
            [
                'nama' => 'required',
                'username' => 'required',
                'password' => 'required',
            ],

            [
                'nama.required' => 'Kolom nama harus di isi',
                'username.required' => 'Kolom username harus di isi',
                'password.required' => 'Kolom password harus di isi'
            ]
        );

        $data = array();
        try {
            $data = new User();
            $data->nama = $request->nama;
            $data->username = $request->username;
            $data->password = $request->password;
            $data->role = "siswa";
            $data->save();
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), $e->getMessage(), 400);
        }
        return $this->sendResponse($data, 'Register data success');
    }

    public function edit(StoreDataSiswaRequest $storeDataSiswaRequest, $params)
    {
        $data = DataSiswa::where('uuid_user', $params)->first();

        try {
            if ($data) {
                $data->uuid_user = $params;
                $data->nis_nisn = $storeDataSiswaRequest->nis_nisn;
                $data->jenis_kelamin = $storeDataSiswaRequest->jenis_kelamin;
                $data->tempat_lahir = $storeDataSiswaRequest->tempat_lahir;
                $data->tanggal_lahir = $storeDataSiswaRequest->tanggal_lahir;
                $data->alamat = $storeDataSiswaRequest->alamat;
                $data->nomor = $storeDataSiswaRequest->nomor;
                $data->save();
            } else {
                $data = new DataSiswa();
                $data->uuid_user = $params;
                $data->nis_nisn = $storeDataSiswaRequest->nis_nisn;
                $data->jenis_kelamin = $storeDataSiswaRequest->jenis_kelamin;
                $data->tempat_lahir = $storeDataSiswaRequest->tempat_lahir;
                $data->tanggal_lahir = $storeDataSiswaRequest->tanggal_lahir;
                $data->alamat = $storeDataSiswaRequest->alamat;
                $data->nomor = $storeDataSiswaRequest->nomor;
                $data->save();
            }
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), $e->getMessage(), 400);
        }
        return $this->sendResponse($data, 'Update data success');
    }

    public function deleted($params)
    {
        try {
            // Ambil data dari DataSiswa dan hapus jika ditemukan
            $dataSiswa = DataSiswa::where('uuid_user', $params)->first();
            if ($dataSiswa) {
                $dataSiswa->delete();
            }

            // Ambil data dari User dan hapus jika ditemukan
            $dataUser = User::where('uuid', $params)->first();
            if ($dataUser) {
                $dataUser->delete();
            } else {
                return $this->sendError('User not found', [], 404);
            }
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), $e->getMessage(), 400);
        }

        return $this->sendResponse(null, 'Delete data success');
    }
}
