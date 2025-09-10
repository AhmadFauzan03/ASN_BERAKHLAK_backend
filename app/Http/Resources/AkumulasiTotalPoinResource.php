<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AkumulasiTotalPoinResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'bulan' => $this->bulan,
            'total_poin' => (int) $this->total_poin,
        ];
    }
}