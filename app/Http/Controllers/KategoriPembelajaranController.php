<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreKategoriPembelajaranRequest;
use App\Http\Requests\UpdateKategoriPembelajaranRequest;
use App\Models\KategoriPembelajaran;

class KategoriPembelajaranController extends BaseController
{
    public function index()
    {
        $module = 'Kategori Pembelajaran';
        $data = KategoriPembelajaran::latest()->get();
        return view('admin.kategori.index', compact('module', 'data'));
    }

    public function add(StoreKategoriPembelajaranRequest $storeKategoriPembelajaranRequest)
    {
        $data = array();
        try {
            $data = new KategoriPembelajaran();
            $data->kategori = $storeKategoriPembelajaranRequest->kategori;
            $data->save();
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), $e->getMessage(), 400);
        }
        return $this->sendResponse($data, 'Add data success');
    }

    public function edit(StoreKategoriPembelajaranRequest $storeKategoriPembelajaranRequest, $params)
    {
        $data = KategoriPembelajaran::where('uuid', $params)->first();
        try {
            $data->kategori = $storeKategoriPembelajaranRequest->kategori;
            $data->save();
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), $e->getMessage(), 400);
        }
        return $this->sendResponse($data, 'Edit data success');
    }

    public function deleted($params)
    {
        try {
            $data = KategoriPembelajaran::where('uuid', $params)->first();
            $data->delete();
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), $e->getMessage(), 400);
        }

        return $this->sendResponse(null, 'Delete data success');
    }
}
