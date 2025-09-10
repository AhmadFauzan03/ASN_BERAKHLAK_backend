<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\FormOpdKriteriaResource;

class FormOpdResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'         => $this->id,
            'id_user'    => $this->id_user,
            'id_status'  => $this->id_status,
            'keterangan' => $this->keterangan,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            // pastikan relasi 'kriterias' di-load di controller (with('kriterias.details'))
            'kriterias'  => FormOpdKriteriaResource::collection($this->whenLoaded('kriterias')),
        ];
    }
}
