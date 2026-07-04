@extends('admin.layouts.admin')

@section('title', 'Add Character')

@section('content')
    <div class="mb-8">
        <h1 class="font-display text-3xl uppercase tracking-wide">Add <span class="text-gta-accent">Character</span></h1>
    </div>

    <form method="POST" action="{{ route('admin.characters.store') }}" enctype="multipart/form-data">
        @include('admin.characters._form')
    </form>
@endsection
