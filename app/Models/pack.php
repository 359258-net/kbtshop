<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class pack extends Model
{
    use HasFactory;
    protected $table = 'packs';
    protected $fillable = [
        'donhang',
        'status',
        'license_id'
    ];
    public function license(): BelongsTo
    {
        return $this->belongsTo(license::class, 'license_id','id');
    }
}
