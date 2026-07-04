@extends('admin.layouts.admin')

@section('title', 'Edit Character')

@section('content')
    <div class="mb-8 flex flex-wrap items-end justify-between gap-3">
        <h1 class="font-display text-3xl uppercase tracking-wide">Edit <span class="text-gta-accent">{{ $character->name }}</span></h1>
        <a href="{{ route('characters.show', $character) }}" target="_blank" class="text-xs font-bold uppercase tracking-widest text-cyan-400 hover:underline">View public page ↗</a>
    </div>

    <form method="POST" action="{{ route('admin.characters.update', $character) }}" enctype="multipart/form-data">
        @method('PUT')
        @include('admin.characters._form')
    </form>
@endsection
