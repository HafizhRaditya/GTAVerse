@extends('admin.layouts.admin')

@section('title', 'Add Category')

@section('content')
    <div class="mb-8">
        <h1 class="font-display text-3xl uppercase tracking-wide">Add <span class="text-gta-accent">Category</span></h1>
    </div>

    <form method="POST" action="{{ route('admin.categories.store') }}">
        @include('admin.categories._form')
    </form>
@endsection
