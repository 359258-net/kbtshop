<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class license extends Model
{
    use HasFactory;
    public $incrementing = false;
    //protected static function booted(): void
    //{
    //    static::creating(function (license $license) {
    //        $license->id = Str::uuid()->toString();
    //    });
    //}
    protected $table = 'licenses';
    protected $fillable = [
        'id',
        'name',
        'lic',
        'channel',
        'cctv_id'
    ];
    public function cctv(): BelongsTo
    {
        return $this->belongsTo(cctv::class, 'cctv_id','id');
    }
    public function pack(): HasMany
    {
        return $this->hasMany(pack::class);
    }
}
