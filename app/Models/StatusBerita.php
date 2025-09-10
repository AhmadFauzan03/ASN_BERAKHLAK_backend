<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Berita;

class StatusBerita extends Model
{
    protected $table = 'status_beritas';
    protected $fillable = [
        'id',
        'status_berita',
    ];
    public $incrementing = false;
    protected $keyType = 'string';

    public function berita(): HasMany
    {
        return $this->hasMany(Berita::class, 'id_status_berita', 'id');
    }

   public static function generateCustomId()
{
    // Cari ID terakhir yang formatnya ST-xxx
    $lastStatus = self::where('id', 'like', 'STBT-%')
        ->orderBy('id', 'desc')
        ->first();

    if (!$lastStatus) {
        $sequence = '001';
    } else {
        $lastId = $lastStatus->id;
        $lastSequence = (int) substr($lastId, -3); // ambil 3 digit terakhir
        $sequence = str_pad($lastSequence + 1, 3, '0', STR_PAD_LEFT);
    }

    return 'STBT-' . $sequence;
}

}
