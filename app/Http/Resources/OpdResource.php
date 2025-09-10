<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OpdResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'         => $this->id,
            'nama_opd'       => $this->nama_opd,
            'email_opd'      => $this->email_opd,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
