<?php

namespace App\Http\Controllers;

use App\Repositories\Contracts\AnnouncementRepositoryInterface;
use App\Repositories\Contracts\CompetitionRepositoryInterface;
use App\Repositories\Contracts\SettingRepositoryInterface;

class LandingController extends Controller
{
    public function __construct(
        private readonly CompetitionRepositoryInterface $competitions,
        private readonly AnnouncementRepositoryInterface $announcements,
        private readonly SettingRepositoryInterface $settings,
    ) {}

    public function index()
    {
        return view('public.home', [
            'setting' => $this->settings->current(),
            'competitions' => $this->competitions->featured(),
            'announcements' => $this->announcements->latestPublished(),
        ]);
    }
}
