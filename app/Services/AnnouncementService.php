<?php

namespace App\Services;

use App\Models\Announcement;
use App\Repositories\Contracts\AnnouncementRepositoryInterface;
use Illuminate\Support\Str;

class AnnouncementService
{
    public function __construct(private readonly AnnouncementRepositoryInterface $announcements) {}

    public function store(array $data): Announcement
    {
        return $this->announcements->create($this->preparePayload($data));
    }

    public function update(Announcement $announcement, array $data): Announcement
    {
        return $this->announcements->update($announcement, $this->preparePayload($data, $announcement));
    }

    public function destroy(Announcement $announcement): bool
    {
        return $this->announcements->delete($announcement);
    }

    private function preparePayload(array $data, ?Announcement $announcement = null): array
    {
        $data['slug'] = $data['slug'] ?? Str::slug($data['title']);
        $data['competition_id'] = $data['competition_id'] ?? null;
        $data['is_published'] = (bool) ($data['is_published'] ?? false);
        $data['is_important'] = (bool) ($data['is_important'] ?? false);
        $data['published_at'] = $data['is_published']
            ? ($data['published_at'] ?? $announcement?->published_at ?? now())
            : null;

        return $data;
    }
}
