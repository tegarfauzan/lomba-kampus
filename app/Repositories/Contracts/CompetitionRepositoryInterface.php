<?php

namespace App\Repositories\Contracts;

use App\Models\Competition;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface CompetitionRepositoryInterface
{
    public function all(): Collection;

    public function featured(int $limit = 6): Collection;

    public function openCount(): int;

    public function paginatePublic(int $perPage = 9): LengthAwarePaginator;

    public function paginateAdmin(array $filters = [], int $perPage = 10): LengthAwarePaginator;

    public function create(array $data): Competition;

    public function update(Competition $competition, array $data): Competition;

    public function delete(Competition $competition): bool;
}
