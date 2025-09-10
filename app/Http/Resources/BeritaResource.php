<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\StatusBeritaResource;
use Illuminate\Http\Resources\Json\JsonResource;

class BeritaResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'             => $this->id,
            'judul'          => $this->judul,
            'tanggal'        => $this->tanggal, 
            'penulis'        => $this->penulis,
            'artikel'        => $this->artikel,
            //'status_berita'  => $this->id_status_berita,
            'status_berita'  => $this->status_berita ? $this->status_berita->status_berita : null,
            'created_at'     => $this->created_at,
            'updated_at'     => $this->updated_at,
        ];
    }
}
