<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\Enums\ImageTypes;
use App\Enums\MediaTypes;

class Video extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'id',
        'title',
        'description',
        'year_launched',
        'opened',
        'rating',
        'duration',
        'created_at',
    ];

    public $incrementing = false;

    protected $casts = [
        'id' => 'string',
        'is_active' => 'boolean',
        'deleted_at' => 'datetime',
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function genres()
    {
        return $this->belongsToMany(Genre::class);
    }

    public function castMembers()
    {
        return $this->belongsToMany(CastMember::class, 'cast_member_video');
    }

    public function media()
    {
        return $this->hasOne(Media::class)
                        ->where('type', (string) MediaTypes::VIDEO->value);
    }

    public function trailer()
    {
        return $this->hasOne(Media::class)
                        ->where('type', (string) MediaTypes::TRAILER->value);
    }

    public function banner()
    {
        return $this->hasOne(ImageVideo::class)
                        ->where('type', (string) ImageTypes::BANNER->value);
    }

    public function thumb()
    {
        return $this->hasOne(ImageVideo::class)
                        ->where('type', (string) ImageTypes::THUMB->value);
    }

    public function thumbHalf()
    {
        return $this->hasOne(ImageVideo::class)
                        ->where('type', (string) ImageTypes::THUMB_HALF->value);
    }
}
