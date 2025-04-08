<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTahunAjaranRequest;
use App\Http\Requests\UpdateTahunAjaranRequest;
use App\Models\TahunAjaran;

class TahunAjaranController extends BaseController
{
    public function index()
    {
        $module = 'Tahun Ajaran';
        $data = TahunAjaran::latest()->get();
        return view('admin.tahunajaran.index', compact('module', 'data'));
    }

    public function add(StoreTahunAjaranRequest $storeTahunAjaranRequest)
    {
        $data = array();
        try {
            $data = new TahunAjaran();
            $data->tahun = $storeTahunAjaranRequest->tahun;
            $data->semester = $storeTahunAjaranRequest->semester;
            $data->save();
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), $e->getMessage(), 400);
        }
        return $this->sendResponse($data, 'Add data success');
    }

    public function edit(StoreTahunAjaranRequest $storeTahunAjaranRequest, $params)
    {
        $data = TahunAjaran::where('uuid', $params)->first();
        try {
            $data->tahun = $storeTahunAjaranRequest->tahun;
            $data->semester = $storeTahunAjaranRequest->semester;
            $data->save();
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), $e->getMessage(), 400);
        }
        return $this->sendResponse($data, 'Edit data success');
    }

    public function deleted($params)
    {
        try {
            $data = TahunAjaran::where('uuid', $params)->first();
            $data->delete();
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), $e->getMessage(), 400);
        }

        return $this->sendResponse(null, 'Delete data success');
    }

    public function update_tombol($params)
    {
        $data = TahunAjaran::where('uuid', $params)->first();
        try {
            if ($data->status == true) {
                $data->status = false;
            } elseif ($data->status == false) {
                $data->status = true;
            }
            $data->save();
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), $e->getMessage(), 400);
        }
        return $this->sendResponse($data, 'Update tombol success');
    }
}
