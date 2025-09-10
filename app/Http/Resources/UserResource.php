<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'         => $this->id,
            'nama'       => $this->nama,
            'peran_user' => $this->peran ? $this->peran->peran_user : null,
            'username'   => $this->username,
            'email'      => $this->email,
            'nama_opd'   => $this->opd ? $this->opd->nama_opd : null,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
