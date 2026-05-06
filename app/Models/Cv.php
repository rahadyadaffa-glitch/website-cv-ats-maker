<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Cv extends Model
{
    protected $table = 'cvs';

    protected $fillable = [
        'nama_file',
        'bahasa',
        'status',
        'content',
    ];

    protected $casts = [
        'content' => 'array',
        'status'  => 'string',
        'bahasa'  => 'string',
    ];

    // ─── Scopes ───────────────────────────────────────────

    public function scopeDraft(Builder $query): Builder
    {
        return $query->where('status', 'draft');
    }

    public function scopeCompleted(Builder $query): Builder
    {
        return $query->where('status', 'completed');
    }

    public function scopeIndonesia(Builder $query): Builder
    {
        return $query->where('bahasa', 'id');
    }

    public function scopeEnglish(Builder $query): Builder
    {
        return $query->where('bahasa', 'en');
    }

    // ─── Helpers ──────────────────────────────────────────

    public function isIndonesia(): bool
    {
        return $this->bahasa === 'id';
    }

    public function isDraft(): bool
    {
        return $this->status === 'draft';
    }

    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }
}
