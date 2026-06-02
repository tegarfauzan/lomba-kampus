<?php

namespace App\Models;

use App\Enums\RegistrationStatus;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'competition_id',
    'registration_code',
    'team_name',
    'leader_name',
    'leader_email',
    'leader_phone',
    'institution',
    'major',
    'document_file',
    'status',
    'admin_note',
    'verified_at',
])]
class Registration extends Model
{
    protected function casts(): array
    {
        return [
            'status' => RegistrationStatus::class,
            'verified_at' => 'datetime',
        ];
    }

    public function competition(): BelongsTo
    {
        return $this->belongsTo(Competition::class);
    }

    public function members(): HasMany
    {
        return $this->hasMany(RegistrationMember::class);
    }

    public function getRouteKeyName(): string
    {
        return 'registration_code';
    }
}
