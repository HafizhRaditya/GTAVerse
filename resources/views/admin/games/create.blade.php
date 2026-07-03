@extends('admin.layouts.admin')

@section('title', 'Tambah Game')

@section('content')
    <div class="mb-8">
        <h1 class="font-display text-3xl uppercase tracking-wide">Tambah <span class="text-gta-accent">Game</span></h1>
    </div>

    <form method="POST" action="{{ route('admin.games.store') }}" enctype="multipart/form-data">
        @include('admin.games._form')
    </form>
@endsection
