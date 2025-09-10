<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PeranResource;
use App\Models\Peran;
use Illuminate\Http\Request;

class PeranController extends Controller
{
    public function index() {
        return Peran::all();
    }

    public function store(Request $request) {
        $request->validate([
            'peran_user' => 'required|string',
        ]);
          $peran = Peran::create([
            'id' => Peran::generateCustomId(),
            'peran_user' => $request->peran_user,
        ]);

        return new PeranResource($peran);

    }

    public function show($id) {
        return Peran::findOrFail($id);
    }

    public function update(Request $request, $id) {
        $peran = Peran::findOrFail($id);
        $peran->update($request->all());
        return $peran;
    }

    public function destroy($id) {
        return Peran::destroy($id);
    }
}
