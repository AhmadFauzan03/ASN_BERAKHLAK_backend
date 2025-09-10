<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PeranResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'         => $this->id,
            'peran_user' => $this->peran_user,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
