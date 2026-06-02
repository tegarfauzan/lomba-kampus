<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckRegistrationStatusRequest;
use App\Repositories\Contracts\RegistrationRepositoryInterface;
use App\Repositories\Contracts\SettingRepositoryInterface;

class StatusCheckController extends Controller
{
    public function __construct(
        private readonly RegistrationRepositoryInterface $registrations,
        private readonly SettingRepositoryInterface $settings,
    ) {}

    public function index()
    {
        return view('public.status.index', [
            'setting' => $this->settings->current(),
            'registration' => null,
        ]);
    }

    public function check(CheckRegistrationStatusRequest $request)
    {
        $registration = $this->registrations->findByCodeOrEmail($request->validated('keyword'));

        return view('public.status.index', [
            'setting' => $this->settings->current(),
            'registration' => $registration,
            'keyword' => $request->validated('keyword'),
        ]);
    }
}
