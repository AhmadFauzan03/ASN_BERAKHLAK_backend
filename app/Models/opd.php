<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class opd extends Model
{   
    protected $table = 'opds';
    protected $fillable = [
        'id',
        'nama_opd',
        'email_opd',
    ];
    public $incrementing = false;
    protected $keyType = 'string';
    public function User():HasMany
    {
        return $this->hasMany(User::class,'id_opd','id');
    }
    public static function generateCustomId()
{
    // Cari ID terakhir yang formatnya ST-xxx
    $lastStatus = self::where('id', 'like', 'OPD-%')
        ->orderBy('id', 'desc')
        ->first();

    if (!$lastStatus) {
        $sequence = '001';
    } else {
        $lastId = $lastStatus->id;
        $lastSequence = (int) substr($lastId, -3); // ambil 3 digit terakhir
        $sequence = str_pad($lastSequence + 1, 3, '0', STR_PAD_LEFT);
    }

    return 'OPD-' . $sequence;

}
}
