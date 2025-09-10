<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Peran;
use App\Models\Opd;
use App\Models\From_Opd;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use  HasApiTokens,HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
    */
    protected $table = 'users';
    protected $fillable = [
        'id',
        'nama',
        'id_peran',
        'email',
        'password',
        'username',
        'id_opd',
    ];
    public $incrementing = false;
    protected $keyType = 'string';

    public function from_opd():HasMany
    {
        return $this->HasMany(From_opd::class,'id_user','id');
    }

    public function total_poin():HasMany
    {
        return $this->HasMany(total_poin::class,'id_user','id');
    }

    public function peran():BelongsTo
    {
        return $this->belongsTo(Peran::class,'id_peran','id');
    }

    public function opd():BelongsTo
    {
        return $this->belongsTo(Opd::class,'id_opd','id');
    }


    

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public static function generateCustomId()
{
    // Cari ID terakhir yang formatnya ST-xxx
    $lastStatus = self::where('id', 'like', 'USR-%')
        ->orderBy('id', 'desc')
        ->first();

    if (!$lastStatus) {
        $sequence = '001';
    } else {
        $lastId = $lastStatus->id;
        $lastSequence = (int) substr($lastId, -3); // ambil 3 digit terakhir
        $sequence = str_pad($lastSequence + 1, 3, '0', STR_PAD_LEFT);
    }

    return 'USR-' . $sequence;
}
}

