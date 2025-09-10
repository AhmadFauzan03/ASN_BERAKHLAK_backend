<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;


class FormOpd extends Model
{
      use HasFactory;

    protected $table = 'form_opds';
    public $incrementing = false; // karena ID string
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'id_user',
        'id_status',
        'keterangan',
    ];

    // Auto-generate ID custom setiap create
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = 'FOPD-' . Str::uuid(); // contoh: FOPD-xxxx
            }
        });
    }

    // Relasi ke kriteria
    public function kriterias()
    {
        return $this->hasMany(FormOpdKriteria::class, 'form_opd_id');
    }
}
