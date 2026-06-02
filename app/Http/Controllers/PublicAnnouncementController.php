<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Repositories\Contracts\AnnouncementRepositoryInterface;
use App\Repositories\Contracts\CompetitionRepositoryInterface;
use App\Repositories\Contracts\SettingRepositoryInterface;
use Illuminate\Http\Request;

class PublicAnnouncementController extends Controller
{
    public function __construct(
        private readonly AnnouncementRepositoryInterface $announcements,
        private readonly CompetitionRepositoryInterface $competitions,
        private readonly SettingRepositoryInterface $settings,
    ) {}

    public function index(Request $request)
    {
        return view('public.announcements.index', [
            'setting' => $this->settings->current(),
            'announcements' => $this->announcements->paginatePublic($request->only('competition_id')),
            'competitions' => $this->competitions->paginatePublic(100),
        ]);
    }

    public function show(Announcement $announcement)
    {
        abort_unless($announcement->is_published && $announcement->published_at?->lte(now()), 404);

        return view('public.announcements.show', [
            'setting' => $this->settings->current(),
            'announcement' => $announcement->load('competition'),
        ]);
    }
}
