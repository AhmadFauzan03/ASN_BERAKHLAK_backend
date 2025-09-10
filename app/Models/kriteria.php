<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use App\Models\Poin;
use App\Models\SubKriteria;

class kriteria extends Model
{   
    protected $table = 'kriterias';
    protected $fillable = [
        'id',
        'kriteria',
        'deskripsi',
        'id_poin',
        'id_sub_kriteria',
    ];
    public $incrementing = false;
    protected $keyType = 'string';

    public function poin():BelongsTo
    {
        return $this->belongsTo(Poin::class,'id_poin','id');
    }

    public function SubKriteria():BelongsTo
    {
        return $this->belongsTo(SubKriteria::class,'id_sub_kriteria','id');
    }

    public function from_opd():HasMany
    {
        return $this->hasMany(from_opd::class,'id_kriteria','id');
    }

    public static function generateCustomId()
{
    // Cari ID terakhir yang formatnya ST-xxx
    $lastStatus = self::where('id', 'like', 'KRT-%')
        ->orderBy('id', 'desc')
        ->first();

    if (!$lastStatus) {
        $sequence = '001';
    } else {
        $lastId = $lastStatus->id;
        $lastSequence = (int) substr($lastId, -3); // ambil 3 digit terakhir
        $sequence = str_pad($lastSequence + 1, 3, '0', STR_PAD_LEFT);
    }

    return 'KRT-' . $sequence;

}
}
