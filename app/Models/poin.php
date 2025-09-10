<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class poin extends Model
{   
    protected $table = 'poins';
    protected $fillable = [
        'id',
        'nilai_poin',
    ];
    public $incrementing = false;
    protected $keyType = 'string';

    public function kriteria():HasMany
    {
        return $this->hasMany(id_poin::class,'id_poin','id');
    }
    public static function generateCustomId()
{
    $lastStatus = self::where('id', 'like', 'PN-%')
        ->orderBy('id', 'desc')
        ->first();

    if (!$lastStatus) {
        $sequence = '001';
    } else {
        $lastId = $lastStatus->id;
        $lastSequence = (int) substr($lastId, -3);
        $sequence = str_pad($lastSequence + 1, 3, '0', STR_PAD_LEFT);
    }

    return 'PN-' . $sequence;
}
}
