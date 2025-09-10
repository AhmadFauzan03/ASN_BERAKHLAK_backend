<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FormOpdKriteriaResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->id,
            'nama_kriteria' => $this->nama_kriteria,
            'details'       => FormOpdKriteriaDetailResource::collection($this->whenLoaded('details')),
        ];
    }
}
