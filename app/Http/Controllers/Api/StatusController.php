<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Status;
use App\Http\Resources\StatusResource;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    public function index() {
        return Status::all();
    }

    public function store(Request $request) {
        $request->validate([
            'status' => 'required|string',
        ]);
        $status = Status::create([
            'id' => Status::generateCustomId(),
            'status' => $request->status,
        ]);

        return new StatusResource($status);
    }

    public function show($id) {
        return Status::findOrFail($id);
    }

    public function update(Request $request, $id) {
        $status = Status::findOrFail($id);
        $status->update($request->all());
        return $status;
    }

    public function destroy($id) {
        return Status::destroy($id);
    }
}
