<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Question extends Model
{
    protected $fillable = [
        'form_id',
        'type',
        'title',
        'description',
        'is_required',
        'order',
    ];

    protected $casts = [
        'is_required' => 'boolean',
        'order' => 'integer',
    ];

    public const TYPES = [
        'short_text' => 'Short Answer',
        'paragraph' => 'Paragraph',
        'multiple_choice' => 'Multiple Choice',
        'checkbox' => 'Checkboxes',
        'dropdown' => 'Dropdown',
        'date' => 'Date',
        'time' => 'Time',
        'file_upload' => 'File Upload',
    ];

    public function form(): BelongsTo
    {
        return $this->belongsTo(Form::class);
    }

    public function options(): HasMany
    {
        return $this->hasMany(Option::class)->orderBy('order');
    }

    public function answers(): HasMany
    {
        return $this->hasMany(Answer::class);
    }

    public function hasOptions(): bool
    {
        return in_array($this->type, ['multiple_choice', 'checkbox', 'dropdown']);
    }
}
