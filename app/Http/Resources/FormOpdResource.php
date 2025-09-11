<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FormOpdResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'id_user'     => $this->id_user,
            'nama'     => $this->user ? $this->user->nama : null,
            'id_status'   => $this->id_status,
            'status'   => $this->status ? $this->status->status : null,
            'id_kriteria' => $this->id_kriteria,
            'kriteria' => $this->kriterias ? $this->kriterias->nama_kriteria : null,

            // Gambar otomatis jadi URL
            'gambar1' => $this->gambar1 ? asset('storage/'.$this->gambar1) : null,
            'gambar2' => $this->gambar2 ? asset('storage/'.$this->gambar2) : null,
            'gambar3' => $this->gambar3 ? asset('storage/'.$this->gambar3) : null,
            'gambar4' => $this->gambar4 ? asset('storage/'.$this->gambar4) : null,
            'gambar5' => $this->gambar5 ? asset('storage/'.$this->gambar5) : null,

            // Link video tetap string
            'link_vid1' => $this->link_vid1,
            'link_vid2' => $this->link_vid2,
            'link_vid3' => $this->link_vid3,
            'link_vid4' => $this->link_vid4,
            'link_vid5' => $this->link_vid5,

            //'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'bulan' => $this->periode_bulan,
            'tahun' => $this->periode_tahun,
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
        ];
    }
}
