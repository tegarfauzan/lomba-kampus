<?php

namespace App\Repositories;

use App\Models\Registration;
use App\Repositories\Contracts\RegistrationRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class EloquentRegistrationRepository implements RegistrationRepositoryInterface
{
    public function paginateAdmin(array $filters = [], int $perPage = 10): LengthAwarePaginator
    {
        return Registration::query()
            ->with(['competition.category'])
            ->when($filters['search'] ?? null, function ($query, string $search): void {
                $query->where(function ($query) use ($search): void {
                    $query->where('registration_code', 'like', "%{$search}%")
                        ->orWhere('team_name', 'like', "%{$search}%")
                        ->orWhere('leader_name', 'like', "%{$search}%")
                        ->orWhere('leader_email', 'like', "%{$search}%");
                });
            })
            ->when($filters['competition_id'] ?? null, fn ($query, string $competitionId) => $query->where('competition_id', $competitionId))
            ->when($filters['status'] ?? null, fn ($query, string $status) => $query->where('status', $status))
            ->latest()
            ->paginate($perPage)
            ->withQueryString();
    }

    public function latest(int $limit = 8)
    {
        return Registration::query()
            ->with('competition')
            ->latest()
            ->limit($limit)
            ->get();
    }

    public function create(array $data): Registration
    {
        return Registration::query()->create($data);
    }

    public function findByCodeOrEmail(string $keyword): ?Registration
    {
        return Registration::query()
            ->with(['competition.category', 'members'])
            ->where('registration_code', $keyword)
            ->orWhere('leader_email', $keyword)
            ->latest()
            ->first();
    }

    public function countByStatus(?string $status = null): int
    {
        return Registration::query()
            ->when($status, fn ($query) => $query->where('status', $status))
            ->count();
    }

    public function update(Registration $registration, array $data): Registration
    {
        $registration->update($data);

        return $registration->refresh();
    }

    public function delete(Registration $registration): bool
    {
        return (bool) $registration->delete();
    }
}
