<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLencanaRequest;
use App\Http\Requests\UpdateLencanaRequest;
use App\Models\Lencana;
use Illuminate\Support\Facades\File;

class LencanaController extends BaseController
{
    public function index()
    {
        $module = 'Lencana';
        $data = Lencana::latest()->get();
        return view('admin.lencana.index', compact('module', 'data'));
    }

    public function add(StoreLencanaRequest $storeLencanaRequest)
    {
        $newIcon = '';
        if ($storeLencanaRequest->file('icon')) {
            $extension = $storeLencanaRequest->file('icon')->extension();
            $newIcon = 'icon' . '-' . now()->timestamp . '.' . $extension;
            $storeLencanaRequest->file('icon')->storeAs('public/icon', $newIcon);
        }

        try {
            $data = new Lencana();
            $data->target = $storeLencanaRequest->target;
            $data->icon = $newIcon;
            $data->save();
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), $e->getMessage(), 400);
        }
        return $this->sendResponse($data, 'Add data success');
    }

    public function edit(UpdateLencanaRequest $updateLencanaRequest, $params)
    {
        $data = Lencana::where('uuid', $params)->first();

        $oldIconPath = public_path('/public/icon/' . $data->icon);

        $newIcon = '';
        if ($updateLencanaRequest->file('icon')) {
            $extension = $updateLencanaRequest->file('icon')->extension();
            $newIcon = 'icon' . '-' . now()->timestamp . '.' . $extension;
            $updateLencanaRequest->file('icon')->storeAs('public/icon', $newIcon);

            // Hapus foto lama jika ada
            if (File::exists($oldIconPath)) {
                File::delete($oldIconPath);
            }
        }

        try {
            $data->target = $updateLencanaRequest->target;
            $data->icon = $updateLencanaRequest->file('icon') ? $newIcon : $data->icon;
            $data->save();
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), $e->getMessage(), 400);
        }
        return $this->sendResponse($data, 'Edit data success');
    }

    public function deleted($params)
    {
        $data = array();
        try {
            $data = Lencana::where('uuid', $params)->first();
            // Simpan nama foto lama untuk dihapus
            $oldIconPath = public_path('/public/icon/' . $data->icon);
            // Hapus foto lama jika ada
            if (File::exists($oldIconPath)) {
                File::delete($oldIconPath);
            }
            $data->delete();
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), $e->getMessage(), 400);
        }
        return $this->sendResponse($data, 'Delete data success');
    }
}
