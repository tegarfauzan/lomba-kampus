<?php

namespace App\Services;

use App\Enums\RegistrationStatus;
use App\Models\Competition;
use App\Models\Registration;
use App\Repositories\Contracts\RegistrationRepositoryInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class RegistrationService
{
    public function __construct(private readonly RegistrationRepositoryInterface $registrations) {}

    public function register(Competition $competition, array $data): Registration
    {
        return DB::transaction(function () use ($competition, $data): Registration {
            $lockedCompetition = Competition::query()
                ->with('category')
                ->lockForUpdate()
                ->findOrFail($competition->id);

            abort_unless($lockedCompetition->acceptsRegistrations(), 403, 'Pendaftaran lomba ini sedang tidak dibuka.');

            $payload = Arr::except($data, ['document_file', 'members', 'terms']);
            $payload['competition_id'] = $lockedCompetition->id;
            $payload['registration_code'] = $this->generateCode($lockedCompetition);
            $payload['status'] = RegistrationStatus::Pending->value;

            if (($data['document_file'] ?? null) instanceof UploadedFile) {
                $payload['document_file'] = $data['document_file']->store('registration-documents', 'public');
            }

            $registration = $this->registrations->create($payload);

            collect($data['members'] ?? [])
                ->filter(fn (array $member): bool => filled($member['name'] ?? null))
                ->each(fn (array $member) => $registration->members()->create($member));

            return $registration->load(['competition.category', 'members']);
        });
    }

    public function approve(Registration $registration, ?string $note = null): Registration
    {
        return $this->registrations->update($registration, [
            'status' => RegistrationStatus::Approved->value,
            'admin_note' => $note,
            'verified_at' => now(),
        ]);
    }

    public function reject(Registration $registration, string $note): Registration
    {
        return $this->registrations->update($registration, [
            'status' => RegistrationStatus::Rejected->value,
            'admin_note' => $note,
            'verified_at' => now(),
        ]);
    }

    public function destroy(Registration $registration): bool
    {
        if ($registration->document_file) {
            Storage::disk('public')->delete($registration->document_file);
        }

        return $this->registrations->delete($registration);
    }

    private function generateCode(Competition $competition): string
    {
        $prefix = Str::of($competition->slug)->replace('-', '')->upper()->substr(0, 3)->padRight(3, 'X');
        $year = now()->year;
        $sequence = $competition->registrations()->count() + 1;

        return sprintf('REG-%s-%s-%04d', $prefix, $year, $sequence);
    }
}
