@csrf

<div class="grid gap-6 lg:grid-cols-2">
    <div class="glass-panel space-y-5 p-6">
        <h2 class="font-display text-lg uppercase tracking-wide text-cyan-300">Character Profile</h2>

        <div>
            <label for="game_id" class="form-label">Game *</label>
            <select id="game_id" name="game_id" required class="form-input">
                <option value="">— Select a game —</option>
                @foreach ($games as $game)
                    <option value="{{ $game->id }}" @selected((int) old('game_id', $character->game_id) === $game->id)>
                        {{ $game->title }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="name" class="form-label">Character Name *</label>
            <input id="name" type="text" name="name" value="{{ old('name', $character->name) }}" required maxlength="255" class="form-input">
        </div>

        <div>
            <label for="slug" class="form-label">Slug</label>
            <input id="slug" type="text" name="slug" value="{{ old('slug', $character->slug) }}" maxlength="255" class="form-input">
            <p class="form-hint">Leave blank to generate automatically from the name.</p>
        </div>

        <div>
            <label for="alias" class="form-label">Alias / Nickname</label>
            <input id="alias" type="text" name="alias" value="{{ old('alias', $character->alias) }}" maxlength="255" class="form-input">
        </div>

        <div>
            <label for="role" class="form-label">Role</label>
            <input id="role" type="text" name="role" value="{{ old('role', $character->role ?? 'Main Protagonist') }}" maxlength="255" class="form-input">
        </div>

        <div>
            <label for="voice_actor" class="form-label">Voice Actor</label>
            <input id="voice_actor" type="text" name="voice_actor" value="{{ old('voice_actor', $character->voice_actor) }}" maxlength="255" class="form-input">
        </div>

        <div>
            <label for="bio" class="form-label">Biography</label>
            <textarea id="bio" name="bio" rows="6" class="form-input">{{ old('bio', $character->bio) }}</textarea>
        </div>
    </div>

    <div class="space-y-6">
        <div class="glass-panel space-y-5 p-6">
            <h2 class="font-display text-lg uppercase tracking-wide text-pink-300">Photo &amp; Visibility</h2>

            <div>
                <label for="photo" class="form-label">Photo</label>
                @if ($character->photo)
                    <img src="{{ asset('storage/' . $character->photo) }}" alt="Current photo" data-crop-preview class="mb-3 h-32 w-32 rounded-full object-cover">
                    <button type="button" data-crop-edit="photo" data-src="{{ asset('storage/' . $character->photo) }}" class="btn-admin-sm btn-edit mb-3">&#9986; Edit This Image</button>
                @endif
                <input id="photo" type="file" name="photo" accept="image/*" data-aspect="0.75" class="form-input">
                <p class="form-hint">3:4 portrait ratio — adjust zoom &amp; position after choosing a file. Max 4 MB. If left empty, a monogram avatar with the character's initials is used.</p>
            </div>

            <label class="flex items-center gap-3 text-sm text-zinc-300">
                <input type="hidden" name="is_protagonist" value="0">
                <input type="checkbox" name="is_protagonist" value="1"
                       @checked(old('is_protagonist', $character->exists ? $character->is_protagonist : true))
                       class="h-4 w-4 rounded border-white/20 bg-zinc-900 accent-cyan-500">
                Protagonist
            </label>

            <div>
                <label for="sort_order" class="form-label">Display Order</label>
                <input id="sort_order" type="number" name="sort_order" value="{{ old('sort_order', $character->sort_order ?? 0) }}" class="form-input w-32">
            </div>
        </div>

        <div class="flex gap-3">
            <button type="submit" class="btn-primary">{{ $character->exists ? 'Save Changes' : 'Add Character' }}</button>
            <a href="{{ route('admin.characters.index') }}" class="btn-ghost">Cancel</a>
        </div>
    </div>
</div>
