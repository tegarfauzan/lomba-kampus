<?php

namespace App\Repositories;

use App\Models\Announcement;
use App\Repositories\Contracts\AnnouncementRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class EloquentAnnouncementRepository implements AnnouncementRepositoryInterface
{
    public function latestPublished(int $limit = 4): Collection
    {
        return Announcement::query()
            ->with('competition')
            ->published()
            ->latest('published_at')
            ->limit($limit)
            ->get();
    }

    public function paginatePublic(array $filters = [], int $perPage = 9): LengthAwarePaginator
    {
        return Announcement::query()
            ->with('competition')
            ->published()
            ->when($filters['competition_id'] ?? null, fn ($query, string $competitionId) => $query->where('competition_id', $competitionId))
            ->latest('published_at')
            ->paginate($perPage)
            ->withQueryString();
    }

    public function paginateAdmin(int $perPage = 10): LengthAwarePaginator
    {
        return Announcement::query()
            ->with('competition')
            ->latest()
            ->paginate($perPage);
    }

    public function create(array $data): Announcement
    {
        return Announcement::query()->create($data);
    }

    public function update(Announcement $announcement, array $data): Announcement
    {
        $announcement->update($data);

        return $announcement->refresh();
    }

    public function delete(Announcement $announcement): bool
    {
        return (bool) $announcement->delete();
    }
}
