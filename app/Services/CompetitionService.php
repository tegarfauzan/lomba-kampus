<?php

namespace App\Services;

use App\Models\Competition;
use App\Repositories\Contracts\CompetitionRepositoryInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CompetitionService
{
    public function __construct(private readonly CompetitionRepositoryInterface $competitions) {}

    public function store(array $data): Competition
    {
        $data = $this->preparePayload($data);

        return $this->competitions->create($data);
    }

    public function update(Competition $competition, array $data): Competition
    {
        $data = $this->preparePayload($data, $competition);

        if (isset($data['poster']) && $competition->poster) {
            Storage::disk('public')->delete($competition->poster);
        }

        return $this->competitions->update($competition, $data);
    }

    public function destroy(Competition $competition): bool
    {
        if ($competition->poster) {
            Storage::disk('public')->delete($competition->poster);
        }

        return $this->competitions->delete($competition);
    }

    private function preparePayload(array $data, ?Competition $competition = null): array
    {
        $payload = Arr::except($data, ['poster']);
        $payload['slug'] = $payload['slug'] ?? Str::slug($payload['title']);
        $payload['quota'] = $payload['quota'] ?? 0;

        if (($data['poster'] ?? null) instanceof UploadedFile) {
            $payload['poster'] = $data['poster']->store('competition-posters', 'public');
        } elseif ($competition) {
            unset($payload['poster']);
        }

        return $payload;
    }
}
