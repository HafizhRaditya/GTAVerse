@extends('admin.layouts.admin')

@section('title', 'Tulis Artikel')

@section('content')
    <div class="mb-8">
        <h1 class="font-display text-3xl uppercase tracking-wide">Tulis <span class="text-gta-accent">Artikel</span></h1>
    </div>

    <form method="POST" action="{{ route('admin.articles.store') }}" enctype="multipart/form-data">
        @include('admin.articles._form')
    </form>
@endsection
