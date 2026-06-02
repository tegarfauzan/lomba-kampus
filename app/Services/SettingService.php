<?php

namespace App\Services;

use App\Models\Setting;
use App\Repositories\Contracts\SettingRepositoryInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

class SettingService
{
    public function __construct(private readonly SettingRepositoryInterface $settings) {}

    public function update(array $data): Setting
    {
        $setting = $this->settings->current();
        $payload = Arr::except($data, ['logo']);

        if (($data['logo'] ?? null) instanceof UploadedFile) {
            if ($setting->logo) {
                Storage::disk('public')->delete($setting->logo);
            }

            $payload['logo'] = $data['logo']->store('site-assets', 'public');
        }

        return $this->settings->update($payload);
    }
}
