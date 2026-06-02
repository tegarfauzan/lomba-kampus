<?php

namespace App\Repositories\Contracts;

use App\Models\Registration;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface RegistrationRepositoryInterface
{
    public function paginateAdmin(array $filters = [], int $perPage = 10): LengthAwarePaginator;

    public function latest(int $limit = 8);

    public function create(array $data): Registration;

    public function findByCodeOrEmail(string $keyword): ?Registration;

    public function countByStatus(?string $status = null): int;

    public function update(Registration $registration, array $data): Registration;

    public function delete(Registration $registration): bool;
}
