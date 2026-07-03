@csrf

<div class="glass-panel max-w-xl space-y-5 p-6">
    <div>
        <label for="name" class="form-label">Nama Kategori *</label>
        <input id="name" type="text" name="name" value="{{ old('name', $category->name) }}" required maxlength="255" class="form-input">
    </div>

    <div>
        <label for="slug" class="form-label">Slug</label>
        <input id="slug" type="text" name="slug" value="{{ old('slug', $category->slug) }}" maxlength="255" class="form-input">
        <p class="form-hint">Kosongkan untuk dibuat otomatis dari nama.</p>
    </div>

    <div class="flex gap-3 pt-2">
        <button type="submit" class="btn-primary">{{ $category->exists ? 'Simpan Perubahan' : 'Tambah Kategori' }}</button>
        <a href="{{ route('admin.categories.index') }}" class="btn-ghost">Batal</a>
    </div>
</div>
