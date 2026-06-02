<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

#[Fillable([
    'id',
    'organization_name',
    'event_name',
    'logo',
    'description',
    'contact_email',
    'contact_phone',
    'instagram_url',
    'address',
    'footer_text',
])]
class Setting extends Model
{
    public static function current(): self
    {
        return self::query()->firstOrCreate(
            ['id' => 1],
            [
                'organization_name' => 'Himpunan Mahasiswa Kreatif',
                'event_name' => 'Kompetisi Mahasiswa 2026',
                'description' => 'Ajang kompetisi kampus untuk menemukan ide, karya, dan talenta terbaik mahasiswa.',
                'contact_email' => 'panitia@kampus.test',
                'contact_phone' => '6281234567890',
                'instagram_url' => 'https://instagram.com/kampusjuara',
                'address' => 'Sekretariat Organisasi Kampus',
                'footer_text' => 'Dikelola oleh panitia lomba organisasi kampus.',
            ],
        );
    }

    public function logoUrl(): ?string
    {
        if (! $this->logo) {
            return null;
        }

        if (Str::startsWith($this->logo, ['http://', 'https://'])) {
            return $this->logo;
        }

        return Storage::disk('public')->url($this->logo);
    }
}
