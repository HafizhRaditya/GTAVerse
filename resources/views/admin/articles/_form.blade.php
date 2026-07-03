@csrf

<div class="grid gap-6 lg:grid-cols-3">
    <div class="space-y-6 lg:col-span-2">
        <div class="glass-panel space-y-5 p-6">
            <h2 class="font-display text-lg uppercase tracking-wide text-cyan-300">Konten Artikel</h2>

            <div>
                <label for="title" class="form-label">Judul Artikel *</label>
                <input id="title" type="text" name="title" value="{{ old('title', $article->title) }}" required maxlength="255" class="form-input">
            </div>

            <div>
                <label for="slug" class="form-label">Slug</label>
                <input id="slug" type="text" name="slug" value="{{ old('slug', $article->slug) }}" maxlength="255" class="form-input">
                <p class="form-hint">Kosongkan untuk dibuat otomatis dari judul.</p>
            </div>

            <div>
                <label for="excerpt" class="form-label">Ringkasan</label>
                <textarea id="excerpt" name="excerpt" rows="3" maxlength="500" class="form-input">{{ old('excerpt', $article->excerpt) }}</textarea>
                <p class="form-hint">Maksimal 500 karakter — tampil di kartu artikel pada beranda.</p>
            </div>

            <div>
                <label for="body" class="form-label">Isi Artikel *</label>
                <textarea id="body" name="body" rows="16" required class="form-input font-mono !text-[13px]">{{ old('body', $article->body) }}</textarea>
                <p class="form-hint">Mendukung tag HTML dasar: &lt;p&gt;, &lt;h2&gt;, &lt;h3&gt;, &lt;strong&gt;, &lt;em&gt;, &lt;ul&gt;, &lt;ol&gt;, &lt;li&gt;, &lt;a&gt;, &lt;img&gt;, &lt;blockquote&gt;.</p>
            </div>
        </div>
    </div>

    <div class="space-y-6">
        <div class="glass-panel space-y-5 p-6">
            <h2 class="font-display text-lg uppercase tracking-wide text-pink-300">Pengaturan</h2>

            <div>
                <label for="category_id" class="form-label">Kategori</label>
                <select id="category_id" name="category_id" class="form-input">
                    <option value="">— Tanpa kategori —</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @selected((int) old('category_id', $article->category_id) === $category->id)>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="game_id" class="form-label">Game Terkait</label>
                <select id="game_id" name="game_id" class="form-input">
                    <option value="">— Tidak terkait game —</option>
                    @foreach ($games as $game)
                        <option value="{{ $game->id }}" @selected((int) old('game_id', $article->game_id) === $game->id)>
                            {{ $game->title }}
                        </option>
                    @endforeach
                </select>
                <p class="form-hint">Opsional — artikel akan muncul di halaman detail game tersebut.</p>
            </div>

            <div>
                <label for="status" class="form-label">Status *</label>
                <select id="status" name="status" required class="form-input">
                    <option value="draft" @selected(old('status', $article->status ?? 'draft') === 'draft')>Draf</option>
                    <option value="published" @selected(old('status', $article->status) === 'published')>Terbit</option>
                </select>
            </div>

            <div>
                <label for="published_at" class="form-label">Tanggal Terbit</label>
                <input id="published_at" type="datetime-local" name="published_at"
                       value="{{ old('published_at', $article->published_at?->format('Y-m-d\TH:i')) }}" class="form-input">
                <p class="form-hint">Kosongkan — akan terisi otomatis saat status diubah menjadi Terbit.</p>
            </div>

            <label class="flex items-center gap-3 text-sm text-zinc-300">
                <input type="hidden" name="is_headline" value="0">
                <input type="checkbox" name="is_headline" value="1" @checked(old('is_headline', $article->is_headline))
                       class="h-4 w-4 rounded border-white/20 bg-zinc-900 accent-cyan-500">
                <span>
                    Jadikan Headline
                    <span class="block text-xs text-zinc-500">Tampil sebagai berita utama di beranda.</span>
                </span>
            </label>
        </div>

        <div class="glass-panel space-y-5 p-6">
            <h2 class="font-display text-lg uppercase tracking-wide text-teal-300">Gambar Utama</h2>

            @if ($article->featured_image)
                <img src="{{ asset('storage/' . $article->featured_image) }}" alt="Gambar saat ini" data-crop-preview class="mb-3 h-32 w-full rounded-lg object-cover">
                <button type="button" data-crop-edit="featured_image" data-src="{{ asset('storage/' . $article->featured_image) }}" class="btn-admin-sm btn-edit mb-3">&#9986; Edit Gambar Ini</button>
            @endif
            <input id="featured_image" type="file" name="featured_image" accept="image/*" data-aspect="1.77778" class="form-input">
            <p class="form-hint">Rasio 16:9 — atur zoom &amp; posisi setelah memilih file. Maks 4 MB. {{ $article->featured_image ? 'Biarkan kosong jika tidak ingin mengganti.' : '' }}</p>
        </div>

        <div class="flex gap-3">
            <button type="submit" class="btn-primary">{{ $article->exists ? 'Simpan Perubahan' : 'Terbitkan Artikel' }}</button>
            <a href="{{ route('admin.articles.index') }}" class="btn-ghost">Batal</a>
        </div>
    </div>
</div>
