<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class FormOpdKriteria extends Model
{
    protected $table = 'form_opd_kriterias';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['id',  'nama_kriteria'];

    protected static function booted() {
        static::creating(fn($model) => $model->id = (string) Str::uuid());
    }

       public function formOpds()
    {
        return $this->hasMany(FormOpd::class, 'id_kriteria', 'id');
    }
}
