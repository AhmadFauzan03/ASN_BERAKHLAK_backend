<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SubKriteriaResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'           => $this->id,
            'sub_kriteria' => $this->sub_kriteria,
            'created_at'   => $this->created_at,
            'updated_at'   => $this->updated_at,
        ];
    }
}