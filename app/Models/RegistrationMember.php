<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['registration_id', 'name', 'email', 'phone', 'institution', 'major'])]
class RegistrationMember extends Model
{
    public function registration(): BelongsTo
    {
        return $this->belongsTo(Registration::class);
    }
}
