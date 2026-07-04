@csrf

<div class="grid gap-6 lg:grid-cols-2">
    <div class="glass-panel space-y-5 p-6">
        <h2 class="font-display text-lg uppercase tracking-wide text-cyan-300">Main Information</h2>

        <div>
            <label for="title" class="form-label">Game Title *</label>
            <input id="title" type="text" name="title" value="{{ old('title', $game->title) }}" required maxlength="255" class="form-input">
        </div>

        <div>
            <label for="slug" class="form-label">Slug</label>
            <input id="slug" type="text" name="slug" value="{{ old('slug', $game->slug) }}" maxlength="255" class="form-input">
            <p class="form-hint">Leave blank to generate automatically from the title.</p>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label for="universe" class="form-label">Universe *</label>
                <select id="universe" name="universe" required class="form-input">
                    <option value="3D" @selected(old('universe', $game->universe) === '3D')>3D Universe</option>
                    <option value="HD" @selected(old('universe', $game->universe ?? 'HD') === 'HD')>HD Universe</option>
                </select>
            </div>
            <div>
                <label for="status" class="form-label">Status *</label>
                <select id="status" name="status" required class="form-input">
                    <option value="released" @selected(old('status', $game->status ?? 'released') === 'released')>Released</option>
                    <option value="upcoming" @selected(old('status', $game->status) === 'upcoming')>Upcoming</option>
                </select>
            </div>
        </div>

        <div>
            <label for="release_date" class="form-label">Release Date</label>
            <input id="release_date" type="date" name="release_date"
                   value="{{ old('release_date', $game->release_date?->format('Y-m-d')) }}" class="form-input">
        </div>

        <div>
            <label for="platforms" class="form-label">Platforms</label>
            <input id="platforms" type="text" name="platforms" value="{{ old('platforms', $game->platforms) }}"
                   maxlength="255" placeholder="PlayStation 5, Xbox Series X|S, PC" class="form-input">
        </div>

        <div>
            <label for="setting" class="form-label">Setting (Place &amp; Time)</label>
            <input id="setting" type="text" name="setting" value="{{ old('setting', $game->setting) }}"
                   maxlength="255" placeholder="e.g. Vice City, 1986" class="form-input">
        </div>

        <div>
            <label for="tagline" class="form-label">Tagline</label>
            <input id="tagline" type="text" name="tagline" value="{{ old('tagline', $game->tagline) }}" maxlength="255" class="form-input">
        </div>

        <div>
            <label for="description" class="form-label">Description</label>
            <textarea id="description" name="description" rows="5" class="form-input">{{ old('description', $game->description) }}</textarea>
        </div>
    </div>

    <div class="space-y-6">
        <div class="glass-panel space-y-5 p-6">
            <h2 class="font-display text-lg uppercase tracking-wide text-pink-300">Appearance &amp; Media</h2>

            <div>
                <label for="cover_image" class="form-label">Cover Image</label>
                @if ($game->cover_image)
                    <img src="{{ asset('storage/' . $game->cover_image) }}" alt="Current cover" data-crop-preview class="mb-3 h-32 rounded-lg object-cover">
                    <button type="button" data-crop-edit="cover_image" data-src="{{ asset('storage/' . $game->cover_image) }}" class="btn-admin-sm btn-edit mb-3">&#9986; Edit This Image</button>
                @endif
                <input id="cover_image" type="file" name="cover_image" accept="image/*" data-aspect="0.75" class="form-input">
                <p class="form-hint">3:4 portrait ratio (poster) — adjust zoom &amp; position after choosing a file. Max 4 MB. {{ $game->cover_image ? 'Leave blank to keep the current image.' : '' }}</p>
            </div>

            <div>
                <label for="hero_image" class="form-label">Hero Image</label>
                @if ($game->hero_image)
                    <img src="{{ asset('storage/' . $game->hero_image) }}" alt="Current hero" data-crop-preview class="mb-3 h-24 w-full rounded-lg object-cover">
                    <button type="button" data-crop-edit="hero_image" data-src="{{ asset('storage/' . $game->hero_image) }}" class="btn-admin-sm btn-edit mb-3">&#9986; Edit This Image</button>
                @endif
                <input id="hero_image" type="file" name="hero_image" accept="image/*" data-aspect="1.77778" class="form-input">
                <p class="form-hint">16:9 widescreen ratio for the hero slider &amp; homepage scroll animation — adjust zoom &amp; position after choosing a file. Max 4 MB.</p>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="theme_color" class="form-label">Theme Color</label>
                    <input id="theme_color" type="color" name="theme_color" value="{{ old('theme_color', $game->theme_color ?? '#ff2ea6') }}" class="form-input">
                    <p class="form-hint">Used as a gradient background when no image has been uploaded.</p>
                </div>
                <div>
                    <label for="accent_color" class="form-label">Accent Color</label>
                    <input id="accent_color" type="color" name="accent_color" value="{{ old('accent_color', $game->accent_color ?? '#7c3aed') }}" class="form-input">
                </div>
            </div>
        </div>

        <div class="glass-panel space-y-5 p-6">
            <h2 class="font-display text-lg uppercase tracking-wide text-teal-300">Visibility</h2>

            <label class="flex items-center gap-3 text-sm text-zinc-300">
                <input type="hidden" name="is_featured" value="0">
                <input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $game->is_featured))
                       class="h-4 w-4 rounded border-white/20 bg-zinc-900 accent-cyan-500">
                <span>
                    Featured Game
                    <span class="block text-xs text-zinc-500">Shown in the hero slider &amp; the homepage scroll animation section.</span>
                </span>
            </label>

            <div>
                <label for="sort_order" class="form-label">Display Order</label>
                <input id="sort_order" type="number" name="sort_order" value="{{ old('sort_order', $game->sort_order ?? 0) }}" class="form-input w-32">
            </div>
        </div>

        <div class="flex gap-3">
            <button type="submit" class="btn-primary">{{ $game->exists ? 'Save Changes' : 'Add Game' }}</button>
            <a href="{{ route('admin.games.index') }}" class="btn-ghost">Cancel</a>
        </div>
    </div>
</div>
