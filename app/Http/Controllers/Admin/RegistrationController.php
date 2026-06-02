<?php

namespace App\Http\Controllers\Admin;

use App\Enums\RegistrationStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RegistrationDecisionRequest;
use App\Models\Registration;
use App\Repositories\Contracts\CompetitionRepositoryInterface;
use App\Repositories\Contracts\RegistrationRepositoryInterface;
use App\Services\RegistrationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RegistrationController extends Controller
{
    public function __construct(
        private readonly RegistrationRepositoryInterface $registrations,
        private readonly CompetitionRepositoryInterface $competitions,
        private readonly RegistrationService $service,
    ) {}

    public function index(Request $request)
    {
        return view('admin.registrations.index', [
            'registrations' => $this->registrations->paginateAdmin($request->only(['search', 'competition_id', 'status'])),
            'competitions' => $this->competitions->all(),
            'statuses' => RegistrationStatus::cases(),
        ]);
    }

    public function show(Registration $registration)
    {
        return view('admin.registrations.show', [
            'registration' => $registration->load(['competition.category', 'members']),
            'statuses' => RegistrationStatus::cases(),
        ]);
    }

    public function approve(RegistrationDecisionRequest $request, Registration $registration)
    {
        $this->service->approve($registration, $request->validated('admin_note'));

        return redirect()->route('admin.registrations.show', $registration)->with('success', 'Pendaftar berhasil diterima.');
    }

    public function reject(RegistrationDecisionRequest $request, Registration $registration)
    {
        $this->service->reject($registration, $request->validated('admin_note'));

        return redirect()->route('admin.registrations.show', $registration)->with('success', 'Pendaftar berhasil ditolak.');
    }

    public function download(Registration $registration)
    {
        abort_unless($registration->document_file && Storage::disk('public')->exists($registration->document_file), 404);

        return Storage::disk('public')->download($registration->document_file);
    }

    public function destroy(Registration $registration)
    {
        $this->service->destroy($registration);

        return redirect()->route('admin.registrations.index')->with('success', 'Data pendaftar berhasil dihapus.');
    }
}
