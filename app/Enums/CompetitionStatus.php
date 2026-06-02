<?php

namespace App\Enums;

enum CompetitionStatus: string
{
    case Draft = 'draft';
    case Open = 'open';
    case Closed = 'closed';
    case Ongoing = 'ongoing';
    case Finished = 'finished';

    public function label(): string
    {
        return match ($this) {
            self::Draft => 'Draft',
            self::Open => 'Pendaftaran Dibuka',
            self::Closed => 'Pendaftaran Ditutup',
            self::Ongoing => 'Sedang Berlangsung',
            self::Finished => 'Selesai',
        };
    }

    public function badgeClasses(): string
    {
        return match ($this) {
            self::Draft => 'bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-200',
            self::Open => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/50 dark:text-emerald-200',
            self::Closed => 'bg-amber-100 text-amber-700 dark:bg-amber-900/50 dark:text-amber-200',
            self::Ongoing => 'bg-blue-100 text-blue-700 dark:bg-blue-900/50 dark:text-blue-200',
            self::Finished => 'bg-brand-cream text-brand-maroon dark:bg-brand-maroon/60 dark:text-brand-cream',
        };
    }
}
