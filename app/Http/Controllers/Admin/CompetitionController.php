<?php

namespace App\Http\Controllers\Admin;

use App\Enums\CompetitionStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CompetitionRequest;
use App\Models\Competition;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use App\Repositories\Contracts\CompetitionRepositoryInterface;
use App\Services\CompetitionService;
use Illuminate\Http\Request;

class CompetitionController extends Controller
{
    public function __construct(
        private readonly CompetitionRepositoryInterface $competitions,
        private readonly CategoryRepositoryInterface $categories,
        private readonly CompetitionService $service,
    ) {}

    public function index(Request $request)
    {
        return view('admin.competitions.index', [
            'competitions' => $this->competitions->paginateAdmin($request->only(['search', 'status'])),
            'statuses' => CompetitionStatus::cases(),
        ]);
    }

    public function create()
    {
        return view('admin.competitions.form', [
            'competition' => new Competition([
                'registration_start' => now(),
                'registration_end' => now()->addMonth(),
                'event_date' => now()->addMonths(2),
                'quota' => 50,
                'status' => CompetitionStatus::Draft,
            ]),
            'categories' => $this->categories->all(),
            'statuses' => CompetitionStatus::cases(),
        ]);
    }

    public function store(CompetitionRequest $request)
    {
        $this->service->store($request->validated());

        return redirect()->route('admin.competitions.index')->with('success', 'Lomba berhasil dibuat.');
    }

    public function show(Competition $competition)
    {
        return view('admin.competitions.show', [
            'competition' => $competition->load(['category', 'registrations'])->loadCount('registrations'),
        ]);
    }

    public function edit(Competition $competition)
    {
        return view('admin.competitions.form', [
            'competition' => $competition,
            'categories' => $this->categories->all(),
            'statuses' => CompetitionStatus::cases(),
        ]);
    }

    public function update(CompetitionRequest $request, Competition $competition)
    {
        $this->service->update($competition, $request->validated());

        return redirect()->route('admin.competitions.index')->with('success', 'Lomba berhasil diperbarui.');
    }

    public function destroy(Competition $competition)
    {
        abort_if($competition->registrations()->exists(), 422, 'Lomba yang sudah memiliki pendaftar tidak bisa dihapus.');

        $this->service->destroy($competition);

        return redirect()->route('admin.competitions.index')->with('success', 'Lomba berhasil dihapus.');
    }
}
