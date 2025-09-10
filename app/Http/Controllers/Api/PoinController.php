<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Poin;
use App\Http\Resources\PoinResource;
use Illuminate\Http\Request;

class PoinController extends Controller
{
    public function index() {
        return Poin::all();
    }

    public function store(Request $request) {
        $request->validate([
            'nilai_poin' => 'required|integer',
        ]);
        $poin = Poin::create([
            'id' => Poin::generateCustomId(),
            'nilai_poin' => $request->nilai_poin,
        ]);

        return new PoinResource($poin);
    }

    public function show($id) {
        return Poin::findOrFail($id);
    }

    public function update(Request $request, $id) {
        $poin = Poin::findOrFail($id);
        $poin->update($request->all());
        return $poin;
    }

    public function destroy($id) {
        return Poin::destroy($id);
    }
}
