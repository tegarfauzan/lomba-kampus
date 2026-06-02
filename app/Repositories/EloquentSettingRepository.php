<?php

namespace App\Repositories;

use App\Models\Setting;
use App\Repositories\Contracts\SettingRepositoryInterface;

class EloquentSettingRepository implements SettingRepositoryInterface
{
    public function current(): Setting
    {
        return Setting::current();
    }

    public function update(array $data): Setting
    {
        $setting = $this->current();
        $setting->update($data);

        return $setting->refresh();
    }
}
