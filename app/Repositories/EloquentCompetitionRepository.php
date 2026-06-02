<?php

namespace App\Repositories;

use App\Enums\CompetitionStatus;
use App\Models\Competition;
use App\Repositories\Contracts\CompetitionRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class EloquentCompetitionRepository implements CompetitionRepositoryInterface
{
    public function all(): Collection
    {
        return Competition::query()->orderBy('title')->get();
    }

    public function featured(int $limit = 6): Collection
    {
        return Competition::query()
            ->with('category')
            ->withCount('registrations')
            ->published()
            ->latest()
            ->limit($limit)
            ->get();
    }

    public function openCount(): int
    {
        return Competition::query()->where('status', CompetitionStatus::Open->value)->count();
    }

    public function paginatePublic(int $perPage = 9): LengthAwarePaginator
    {
        return Competition::query()
            ->with('category')
            ->withCount('registrations')
            ->published()
            ->latest()
            ->paginate($perPage);
    }

    public function paginateAdmin(array $filters = [], int $perPage = 10): LengthAwarePaginator
    {
        return Competition::query()
            ->with('category')
            ->withCount('registrations')
            ->when($filters['search'] ?? null, function ($query, string $search): void {
                $query->where(function ($query) use ($search): void {
                    $query->where('title', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
                });
            })
            ->when($filters['status'] ?? null, fn ($query, string $status) => $query->where('status', $status))
            ->latest()
            ->paginate($perPage)
            ->withQueryString();
    }

    public function create(array $data): Competition
    {
        return Competition::query()->create($data);
    }

    public function update(Competition $competition, array $data): Competition
    {
        $competition->update($data);

        return $competition->refresh();
    }

    public function delete(Competition $competition): bool
    {
        return (bool) $competition->delete();
    }
}
