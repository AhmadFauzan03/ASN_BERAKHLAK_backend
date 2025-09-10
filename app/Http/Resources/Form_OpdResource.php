<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Form_OpdResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'           => $this->id,
            'kriteria'     => $this->kriteria && $this->kriteria->SubKriteria ? $this->kriteria->SubKriteria->sub_kriteria : null,
            'Sub_kriteria' => $this->kriteria ? $this->kriteria->kriteria : null,
            'gambar'       => $this->gambar,
            'link_video'   => $this->link_video,
            'nama'         => $this->user ? $this->user->nama : null,
            'status'       => $this->status ? $this->status->status : null,
            'keterangan'   => $this->keterangan,
            'created_at'   => $this->created_at,
            'updated_at'   => $this->updated_at,
        ];
    }
}
