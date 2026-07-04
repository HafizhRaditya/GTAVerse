@csrf

<div class="grid gap-6 lg:grid-cols-3">
    <div class="space-y-6 lg:col-span-2">
        <div class="glass-panel space-y-5 p-6">
            <h2 class="font-display text-lg uppercase tracking-wide text-cyan-300">Article Content</h2>

            <div>
                <label for="title" class="form-label">Article Title *</label>
                <input id="title" type="text" name="title" value="{{ old('title', $article->title) }}" required maxlength="255" class="form-input">
            </div>

            <div>
                <label for="slug" class="form-label">Slug</label>
                <input id="slug" type="text" name="slug" value="{{ old('slug', $article->slug) }}" maxlength="255" class="form-input">
                <p class="form-hint">Leave blank to generate automatically from the title.</p>
            </div>

            <div>
                <label for="excerpt" class="form-label">Excerpt</label>
                <textarea id="excerpt" name="excerpt" rows="3" maxlength="500" class="form-input">{{ old('excerpt', $article->excerpt) }}</textarea>
                <p class="form-hint">Maximum 500 characters — shown on article cards on the homepage.</p>
            </div>

            <div>
                <label for="body" class="form-label">Article Body *</label>
                <textarea id="body" name="body" rows="16" required class="form-input font-mono !text-[13px]">{{ old('body', $article->body) }}</textarea>
                <p class="form-hint">Supports basic HTML tags: &lt;p&gt;, &lt;h2&gt;, &lt;h3&gt;, &lt;strong&gt;, &lt;em&gt;, &lt;ul&gt;, &lt;ol&gt;, &lt;li&gt;, &lt;a&gt;, &lt;img&gt;, &lt;blockquote&gt;.</p>
            </div>
        </div>
    </div>

    <div class="space-y-6">
        <div class="glass-panel space-y-5 p-6">
            <h2 class="font-display text-lg uppercase tracking-wide text-pink-300">Settings</h2>

            <div>
                <label for="category_id" class="form-label">Category</label>
                <select id="category_id" name="category_id" class="form-input">
                    <option value="">— No category —</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @selected((int) old('category_id', $article->category_id) === $category->id)>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="game_id" class="form-label">Related Game</label>
                <select id="game_id" name="game_id" class="form-input">
                    <option value="">— Not related to a game —</option>
                    @foreach ($games as $game)
                        <option value="{{ $game->id }}" @selected((int) old('game_id', $article->game_id) === $game->id)>
                            {{ $game->title }}
                        </option>
                    @endforeach
                </select>
                <p class="form-hint">Optional — the article will appear on that game's detail page.</p>
            </div>

            <div>
                <label for="status" class="form-label">Status *</label>
                <select id="status" name="status" required class="form-input">
                    <option value="draft" @selected(old('status', $article->status ?? 'draft') === 'draft')>Draft</option>
                    <option value="published" @selected(old('status', $article->status) === 'published')>Published</option>
                </select>
            </div>

            <div>
                <label for="published_at" class="form-label">Publish Date</label>
                <input id="published_at" type="datetime-local" name="published_at"
                       value="{{ old('published_at', $article->published_at?->format('Y-m-d\TH:i')) }}" class="form-input">
                <p class="form-hint">Leave blank — it is filled automatically when the status changes to Published.</p>
            </div>

            <label class="flex items-center gap-3 text-sm text-zinc-300">
                <input type="hidden" name="is_headline" value="0">
                <input type="checkbox" name="is_headline" value="1" @checked(old('is_headline', $article->is_headline))
                       class="h-4 w-4 rounded border-white/20 bg-zinc-900 accent-cyan-500">
                <span>
                    Make Headline
                    <span class="block text-xs text-zinc-500">Shown as the main story on the homepage.</span>
                </span>
            </label>
        </div>

        <div class="glass-panel space-y-5 p-6">
            <h2 class="font-display text-lg uppercase tracking-wide text-teal-300">Featured Image</h2>

            @if ($article->featured_image)
                <img src="{{ asset('storage/' . $article->featured_image) }}" alt="Current image" data-crop-preview class="mb-3 h-32 w-full rounded-lg object-cover">
                <button type="button" data-crop-edit="featured_image" data-src="{{ asset('storage/' . $article->featured_image) }}" class="btn-admin-sm btn-edit mb-3">&#9986; Edit This Image</button>
            @endif
            <input id="featured_image" type="file" name="featured_image" accept="image/*" data-aspect="1.77778" class="form-input">
            <p class="form-hint">16:9 ratio — adjust zoom &amp; position after choosing a file. Max 4 MB. {{ $article->featured_image ? 'Leave blank to keep the current image.' : '' }}</p>
        </div>

        <div class="flex gap-3">
            <button type="submit" class="btn-primary">{{ $article->exists ? 'Save Changes' : 'Publish Article' }}</button>
            <a href="{{ route('admin.articles.index') }}" class="btn-ghost">Cancel</a>
        </div>
    </div>
</div>
