<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;

class TotalPoin extends Model
{
    protected $table = 'total_poins';

    protected $fillable = [
        'id',
        'id_user',
        'total_poin',
    ];

    public $incrementing = false;
    protected $keyType = 'string';

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    public static function generateCustomId()
    {
        $lastRecord = self::where('id', 'like', 'TPN-%')
            ->orderBy('id', 'desc')
            ->first();

        if (!$lastRecord) {
            $sequence = '001';
        } else {
            $lastId = $lastRecord->id;
            $lastSequence = (int) substr($lastId, -3);
            $sequence = str_pad($lastSequence + 1, 3, '0', STR_PAD_LEFT);
        }

        return 'TPN-' . $sequence;
    }
}
