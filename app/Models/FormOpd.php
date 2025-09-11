<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class FormOpd extends Model
{
    protected $fillable = [
        'id',
        'id_user',
        'id_status',
        'id_kriteria',
        'periode_bulan',
        'periode_tahun',
        'gambar1','gambar2','gambar3','gambar4','gambar5',
        'link_vid1','link_vid2','link_vid3','link_vid4','link_vid5',
        'keterangan'
    ];

    public $incrementing = false;
    protected $keyType = 'string';

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->id = $model->id ?? 'FOPD-' . Str::uuid();
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function status()
    {
        return $this->belongsTo(Status::class, 'id_status');
    }


    // Relasi ke kriteria
     public function kriterias()
    {
        return $this->belongsTo(FormOpdKriteria::class, 'id_kriteria', 'id');
    }
}
