<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Total_PoinResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'         => $this->id,
            'nama'       => $this->nama,
            'total_poin' => $this->user ? $this->user->nama : null,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
