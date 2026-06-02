@extends('layouts.admin')

@section('title', 'Kelola Pengumuman')

@section('content')
    <div class="mb-6 flex justify-end">
        <a href="{{ route('admin.announcements.create') }}" class="btn-primary">Tambah Pengumuman</a>
    </div>

    <div class="ui-card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-brand-soft text-xs uppercase text-slate-500 dark:bg-white/5 dark:text-slate-400">
                    <tr>
                        <th class="px-6 py-4">Judul</th>
                        <th class="px-6 py-4">Lomba</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4">Tanggal</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-white/10">
                    @foreach ($announcements as $announcement)
                        <tr>
                            <td class="px-6 py-4">
                                <p class="font-black text-slate-900 dark:text-white">{{ $announcement->title }}</p>
                                @if ($announcement->is_important)
                                    <span class="badge mt-2 bg-brand-red text-white">Penting</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-slate-600 dark:text-slate-300">{{ $announcement->competition?->title ?? 'Umum' }}</td>
                            <td class="px-6 py-4">
                                <span class="badge {{ $announcement->is_published ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/50 dark:text-emerald-200' : 'bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-200' }}">{{ $announcement->is_published ? 'Published' : 'Draft' }}</span>
                            </td>
                            <td class="px-6 py-4 text-slate-600 dark:text-slate-300">{{ $announcement->published_at?->format('d M Y H:i') ?? '-' }}</td>
                            <td class="px-6 py-4">
                                <div class="flex justify-end gap-2">
                                    <a class="btn-secondary px-4 py-2" href="{{ route('admin.announcements.edit', $announcement) }}">Edit</a>
                                    <form method="POST" action="{{ route('admin.announcements.destroy', $announcement) }}" onsubmit="return confirm('Hapus pengumuman ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn-danger" type="submit">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">{{ $announcements->links() }}</div>
@endsection
