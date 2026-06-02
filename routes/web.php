<?php

use App\Http\Controllers\Admin\AnnouncementController as AdminAnnouncementController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\CompetitionController as AdminCompetitionController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\RegistrationController as AdminRegistrationController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicAnnouncementController;
use App\Http\Controllers\PublicCompetitionController;
use App\Http\Controllers\PublicRegistrationController;
use App\Http\Controllers\StatusCheckController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LandingController::class, 'index'])->name('home');
Route::get('/lomba', [PublicCompetitionController::class, 'index'])->name('competitions.index');
Route::get('/lomba/{competition:slug}', [PublicCompetitionController::class, 'show'])->name('competitions.show');
Route::get('/lomba/{competition:slug}/daftar', [PublicRegistrationController::class, 'create'])->name('registrations.create');
Route::post('/lomba/{competition:slug}/daftar', [PublicRegistrationController::class, 'store'])->name('registrations.store');
Route::get('/pendaftaran/berhasil/{registration:registration_code}', [PublicRegistrationController::class, 'success'])->name('registrations.success');
Route::get('/cek-status', [StatusCheckController::class, 'index'])->name('status.index');
Route::post('/cek-status', [StatusCheckController::class, 'check'])->name('status.check');
Route::get('/pengumuman', [PublicAnnouncementController::class, 'index'])->name('announcements.index');
Route::get('/pengumuman/{announcement:slug}', [PublicAnnouncementController::class, 'show'])->name('announcements.show');

Route::redirect('/dashboard', '/admin/dashboard')->middleware('auth')->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function (): void {
        Route::get('/dashboard', DashboardController::class)->name('dashboard');

        Route::resource('categories', AdminCategoryController::class)->except('show');
        Route::resource('competitions', AdminCompetitionController::class);
        Route::resource('registrations', AdminRegistrationController::class)->only(['index', 'show', 'destroy']);
        Route::patch('registrations/{registration}/approve', [AdminRegistrationController::class, 'approve'])->name('registrations.approve');
        Route::patch('registrations/{registration}/reject', [AdminRegistrationController::class, 'reject'])->name('registrations.reject');
        Route::get('registrations/{registration}/document', [AdminRegistrationController::class, 'download'])->name('registrations.download');
        Route::resource('announcements', AdminAnnouncementController::class)->except('show');
        Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
        Route::put('settings', [SettingController::class, 'update'])->name('settings.update');
    });

require __DIR__.'/auth.php';
