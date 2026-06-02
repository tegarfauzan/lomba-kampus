<?php

namespace App\Models;

use App\Enums\CompetitionStatus;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

#[Fillable([
    'category_id',
    'title',
    'slug',
    'description',
    'poster',
    'rules',
    'requirements',
    'prize',
    'quota',
    'registration_start',
    'registration_end',
    'event_date',
    'status',
])]
class Competition extends Model
{
    protected function casts(): array
    {
        return [
            'registration_start' => 'datetime',
            'registration_end' => 'datetime',
            'event_date' => 'date',
            'status' => CompetitionStatus::class,
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function registrations(): HasMany
    {
        return $this->hasMany(Registration::class);
    }

    public function announcements(): HasMany
    {
        return $this->hasMany(Announcement::class);
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->whereIn('status', [
            CompetitionStatus::Open->value,
            CompetitionStatus::Closed->value,
            CompetitionStatus::Ongoing->value,
            CompetitionStatus::Finished->value,
        ]);
    }

    public function acceptsRegistrations(): bool
    {
        return $this->status === CompetitionStatus::Open
            && now()->betweenIncluded($this->registration_start, $this->registration_end)
            && ($this->quota === 0 || $this->registrations()->count() < $this->quota);
    }

    public function posterUrl(): string
    {
        if ($this->poster && Str::startsWith($this->poster, ['http://', 'https://'])) {
            return $this->poster;
        }

        return $this->poster
            ? Storage::disk('public')->url($this->poster)
            : 'https://images.unsplash.com/photo-1517048676732-d65bc937f952?auto=format&fit=crop&w=1200&q=80';
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
