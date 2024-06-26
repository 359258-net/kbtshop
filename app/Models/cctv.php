<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class cctv extends Model
{
    use HasFactory;
    protected $table = 'cctvs';
    protected $fillable = [
        'name',
        'address',
        'user',
        'pass',
        'sn',
        'channels'
    ];
    public function license(): HasMany
    {
        return $this->hasMany(license::class);
    }
}
