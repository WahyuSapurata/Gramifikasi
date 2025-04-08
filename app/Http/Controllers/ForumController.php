<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreForumRequest;
use App\Http\Requests\UpdateForumRequest;
use App\Models\Forum;

class ForumController extends BaseController
{
    public function index()
    {
        $module = 'Forum';
        $data = Forum::latest()->get();
        return view('admin.forum.index', compact('module', 'data'));
    }

    public function add(StoreForumRequest $storeForumRequest)
    {
        $data = array();
        try {
            $data = new Forum();
            $data->judul = $storeForumRequest->judul;
            $data->isi_forum = $storeForumRequest->isi_forum;
            $data->save();
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), $e->getMessage(), 400);
        }
        return $this->sendResponse($data, 'Add data success');
    }

    public function edit(StoreForumRequest $storeForumRequest, $params)
    {
        $data = Forum::where('uuid', $params)->first();
        try {
            $data->judul = $storeForumRequest->judul;
            $data->isi_forum = $storeForumRequest->isi_forum;
            $data->save();
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), $e->getMessage(), 400);
        }
        return $this->sendResponse($data, 'Edit data success');
    }

    public function deleted($params)
    {
        try {
            $data = Forum::where('uuid', $params)->first();
            $data->delete();
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), $e->getMessage(), 400);
        }

        return $this->sendResponse(null, 'Delete data success');
    }
}
