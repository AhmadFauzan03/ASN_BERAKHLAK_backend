<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class peran extends Model
{   
    protected $table = 'perans';
    protected $fillable = [
        'id',
        'peran_user',
    ];
    public $incrementing = false;
    protected $keyType = 'string';

     public function user():HasMany
    {
        return $this->HasMany(berita::class,'id_peran','id');
    }
    public static function generateCustomId()
{
    // Cari ID terakhir yang formatnya ST-xxx
    $lastStatus = self::where('id', 'like', 'PRN-%')
        ->orderBy('id', 'desc')
        ->first();

    if (!$lastStatus) {
        $sequence = '001';
    } else {
        $lastId = $lastStatus->id;
        $lastSequence = (int) substr($lastId, -3); // ambil 3 digit terakhir
        $sequence = str_pad($lastSequence + 1, 3, '0', STR_PAD_LEFT);
    }

    return 'PRN-' . $sequence;
}


}
