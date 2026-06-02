<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePublicRegistrationRequest;
use App\Models\Competition;
use App\Models\Registration;
use App\Repositories\Contracts\SettingRepositoryInterface;
use App\Services\RegistrationService;

class PublicRegistrationController extends Controller
{
    public function __construct(
        private readonly RegistrationService $registrations,
        private readonly SettingRepositoryInterface $settings,
    ) {}

    public function create(Competition $competition)
    {
        abort_unless($competition->acceptsRegistrations(), 403, 'Pendaftaran lomba ini sedang tidak dibuka.');

        return view('public.registrations.create', [
            'setting' => $this->settings->current(),
            'competition' => $competition->load('category'),
        ]);
    }

    public function store(StorePublicRegistrationRequest $request, Competition $competition)
    {
        $registration = $this->registrations->register($competition, $request->validated());

        return redirect()->route('registrations.success', $registration);
    }

    public function success(Registration $registration)
    {
        return view('public.registrations.success', [
            'setting' => $this->settings->current(),
            'registration' => $registration->load(['competition.category', 'members']),
        ]);
    }
}
