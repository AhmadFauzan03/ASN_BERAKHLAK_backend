<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\StatusBerita;

class Berita extends Model
{
    protected $table = 'beritas';
    protected $fillable = [
        'id',
        'judul',
        'tanggal',
        'penulis',
        'artikel',
        'id_status_berita',
        'gambar1',
        'gambar2',
        'gambar3',
    ];
    public $incrementing = false;
    protected $keyType = 'string';

    public function status_berita(): BelongsTo
    {
        return $this->belongsTo(StatusBerita::class, 'id_status_berita', 'id');
    }

    public static function generateCustomId()
    {
        $lastStatus = self::where('id', 'like', 'BRT-%')
            ->orderBy('id', 'desc')
            ->first();

        $sequence = $lastStatus
            ? str_pad(((int) substr($lastStatus->id, -3)) + 1, 3, '0', STR_PAD_LEFT)
            : '001';

        return 'BRT-' . $sequence;
    }
}
