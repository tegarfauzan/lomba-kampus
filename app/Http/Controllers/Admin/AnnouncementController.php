<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AnnouncementRequest;
use App\Models\Announcement;
use App\Repositories\Contracts\AnnouncementRepositoryInterface;
use App\Repositories\Contracts\CompetitionRepositoryInterface;
use App\Services\AnnouncementService;

class AnnouncementController extends Controller
{
    public function __construct(
        private readonly AnnouncementRepositoryInterface $announcements,
        private readonly CompetitionRepositoryInterface $competitions,
        private readonly AnnouncementService $service,
    ) {}

    public function index()
    {
        return view('admin.announcements.index', [
            'announcements' => $this->announcements->paginateAdmin(),
        ]);
    }

    public function create()
    {
        return view('admin.announcements.form', [
            'announcement' => new Announcement(['is_published' => true, 'published_at' => now()]),
            'competitions' => $this->competitions->all(),
        ]);
    }

    public function store(AnnouncementRequest $request)
    {
        $this->service->store($request->validated());

        return redirect()->route('admin.announcements.index')->with('success', 'Pengumuman berhasil dibuat.');
    }

    public function edit(Announcement $announcement)
    {
        return view('admin.announcements.form', [
            'announcement' => $announcement,
            'competitions' => $this->competitions->all(),
        ]);
    }

    public function update(AnnouncementRequest $request, Announcement $announcement)
    {
        $this->service->update($announcement, $request->validated());

        return redirect()->route('admin.announcements.index')->with('success', 'Pengumuman berhasil diperbarui.');
    }

    public function destroy(Announcement $announcement)
    {
        $this->service->destroy($announcement);

        return redirect()->route('admin.announcements.index')->with('success', 'Pengumuman berhasil dihapus.');
    }
}
