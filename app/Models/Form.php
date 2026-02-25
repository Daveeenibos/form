<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Form extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'header_image',
        'theme_color',
        'is_active',
        'requires_login',
        'slug',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'requires_login' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::creating(function (Form $form) {
            if (empty($form->slug)) {
                $form->slug = Str::random(12);
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class)->orderBy('order');
    }

    public function responses(): HasMany
    {
        return $this->hasMany(Response::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function getPublicUrlAttribute(): string
    {
        return url('/f/' . $this->slug);
    }
}
