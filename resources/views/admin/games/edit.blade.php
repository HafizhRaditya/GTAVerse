@extends('admin.layouts.admin')

@section('title', 'Edit Game')

@section('content')
    <div class="mb-8 flex flex-wrap items-end justify-between gap-3">
        <h1 class="font-display text-3xl uppercase tracking-wide">Edit <span class="text-gta-accent">{{ $game->title }}</span></h1>
        <a href="{{ route('games.show', $game) }}" target="_blank" class="text-xs font-bold uppercase tracking-widest text-cyan-400 hover:underline">Lihat halaman publik ↗</a>
    </div>

    <form method="POST" action="{{ route('admin.games.update', $game) }}" enctype="multipart/form-data">
        @method('PUT')
        @include('admin.games._form')
    </form>
@endsection
