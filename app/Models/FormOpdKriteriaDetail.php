<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
class FormOpdKriteriaDetail extends Model
{
      protected $table = 'form_opd_kriteria_details';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['id', 'form_opd_kriteria_id', 'nilai_poin', 'gambar', 'link_video'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = 'FOKD-' . Str::uuid();
            }
        });
    }

    public function kriteria() {
        return $this->belongsTo(FormOpdKriteria::class, 'form_opd_kriteria_id');
    }
}
