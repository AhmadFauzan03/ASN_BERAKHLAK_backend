<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormOpdDetail extends Model
{
    use HasFactory;

    protected $table = 'form_opd_details';
    protected $keyType = 'string';
    public $incrementing = false;

   protected $fillable = [
        'id',
        'form_opd_id',
        'id_kriteria',
        'file',
        'link',
        'id_status',
        'nilai_poin',
        'keterangan',
    ];

    public function formOpd()
    {
        return $this->belongsTo(FormOpd::class, 'form_opd_id');
    }

    public function kriteria()
    {
        return $this->belongsTo(Kriteria::class, 'id_kriteria');
    }

     public static function generateCustomId()
    {
        $lastStatus = self::where('id', 'like', 'FPDD-%')
            ->orderBy('id', 'desc')
            ->first();

        if (!$lastStatus) {
            $sequence = '001';
        } else {
            $lastId = $lastStatus->id;
            $lastSequence = (int) substr($lastId, -3);
            $sequence = str_pad($lastSequence + 1, 3, '0', STR_PAD_LEFT);
        }

        return 'FPDD-' . $sequence;
    }
}
