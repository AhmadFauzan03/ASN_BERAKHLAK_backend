<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\User;
use App\Models\FormOpdKriteria;
use App\Models\status;

class form_opd extends Model
{   
    protected $table = 'form_opds';
   protected $fillable = ['id', 'id_user', 'id_status', 'keterangan'];

    public $incrementing = false;
    protected $keyType = 'string';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class,'id_user','id');
    }

    public function kriterias() {
        return $this->hasMany(FormOpdKriteria::class, 'form_opd_id');
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(status::class,'id_status','id');
    }

    public static function generateCustomId()
    {
        $lastStatus = self::where('id', 'like', 'FPD-%')
            ->orderBy('id', 'desc')
            ->first();

        if (!$lastStatus) {
            $sequence = '001';
        } else {
            $lastId = $lastStatus->id;
            $lastSequence = (int) substr($lastId, -3);
            $sequence = str_pad($lastSequence + 1, 3, '0', STR_PAD_LEFT);
        }

        return 'FPD-' . $sequence;
    }
}
