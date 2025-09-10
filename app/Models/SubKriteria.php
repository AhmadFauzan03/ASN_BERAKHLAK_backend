<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubKriteria extends Model
{
    protected $table = 'sub_kriterias';

    protected $fillable = [
        'id',
        'sub_kriteria',
    ];

    public $incrementing = false;
    protected $keyType = 'string';


    public function kriterias(): HasMany
    {
        return $this->hasMany(Kriteria::class, 'id_sub_kriteria', 'id');
    }

    public static function generateCustomId()
    {
        $lastRecord = self::where('id', 'like', 'SUB-%')
            ->orderBy('id', 'desc')
            ->first();

        if (!$lastRecord) {
            $sequence = '001';
        } else {
            $lastId = $lastRecord->id;
            $lastSequence = (int) substr($lastId, -3);
            $sequence = str_pad($lastSequence + 1, 3, '0', STR_PAD_LEFT);
        }

        return 'SUB-' . $sequence;
    }
}
