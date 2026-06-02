<?php

namespace App\Http\Controllers;

use App\Models\Competition;
use App\Repositories\Contracts\CompetitionRepositoryInterface;
use App\Repositories\Contracts\SettingRepositoryInterface;

class PublicCompetitionController extends Controller
{
    public function __construct(
        private readonly CompetitionRepositoryInterface $competitions,
        private readonly SettingRepositoryInterface $settings,
    ) {}

    public function index()
    {
        return view('public.competitions.index', [
            'setting' => $this->settings->current(),
            'competitions' => $this->competitions->paginatePublic(),
        ]);
    }

    public function show(Competition $competition)
    {
        abort_unless($competition->published()->whereKey($competition->id)->exists(), 404);

        return view('public.competitions.show', [
            'setting' => $this->settings->current(),
            'competition' => $competition->load(['category'])->loadCount('registrations'),
        ]);
    }
}
