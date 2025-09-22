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
        'periode_bulan',
        'periode_tahun',
    ];

    public function details()
    {
        return $this->hasMany(FormOpdDetail::class, 'form_opd_id');
    }
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


   
    
}
