<?php

namespace App\Repositories\Contracts;

use App\Models\Announcement;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface AnnouncementRepositoryInterface
{
    public function latestPublished(int $limit = 4): Collection;

    public function paginatePublic(array $filters = [], int $perPage = 9): LengthAwarePaginator;

    public function paginateAdmin(int $perPage = 10): LengthAwarePaginator;

    public function create(array $data): Announcement;

    public function update(Announcement $announcement, array $data): Announcement;

    public function delete(Announcement $announcement): bool;
}
