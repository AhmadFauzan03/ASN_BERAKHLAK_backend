<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KategoriBerita extends Model
{
    protected $table = 'kategori_beritas';
    protected $fillable = [
        'id',
        'kategori_berita',
    ];
    public $incrementing = false;
    protected $keyType = 'string';

    public function berita(): HasMany
    {
        return $this->hasMany(Berita::class, 'id_kategori', 'id');
    }

    public static function generateCustomId()
    {
        $lastStatus = self::where('id', 'like', 'KTB-%')
            ->orderBy('id', 'desc')
            ->first();

        $sequence = $lastStatus
            ? str_pad(((int) substr($lastStatus->id, -3)) + 1, 3, '0', STR_PAD_LEFT)
            : '001';

        return 'KTB-' . $sequence;
    }
}
