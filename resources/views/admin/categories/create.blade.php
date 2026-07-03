@extends('admin.layouts.admin')

@section('title', 'Tambah Kategori')

@section('content')
    <div class="mb-8">
        <h1 class="font-display text-3xl uppercase tracking-wide">Tambah <span class="text-gta-accent">Kategori</span></h1>
    </div>

    <form method="POST" action="{{ route('admin.categories.store') }}">
        @include('admin.categories._form')
    </form>
@endsection
