@extends('admin.layouts.admin')

@section('title', 'Edit Artikel')

@section('content')
    <div class="mb-8 flex flex-wrap items-end justify-between gap-3">
        <h1 class="font-display text-3xl uppercase tracking-wide">Edit <span class="text-gta-accent">Artikel</span></h1>
        @if ($article->status === 'published')
            <a href="{{ route('articles.show', $article) }}" target="_blank" class="text-xs font-bold uppercase tracking-widest text-cyan-400 hover:underline">Lihat halaman publik ↗</a>
        @endif
    </div>

    <form method="POST" action="{{ route('admin.articles.update', $article) }}" enctype="multipart/form-data">
        @method('PUT')
        @include('admin.articles._form')
    </form>
@endsection
