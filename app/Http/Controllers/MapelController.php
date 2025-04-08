<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMapelRequest;
use App\Http\Requests\UpdateMapelRequest;
use App\Models\Mapel;

class MapelController extends BaseController
{
    public function index()
    {
        $module = 'Mata Pelajaran';
        $data = Mapel::latest()->get();
        return view('admin.mapel.index', compact('module', 'data'));
    }

    public function add(StoreMapelRequest $storeMapelRequest)
    {
        $data = array();
        try {
            $data = new Mapel();
            $data->mapel = $storeMapelRequest->mapel;
            $data->save();
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), $e->getMessage(), 400);
        }
        return $this->sendResponse($data, 'Add data success');
    }

    public function edit(StoreMapelRequest $storeMapelRequest, $params)
    {
        $data = Mapel::where('uuid', $params)->first();
        try {
            $data->mapel = $storeMapelRequest->mapel;
            $data->save();
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), $e->getMessage(), 400);
        }
        return $this->sendResponse($data, 'Edit data success');
    }

    public function deleted($params)
    {
        try {
            $data = Mapel::where('uuid', $params)->first();
            $data->delete();
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), $e->getMessage(), 400);
        }

        return $this->sendResponse(null, 'Delete data success');
    }
}
