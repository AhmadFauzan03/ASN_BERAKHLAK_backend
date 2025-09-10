<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FormOpdKriteriaDetailResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->id,
            'nilai_poin' => $this->nilai_poin,
            'gambar'     => $this->gambar,
            'link_video' => $this->link_video,
        ];
    }
}
