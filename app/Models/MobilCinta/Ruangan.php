<?php

namespace App\Models\MobilCinta;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ruangan extends Model
{
    protected $table = 'ruangans';

    protected $fillable = [
        'nama_ruangan',
    ];

    public function journeys(): HasMany
    {
        return $this->hasMany(Journey::class, 'ruangan_id');
    }
}