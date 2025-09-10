<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PoinResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'         => $this->id,
            'nilai_poin' => $this->nilai_poin,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
