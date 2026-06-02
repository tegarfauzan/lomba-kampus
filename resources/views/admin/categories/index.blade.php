@extends('layouts.admin')

@section('title', 'Kategori Lomba')

@section('content')
    <div class="mb-6 flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
        <p class="max-w-2xl text-sm leading-6 text-slate-600 dark:text-slate-300">Kelompokkan lomba agar peserta mudah menemukan kategori yang relevan.</p>
        <a href="{{ route('admin.categories.create') }}" class="btn-primary">Tambah Kategori</a>
    </div>

    <div class="ui-card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-brand-soft text-xs uppercase text-slate-500 dark:bg-white/5 dark:text-slate-400">
                    <tr>
                        <th class="px-6 py-4">Nama</th>
                        <th class="px-6 py-4">Slug</th>
                        <th class="px-6 py-4">Lomba</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-white/10">
                    @foreach ($categories as $category)
                        <tr>
                            <td class="px-6 py-4 font-black text-slate-900 dark:text-white">{{ $category->name }}</td>
                            <td class="px-6 py-4 text-slate-600 dark:text-slate-300">{{ $category->slug }}</td>
                            <td class="px-6 py-4">{{ $category->competitions_count }}</td>
                            <td class="px-6 py-4">
                                <div class="flex justify-end gap-2">
                                    <a class="btn-secondary px-4 py-2" href="{{ route('admin.categories.edit', $category) }}">Edit</a>
                                    <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" onsubmit="return confirm('Hapus kategori ini?')">
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

    <div class="mt-6">{{ $categories->links() }}</div>
@endsection
