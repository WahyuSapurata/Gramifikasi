<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMisiRequest;
use App\Http\Requests\UpdateMisiRequest;
use App\Models\Misi;

class MisiController extends BaseController
{
    public function index()
    {
        $module = 'Misi';
        $data = Misi::latest()->get();
        return view('admin.misi.index', compact('module', 'data'));
    }

    public function add(StoreMisiRequest $storeMisiRequest)
    {
        $data = array();
        try {
            $data = new Misi();
            $data->misi = $storeMisiRequest->misi;
            $data->save();
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), $e->getMessage(), 400);
        }
        return $this->sendResponse($data, 'Add data success');
    }

    public function edit(StoreMisiRequest $storeMisiRequest, $params)
    {
        $data = Misi::where('uuid', $params)->first();
        try {
            $data->misi = $storeMisiRequest->misi;
            $data->save();
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), $e->getMessage(), 400);
        }
        return $this->sendResponse($data, 'Edit data success');
    }

    public function deleted($params)
    {
        try {
            $data = Misi::where('uuid', $params)->first();
            $data->delete();
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), $e->getMessage(), 400);
        }

        return $this->sendResponse(null, 'Delete data success');
    }
}
