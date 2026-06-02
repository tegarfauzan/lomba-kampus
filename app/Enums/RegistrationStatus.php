<?php

namespace App\Enums;

enum RegistrationStatus: string
{
    case Pending = 'pending';
    case Approved = 'approved';
    case Rejected = 'rejected';

    public function label(): string
    {
        return match ($this) {
            self::Pending => 'Menunggu Verifikasi',
            self::Approved => 'Diterima',
            self::Rejected => 'Ditolak',
        };
    }

    public function badgeClasses(): string
    {
        return match ($this) {
            self::Pending => 'bg-amber-100 text-amber-700 dark:bg-amber-900/50 dark:text-amber-200',
            self::Approved => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/50 dark:text-emerald-200',
            self::Rejected => 'bg-red-100 text-red-700 dark:bg-red-900/50 dark:text-red-200',
        };
    }
}
