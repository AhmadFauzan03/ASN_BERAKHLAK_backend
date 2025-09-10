<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class KriteriaResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'          => $this->id,
            'kriteria'    => $this->SubKriteria ? $this->SubKriteria->sub_kriteria : null,
            'sub_kriteria'=> $this->kriteria,
            //'deskripsi'   => $this->deskripsi,
            'nilai_poin'  => $this->poin ? $this->poin->nilai_poin : null, 
            'created_at'  => $this->created_at,
            'updated_at'  => $this->updated_at,
        ];
    }
}
