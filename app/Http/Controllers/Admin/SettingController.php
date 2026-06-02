<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SettingRequest;
use App\Repositories\Contracts\SettingRepositoryInterface;
use App\Services\SettingService;

class SettingController extends Controller
{
    public function __construct(
        private readonly SettingRepositoryInterface $settings,
        private readonly SettingService $service,
    ) {}

    public function index()
    {
        return view('admin.settings.index', [
            'setting' => $this->settings->current(),
        ]);
    }

    public function update(SettingRequest $request)
    {
        $this->service->update($request->validated());

        return redirect()->route('admin.settings.index')->with('success', 'Settings website berhasil diperbarui.');
    }
}
