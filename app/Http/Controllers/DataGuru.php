<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDataGuruRequest;
use App\Http\Requests\StoreDataSiswaRequest;
use App\Models\DataGuru as ModelsDataGuru;
use App\Models\User;
use Illuminate\Http\Request;

class DataGuru extends BaseController
{
    public function index()
    {
        $module = 'Data Guru';

        $dataGuru = User::where('role', 'guru')->get();
        $dataGuru->map(function ($item) {
            $data = ModelsDataGuru::where('uuid_user', $item->uuid)->first();

            $item->nip = $data->nip ?? null;
            $item->jenis_kelamin = $data->jenis_kelamin ?? null;
            $item->tempat_lahir = $data->tempat_lahir ?? null;
            $item->tanggal_lahir = $data->tanggal_lahir ?? null;
            $item->alamat = $data->alamat ?? null;
            $item->nomor = $data->nomor ?? null;

            return $item;
        });
        return view('admin.guru.index', compact('module', 'dataGuru'));
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
            $data->role = "guru";
            $data->save();
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), $e->getMessage(), 400);
        }
        return $this->sendResponse($data, 'Register data success');
    }

    public function edit(StoreDataGuruRequest $storeDataGuruRequest, $params)
    {
        $data = ModelsDataGuru::where('uuid_user', $params)->first();

        try {
            if ($data) {
                $data->uuid_user = $params;
                $data->nip = $storeDataGuruRequest->nip;
                $data->jenis_kelamin = $storeDataGuruRequest->jenis_kelamin;
                $data->tempat_lahir = $storeDataGuruRequest->tempat_lahir;
                $data->tanggal_lahir = $storeDataGuruRequest->tanggal_lahir;
                $data->alamat = $storeDataGuruRequest->alamat;
                $data->nomor = $storeDataGuruRequest->nomor;
                $data->save();
            } else {
                $data = new ModelsDataGuru();
                $data->uuid_user = $params;
                $data->nip = $storeDataGuruRequest->nip;
                $data->jenis_kelamin = $storeDataGuruRequest->jenis_kelamin;
                $data->tempat_lahir = $storeDataGuruRequest->tempat_lahir;
                $data->tanggal_lahir = $storeDataGuruRequest->tanggal_lahir;
                $data->alamat = $storeDataGuruRequest->alamat;
                $data->nomor = $storeDataGuruRequest->nomor;
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
            // Ambil data dari ModelsDataGuru dan hapus jika ditemukan
            $dataGuru = ModelsDataGuru::where('uuid_user', $params)->first();
            if ($dataGuru) {
                $dataGuru->delete();
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
