<?php

namespace App\Services;

use App\Enums\RegistrationStatus;
use App\Repositories\Contracts\AnnouncementRepositoryInterface;
use App\Repositories\Contracts\CompetitionRepositoryInterface;
use App\Repositories\Contracts\RegistrationRepositoryInterface;

class DashboardService
{
    public function __construct(
        private readonly CompetitionRepositoryInterface $competitions,
        private readonly RegistrationRepositoryInterface $registrations,
        private readonly AnnouncementRepositoryInterface $announcements,
    ) {}

    public function summary(): array
    {
        return [
            'open_competitions' => $this->competitions->openCount(),
            'total_registrations' => $this->registrations->countByStatus(),
            'pending_registrations' => $this->registrations->countByStatus(RegistrationStatus::Pending->value),
            'approved_registrations' => $this->registrations->countByStatus(RegistrationStatus::Approved->value),
            'rejected_registrations' => $this->registrations->countByStatus(RegistrationStatus::Rejected->value),
            'latest_registrations' => $this->registrations->latest(),
            'latest_announcements' => $this->announcements->latestPublished(),
        ];
    }
}
