@extends('admin.layouts.admin')

@section('title', 'Edit Category')

@section('content')
    <div class="mb-8">
        <h1 class="font-display text-3xl uppercase tracking-wide">Edit <span class="text-gta-accent">{{ $category->name }}</span></h1>
    </div>

    <form method="POST" action="{{ route('admin.categories.update', $category) }}">
        @method('PUT')
        @include('admin.categories._form')
    </form>
@endsection
