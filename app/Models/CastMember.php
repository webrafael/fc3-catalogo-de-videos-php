<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CastMember extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'id',
        'name',
        'type',
        'created_at',
    ];

    public $incrementing = false;

    protected $casts = [
        'id' => 'string',
        'deleted_at' => 'datetime',
    ];

    public function videos()
    {
        return $this->belongsToMany(Video::class);
    }
}
