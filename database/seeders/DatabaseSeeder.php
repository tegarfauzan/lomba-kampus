<?php

namespace Database\Seeders;

use App\Enums\CompetitionStatus;
use App\Enums\RegistrationStatus;
use App\Models\Announcement;
use App\Models\Category;
use App\Models\Competition;
use App\Models\Registration;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $adminRole = Role::query()->firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);

        $admin = User::query()->updateOrCreate(
            ['email' => 'admin@kampus.test'],
            [
                'name' => 'Admin Panitia',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ],
        );

        $admin->assignRole($adminRole);

        Setting::query()->updateOrCreate(
            ['id' => 1],
            [
                'organization_name' => 'Himpunan Mahasiswa Kreatif',
                'event_name' => 'Kompetisi Mahasiswa 2026',
                'description' => 'Daftarkan timmu, tampilkan karya terbaik, dan jadilah bagian dari kompetisi kampus yang bersih, rapi, dan mudah dipantau.',
                'contact_email' => 'panitia@kampus.test',
                'contact_phone' => '6281234567890',
                'instagram_url' => 'https://instagram.com/kampusjuara',
                'address' => 'Sekretariat Organisasi Kampus, Gedung Student Center',
                'footer_text' => 'Website pendaftaran lomba organisasi kampus.',
            ],
        );

        $categories = collect([
            ['name' => 'Design', 'icon' => 'UI', 'description' => 'Kompetisi visual, desain produk digital, dan presentasi kreatif.'],
            ['name' => 'Technology', 'icon' => 'DEV', 'description' => 'Kompetisi pengembangan web, aplikasi, dan solusi digital.'],
            ['name' => 'Business', 'icon' => 'BIZ', 'description' => 'Kompetisi rencana bisnis dan inovasi kewirausahaan.'],
            ['name' => 'Writing', 'icon' => 'ESS', 'description' => 'Kompetisi esai ilmiah dan gagasan strategis.'],
        ])->mapWithKeys(function (array $data): array {
            $category = Category::query()->updateOrCreate(
                ['slug' => Str::slug($data['name'])],
                $data + ['slug' => Str::slug($data['name'])],
            );

            return [$data['name'] => $category];
        });

        $competitions = collect([
            [
                'category' => 'Design',
                'title' => 'UI/UX Design Challenge',
                'description' => 'Kompetisi desain antarmuka dan pengalaman pengguna untuk menyelesaikan masalah nyata di lingkungan kampus.',
                'poster' => 'https://images.unsplash.com/photo-1559028006-448665bd7c7f?auto=format&fit=crop&w=1200&q=80',
                'rules' => "Karya wajib orisinal.\nPeserta mengirim link prototype dan dokumen studi kasus.\nPresentasi final dilakukan oleh seluruh anggota tim.",
                'requirements' => "Mahasiswa aktif.\nSatu tim berisi 2-4 orang.\nMembawa kartu mahasiswa saat final.",
                'prize' => "Juara 1: Rp3.000.000\nJuara 2: Rp2.000.000\nJuara 3: Rp1.000.000",
                'quota' => 40,
                'status' => CompetitionStatus::Open,
            ],
            [
                'category' => 'Technology',
                'title' => 'Web Development Sprint',
                'description' => 'Bangun aplikasi web yang aman, responsif, dan relevan untuk kegiatan organisasi kampus.',
                'poster' => 'https://images.unsplash.com/photo-1498050108023-c5249f4df085?auto=format&fit=crop&w=1200&q=80',
                'rules' => "Framework bebas.\nRepository wajib private sampai penjurian selesai.\nDemo live maksimal 7 menit.",
                'requirements' => "Tim 2-3 orang.\nMenguasai dasar Git.\nMembawa laptop pribadi.",
                'prize' => 'Total hadiah Rp6.000.000 dan sertifikat.',
                'quota' => 35,
                'status' => CompetitionStatus::Open,
            ],
            [
                'category' => 'Business',
                'title' => 'Business Plan Competition',
                'description' => 'Rancang model bisnis yang feasible, berdampak, dan siap dipresentasikan kepada panel juri.',
                'poster' => 'https://images.unsplash.com/photo-1556761175-b413da4baf72?auto=format&fit=crop&w=1200&q=80',
                'rules' => "Proposal maksimal 20 halaman.\nPitch deck maksimal 12 slide.\nData riset harus dapat dipertanggungjawabkan.",
                'requirements' => "Tim 3-5 orang.\nMinimal satu anggota berasal dari kampus penyelenggara.",
                'prize' => 'Pendanaan pembinaan dan total hadiah Rp7.500.000.',
                'quota' => 30,
                'status' => CompetitionStatus::Open,
            ],
            [
                'category' => 'Writing',
                'title' => 'Essay Competition',
                'description' => 'Tulis esai argumentatif tentang masa depan organisasi mahasiswa dan dampaknya bagi masyarakat.',
                'poster' => 'https://images.unsplash.com/photo-1455390582262-044cdead277a?auto=format&fit=crop&w=1200&q=80',
                'rules' => "Naskah 1500-2500 kata.\nPlagiarisme maksimal 15 persen.\nFormat PDF.",
                'requirements' => "Peserta individu.\nMahasiswa aktif S1/D4.",
                'prize' => 'Juara 1-3 mendapatkan uang pembinaan dan publikasi karya.',
                'quota' => 80,
                'status' => CompetitionStatus::Closed,
            ],
        ])->map(function (array $data) use ($categories): Competition {
            return Competition::query()->updateOrCreate(
                ['slug' => Str::slug($data['title'])],
                [
                    'category_id' => $categories[$data['category']]->id,
                    'title' => $data['title'],
                    'slug' => Str::slug($data['title']),
                    'description' => $data['description'],
                    'poster' => $data['poster'],
                    'rules' => $data['rules'],
                    'requirements' => $data['requirements'],
                    'prize' => $data['prize'],
                    'quota' => $data['quota'],
                    'registration_start' => now()->subDays(10),
                    'registration_end' => $data['status'] === CompetitionStatus::Closed ? now()->subDay() : now()->addDays(25),
                    'event_date' => now()->addDays(40),
                    'status' => $data['status']->value,
                ],
            );
        });

        $competitions->take(3)->each(function (Competition $competition, int $index): void {
            $registration = Registration::query()->updateOrCreate(
                ['registration_code' => sprintf('REG-%s-%s-%04d', Str::of($competition->slug)->replace('-', '')->upper()->substr(0, 3)->padRight(3, 'X'), now()->year, $index + 1)],
                [
                    'competition_id' => $competition->id,
                    'team_name' => ['Tim Aksara', 'Pixel Pioneers', 'Nusa Innovators'][$index],
                    'leader_name' => ['Raka Pratama', 'Dina Aulia', 'Salsa Maharani'][$index],
                    'leader_email' => ['raka@example.com', 'dina@example.com', 'salsa@example.com'][$index],
                    'leader_phone' => ['628111111111', '628222222222', '628333333333'][$index],
                    'institution' => 'Universitas Nusantara',
                    'major' => ['Informatika', 'Desain Komunikasi Visual', 'Manajemen'][$index],
                    'status' => [RegistrationStatus::Pending, RegistrationStatus::Approved, RegistrationStatus::Rejected][$index]->value,
                    'admin_note' => $index === 2 ? 'Dokumen belum sesuai format yang diminta.' : null,
                    'verified_at' => $index === 0 ? null : now(),
                ],
            );

            $registration->members()->delete();
            $registration->members()->createMany([
                [
                    'name' => 'Anggota Satu',
                    'email' => 'anggota1@example.com',
                    'phone' => '628444444444',
                    'institution' => 'Universitas Nusantara',
                    'major' => 'Informatika',
                ],
                [
                    'name' => 'Anggota Dua',
                    'email' => 'anggota2@example.com',
                    'phone' => '628555555555',
                    'institution' => 'Universitas Nusantara',
                    'major' => 'Sistem Informasi',
                ],
            ]);
        });

        Announcement::query()->updateOrCreate(
            ['slug' => 'pendaftaran-dibuka'],
            [
                'competition_id' => null,
                'title' => 'Pendaftaran Kompetisi Mahasiswa 2026 Dibuka',
                'slug' => 'pendaftaran-dibuka',
                'content' => 'Pendaftaran lomba telah dibuka. Peserta dapat memilih lomba, membaca ketentuan, dan mengirim data tim melalui website.',
                'is_published' => true,
                'is_important' => true,
                'published_at' => now()->subDays(2),
            ],
        );

        Announcement::query()->updateOrCreate(
            ['slug' => 'technical-meeting-ui-ux'],
            [
                'competition_id' => $competitions->first()->id,
                'title' => 'Technical Meeting UI/UX Design Challenge',
                'slug' => 'technical-meeting-ui-ux',
                'content' => 'Technical meeting akan dilaksanakan secara daring. Link meeting dikirim melalui email ketua tim yang sudah diverifikasi.',
                'is_published' => true,
                'is_important' => false,
                'published_at' => now()->subDay(),
            ],
        );
    }
}
