@extends('admin.layouts.admin')

@section('title', 'Manage Categories')

@section('content')
    <div class="mb-8 flex flex-wrap items-end justify-between gap-4">
        <div>
            <h1 class="font-display text-3xl uppercase tracking-wide">Manage <span class="text-gta-accent">Categories</span></h1>
            <p class="mt-2 text-sm text-zinc-400">Categories used to group articles.</p>
        </div>
        <a href="{{ route('admin.categories.create') }}" class="btn-primary">+ Add Category</a>
    </div>

    <div class="glass-panel overflow-x-auto lg:max-w-3xl">
        <table class="admin-table w-full">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Slug</th>
                    <th>Article Count</th>
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
                                      onsubmit="return confirm('Delete the category \'{{ addslashes($category->name) }}\'? Its articles will not be deleted.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-admin-sm btn-delete">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="py-10 text-center text-zinc-500">No categories yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">{{ $categories->links('admin.partials.pagination') }}</div>
@endsection
