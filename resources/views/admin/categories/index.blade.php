@extends('admin.layouts.admin')

@section('title', 'Kelola Kategori')

@section('content')
    <div class="mb-8 flex flex-wrap items-end justify-between gap-4">
        <div>
            <h1 class="font-display text-3xl uppercase tracking-wide">Kelola <span class="text-gta-accent">Kategori</span></h1>
            <p class="mt-2 text-sm text-zinc-400">Kategori untuk mengelompokkan artikel.</p>
        </div>
        <a href="{{ route('admin.categories.create') }}" class="btn-primary">+ Tambah Kategori</a>
    </div>

    <div class="glass-panel overflow-x-auto lg:max-w-3xl">
        <table class="admin-table w-full">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Slug</th>
                    <th>Jumlah Artikel</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($categories as $category)
                    <tr>
                        <td class="font-semibold">{{ $category->name }}</td>
                        <td class="text-zinc-400">{{ $category->slug }}</td>
                        <td><span class="badge-admin badge-cyan">{{ $category->articles_count }}</span></td>
                        <td>
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('admin.categories.edit', $category) }}" class="btn-admin-sm btn-edit">Edit</a>
                                <form method="POST" action="{{ route('admin.categories.destroy', $category) }}"
                                      onsubmit="return confirm('Hapus kategori \'{{ addslashes($category->name) }}\'? Artikel di dalamnya tidak ikut terhapus.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-admin-sm btn-delete">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="py-10 text-center text-zinc-500">Belum ada kategori.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">{{ $categories->links('admin.partials.pagination') }}</div>
@endsection
