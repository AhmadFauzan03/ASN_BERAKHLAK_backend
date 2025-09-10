<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Opd;
use App\Http\Resources\OpdResource;
use Illuminate\Http\Request;

class OpdController extends Controller
{
    public function index() {
        return Opd::all();
    }

    public function store(Request $request) {
        $request->validate([
            'nama_opd' => 'required|string|max:225',
            'email_opd' => 'required|email|unique:opds,email_opd',
        ]);
        $opd = Opd::create([
            'id' => Opd::generateCustomId(),
            'nama_opd' => $request->nama_opd,
            'email_opd' => $request->email_opd,
        ]);

        return new OpdResource($opd);
    }

    public function show($id) {
        return Opd::findOrFail($id);
    }

    public function update(Request $request, $id) {
        $opd = Opd::findOrFail($id);
        $opd->update($request->all());
        return $opd;
    }

    public function destroy($id) {
        return Opd::destroy($id);
    }
}
