<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StatusBeritaResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'         => $this->id,
            'status_berita'=> $this->status_berita,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
