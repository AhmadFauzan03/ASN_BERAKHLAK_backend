<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class status extends Model
{   
    protected $table = 'statuses';
    protected $fillable = [
        'id',
        'status',
    ];
    public $incrementing = false;
    protected $keyType = 'string';

    public function form_opd():HasMany
    {
        return $this->HasMany(form_opd::class,'id_status','id');
    }
    public static function generateCustomId()
{
    // Cari ID terakhir yang formatnya ST-xxx
    $lastStatus = self::where('id', 'like', 'ST-%')
        ->orderBy('id', 'desc')
        ->first();

    if (!$lastStatus) {
        $sequence = '001';
    } else {
        $lastId = $lastStatus->id;
        $lastSequence = (int) substr($lastId, -3); // ambil 3 digit terakhir
        $sequence = str_pad($lastSequence + 1, 3, '0', STR_PAD_LEFT);
    }

    return 'ST-' . $sequence;
}
}
