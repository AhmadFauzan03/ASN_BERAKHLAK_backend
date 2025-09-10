<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class FormOpdKriteria extends Model
{
    protected $table = 'form_opd_kriterias';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['id', 'form_opd_id', 'nama_kriteria'];

    protected static function booted() {
        static::creating(fn($model) => $model->id = (string) Str::uuid());
    }

    public function formOpd() {
        return $this->belongsTo(FormOpd::class, 'form_opd_id');
    }

    public function details() {
        return $this->hasMany(FormOpdKriteriaDetail::class, 'form_opd_kriteria_id');
    }
}
