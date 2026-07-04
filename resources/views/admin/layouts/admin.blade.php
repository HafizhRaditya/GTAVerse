<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin Panel') — GTAVerse Admin</title>
    <meta name="robots" content="noindex, nofollow">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=anton:400|inter:400,500,600,700,800" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.css">

    <style>
        /* Cropper.js dark-theme adjustments */
        .cropper-view-box, .cropper-face { outline-color: rgba(34, 211, 238, 0.75); }
        .cropper-line, .cropper-point { background-color: #22d3ee; }
        .cropper-modal { background: rgba(9, 9, 11, 0.7); }
    </style>

    <style>
        /* GTAVerse-themed form controls (standalone so they don't rely on Tailwind's scan output) */
        .form-label {
            display: block;
            margin-bottom: 0.4rem;
            font-size: 0.7rem;
            font-weight: 700;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            color: rgba(103, 232, 249, 0.75);
        }
        .form-input {
            width: 100%;
            border-radius: 0.65rem;
            border: 1px solid rgba(255, 255, 255, 0.1);
            background: rgba(24, 24, 27, 0.75);
            padding: 0.6rem 0.9rem;
            font-size: 0.875rem;
            color: #f4f4f5;
            transition: border-color .2s, box-shadow .2s;
        }
        .form-input:focus {
            outline: none;
            border-color: rgba(34, 211, 238, 0.55);
            box-shadow: 0 0 0 1px rgba(34, 211, 238, 0.35), 0 0 18px rgba(34, 211, 238, 0.12);
        }
        .form-input::placeholder { color: #52525b; }
        select.form-input option { background: #18181b; }
        .form-hint {
            margin-top: 0.35rem;
            font-size: 0.72rem;
            color: #71717a;
        }
        .form-error {
            margin-top: 0.35rem;
            font-size: 0.75rem;
            color: #f9a8d4;
        }
        input[type="color"].form-input {
            padding: 0.2rem;
            height: 2.6rem;
            cursor: pointer;
        }
        .admin-table th {
            padding: 0.75rem 1rem;
            text-align: left;
            font-size: 0.68rem;
            font-weight: 700;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            color: rgba(103, 232, 249, 0.7);
            border-bottom: 1px solid rgba(34, 211, 238, 0.15);
            white-space: nowrap;
        }
        .admin-table td {
            padding: 0.75rem 1rem;
            font-size: 0.85rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            vertical-align: middle;
        }
        .admin-table tr:hover td { background: rgba(34, 211, 238, 0.03); }
        .badge-admin {
            display: inline-flex;
            align-items: center;
            border-radius: 9999px;
            padding: 0.15rem 0.7rem;
            font-size: 0.68rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            white-space: nowrap;
        }
        .badge-cyan   { background: rgba(34, 211, 238, 0.12);  color: #67e8f9; border: 1px solid rgba(34, 211, 238, 0.3); }
        .badge-pink   { background: rgba(236, 72, 153, 0.12);  color: #f9a8d4; border: 1px solid rgba(236, 72, 153, 0.3); }
        .badge-green  { background: rgba(45, 212, 191, 0.12);  color: #5eead4; border: 1px solid rgba(45, 212, 191, 0.3); }
        .badge-gray   { background: rgba(161, 161, 170, 0.1);  color: #a1a1aa; border: 1px solid rgba(161, 161, 170, 0.25); }
        .btn-admin-sm {
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            border-radius: 9999px;
            padding: 0.35rem 0.9rem;
            font-size: 0.7rem;
            font-weight: 700;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            transition: all .2s;
            white-space: nowrap;
        }
        .btn-edit {
            border: 1px solid rgba(34, 211, 238, 0.4);
            color: #67e8f9;
        }
        .btn-edit:hover { background: rgba(34, 211, 238, 0.12); box-shadow: 0 0 12px rgba(34, 211, 238, 0.2); }
        .btn-delete {
            border: 1px solid rgba(236, 72, 153, 0.4);
            color: #f9a8d4;
        }
        .btn-delete:hover { background: rgba(236, 72, 153, 0.12); box-shadow: 0 0 12px rgba(236, 72, 153, 0.2); }
        .crop-ratio.ratio-active {
            background: linear-gradient(135deg, #0891b2, #ec4899);
            border-color: transparent;
            color: #fff;
            box-shadow: 0 0 12px rgba(34, 211, 238, 0.3);
        }
    </style>
</head>
<body class="bg-zinc-950 font-sans text-zinc-100 antialiased selection:bg-cyan-500/40">

    @php $unreadCount = \App\Models\Message::unread()->count(); @endphp

    {{-- ============================ ADMIN NAVBAR ============================ --}}
    <header class="fixed inset-x-0 top-0 z-50 nav-scrolled">
        <nav class="mx-auto flex max-w-7xl items-center justify-between px-4 py-3.5 sm:px-6">
            <a href="{{ route('admin.dashboard') }}" class="font-display text-xl uppercase tracking-wide">
                GTA<span class="text-gta-accent">Verse</span>
                <span class="ml-2 rounded-full border border-pink-500/40 bg-pink-500/10 px-2.5 py-0.5 text-[10px] font-bold tracking-[0.2em] text-pink-400 align-middle font-sans">Admin</span>
            </a>

            <div class="hidden items-center gap-6 text-[11px] font-bold uppercase tracking-[0.18em] md:flex">
                <a href="{{ route('admin.dashboard') }}" class="transition hover:text-cyan-400 {{ request()->routeIs('admin.dashboard') ? 'text-cyan-400 neon-text' : 'text-zinc-300' }}">Dashboard</a>
                <a href="{{ route('admin.games.index') }}" class="transition hover:text-cyan-400 {{ request()->routeIs('admin.games.*') ? 'text-cyan-400 neon-text' : 'text-zinc-300' }}">Games</a>
                <a href="{{ route('admin.articles.index') }}" class="transition hover:text-cyan-400 {{ request()->routeIs('admin.articles.*') ? 'text-cyan-400 neon-text' : 'text-zinc-300' }}">Articles</a>
                <a href="{{ route('admin.characters.index') }}" class="transition hover:text-cyan-400 {{ request()->routeIs('admin.characters.*') ? 'text-cyan-400 neon-text' : 'text-zinc-300' }}">Characters</a>
                <a href="{{ route('admin.categories.index') }}" class="transition hover:text-cyan-400 {{ request()->routeIs('admin.categories.*') ? 'text-cyan-400 neon-text' : 'text-zinc-300' }}">Categories</a>
                <a href="{{ route('admin.messages.index') }}" class="relative transition hover:text-cyan-400 {{ request()->routeIs('admin.messages.*') ? 'text-cyan-400 neon-text' : 'text-zinc-300' }}">
                    Inbox
                    @if ($unreadCount > 0)
                        <span class="absolute -right-3.5 -top-2 flex h-4 min-w-4 items-center justify-center rounded-full bg-pink-500 px-1 text-[9px] font-bold text-white">{{ $unreadCount }}</span>
                    @endif
                </a>

                <span class="h-4 w-px bg-white/15"></span>

                <a href="{{ route('home') }}" target="_blank" class="text-zinc-400 transition hover:text-cyan-400">View Site ↗</a>

                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" class="rounded-full border border-pink-500/50 px-4 py-1.5 text-pink-400 transition hover:bg-pink-500/15 hover:shadow-[0_0_15px_rgba(236,72,153,0.25)]">
                        Log Out
                    </button>
                </form>
            </div>

            <button id="admin-menu-btn" class="text-zinc-200 md:hidden" aria-label="Open menu">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
        </nav>

        {{-- Mobile menu --}}
        <div id="admin-mobile-menu" class="hidden border-t border-cyan-500/15 bg-zinc-950/95 backdrop-blur-xl md:hidden">
            <div class="flex flex-col gap-1 px-6 py-4 text-sm font-bold uppercase tracking-widest">
                <a href="{{ route('admin.dashboard') }}" class="py-2 text-zinc-200 hover:text-cyan-400">Dashboard</a>
                <a href="{{ route('admin.games.index') }}" class="py-2 text-zinc-200 hover:text-cyan-400">Games</a>
                <a href="{{ route('admin.articles.index') }}" class="py-2 text-zinc-200 hover:text-cyan-400">Articles</a>
                <a href="{{ route('admin.characters.index') }}" class="py-2 text-zinc-200 hover:text-cyan-400">Characters</a>
                <a href="{{ route('admin.categories.index') }}" class="py-2 text-zinc-200 hover:text-cyan-400">Categories</a>
                <a href="{{ route('admin.messages.index') }}" class="py-2 text-zinc-200 hover:text-cyan-400">
                    Inbox @if ($unreadCount > 0)<span class="ml-1 rounded-full bg-pink-500 px-1.5 py-0.5 text-[9px] font-bold text-white">{{ $unreadCount }}</span>@endif
                </a>
                <a href="{{ route('home') }}" target="_blank" class="py-2 text-zinc-400 hover:text-cyan-400">View Site ↗</a>
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" class="py-2 uppercase text-pink-400">Log Out</button>
                </form>
            </div>
        </div>
    </header>

    <main class="mx-auto min-h-screen max-w-7xl px-4 pb-20 pt-24 sm:px-6">

        {{-- Success message --}}
        @if (session('success'))
            <div class="mb-6 flex items-center gap-3 rounded-xl border border-teal-400/30 bg-teal-400/10 px-5 py-3.5 text-sm text-teal-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0 text-teal-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                </svg>
                {{ session('success') }}
            </div>
        @endif

        {{-- Validation errors --}}
        @if ($errors->any())
            <div class="mb-6 rounded-xl border border-pink-500/30 bg-pink-500/10 px-5 py-3.5 text-sm text-pink-200">
                <p class="mb-1 font-bold uppercase tracking-widest text-pink-300">Please review your input:</p>
                <ul class="list-inside list-disc space-y-0.5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="border-t border-cyan-500/10 py-5 text-center text-xs text-zinc-600">
        GTA<span class="text-cyan-600">Verse</span> Admin Panel &copy; {{ date('Y') }}
    </footer>

    {{-- ============== IMAGE CROP MODAL (zoom & pan) ============== --}}
    <div id="crop-modal" class="fixed inset-0 z-[100] hidden items-center justify-center bg-zinc-950/85 p-4 backdrop-blur-sm">
        <div class="glass-panel w-full max-w-2xl p-5">
            <div class="mb-4 flex flex-wrap items-center justify-between gap-2">
                <h3 class="font-display text-lg uppercase tracking-wide text-cyan-300">Adjust Image</h3>
                <p class="text-xs text-zinc-500">Drag to move &middot; scroll / buttons to zoom</p>
            </div>
            <div class="max-h-[55vh] overflow-hidden rounded-lg bg-zinc-900/80">
                <img id="crop-image" src="" alt="Image being adjusted" class="block max-h-[55vh] max-w-full">
            </div>

            {{-- Crop ratio options --}}
            <div class="mt-4 flex flex-wrap items-center gap-2">
                <span class="text-[10px] font-bold uppercase tracking-widest text-zinc-500">Ratio:</span>
                <button type="button" class="crop-ratio btn-admin-sm btn-edit" data-ratio="rec">Recommended</button>
                <button type="button" class="crop-ratio btn-admin-sm btn-edit" data-ratio="free">Free</button>
                <button type="button" class="crop-ratio btn-admin-sm btn-edit" data-ratio="1">1:1</button>
                <button type="button" class="crop-ratio btn-admin-sm btn-edit" data-ratio="1.77778">16:9</button>
                <button type="button" class="crop-ratio btn-admin-sm btn-edit" data-ratio="0.75">3:4</button>
            </div>

            <div class="mt-4 flex flex-wrap items-center justify-between gap-3">
                <div class="flex gap-2">
                    <button type="button" id="crop-zoom-out" class="btn-admin-sm btn-edit" title="Zoom out">&minus; Zoom</button>
                    <button type="button" id="crop-zoom-in" class="btn-admin-sm btn-edit" title="Zoom in">&plus; Zoom</button>
                    <button type="button" id="crop-reset" class="btn-admin-sm btn-edit">Reset</button>
                </div>
                <div class="flex gap-2">
                    <button type="button" id="crop-cancel" class="btn-admin-sm btn-delete">Cancel</button>
                    <button type="button" id="crop-apply" class="btn-primary !px-7 !py-2.5">Apply</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.2/cropper.min.js"></script>
    <script>
        document.getElementById('admin-menu-btn')?.addEventListener('click', () => {
            document.getElementById('admin-mobile-menu').classList.toggle('hidden');
        });

        /* ==========================================================
           IMAGE CROPPING
           - File inputs with data-aspect open the Cropper.js modal.
           - [data-crop-edit] buttons open an ALREADY-uploaded image
             so it can be re-adjusted (zoom, pan, ratio).
           - The ratio can be changed: Recommended / Free / 1:1 / 16:9 / 3:4.
           - The cropped result is placed into the file input and
             saved when the form is submitted.
        ========================================================== */
        (() => {
            const modal = document.getElementById('crop-modal');
            if (!modal || typeof Cropper === 'undefined') return;

            const image = document.getElementById('crop-image');
            const ratioButtons = Array.from(document.querySelectorAll('.crop-ratio'));
            let cropper = null;
            let activeInput = null;
            let activeFile = null;
            let objectUrl = null;

            const setActiveRatioButton = (button) => {
                ratioButtons.forEach((b) => b.classList.toggle('ratio-active', b === button));
            };

            const resolveRatio = (value) => {
                if (value === 'free') return NaN;
                if (value === 'rec') return parseFloat(activeInput?.dataset.aspect) || NaN;
                return parseFloat(value);
            };

            const closeModal = () => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                if (cropper) { cropper.destroy(); cropper = null; }
                if (objectUrl) { URL.revokeObjectURL(objectUrl); objectUrl = null; }
                activeFile = null;
            };

            const openCropper = (input, file) => {
                activeInput = input;
                activeFile = file;
                objectUrl = URL.createObjectURL(file);
                image.src = objectUrl;
                modal.classList.remove('hidden');
                modal.classList.add('flex');

                setActiveRatioButton(ratioButtons.find((b) => b.dataset.ratio === 'rec'));

                cropper = new Cropper(image, {
                    aspectRatio: resolveRatio('rec'),
                    viewMode: 1,
                    dragMode: 'move',
                    autoCropArea: 1,
                    background: false,
                    responsive: true,
                });
            };

            // 1) A new image picked from the computer
            document.querySelectorAll('input[type="file"][data-aspect]').forEach((input) => {
                input.addEventListener('change', () => {
                    const file = input.files && input.files[0];
                    if (!file || !file.type.startsWith('image/')) return;
                    openCropper(input, file);
                });
            });

            // 2) Edit an image already stored on the server
            document.querySelectorAll('[data-crop-edit]').forEach((button) => {
                button.addEventListener('click', async () => {
                    const input = document.getElementById(button.dataset.cropEdit);
                    if (!input) return;
                    button.disabled = true;
                    try {
                        const response = await fetch(button.dataset.src);
                        if (!response.ok) throw new Error('Failed to load image');
                        const blob = await response.blob();
                        const name = decodeURIComponent(button.dataset.src.split('/').pop() || 'image.jpg');
                        openCropper(input, new File([blob], name, { type: blob.type || 'image/jpeg' }));
                    } catch (e) {
                        alert('The image could not be loaded for editing. Try uploading a new file instead.');
                    } finally {
                        button.disabled = false;
                    }
                });
            });

            // Change the crop ratio
            ratioButtons.forEach((button) => {
                button.addEventListener('click', () => {
                    if (!cropper) return;
                    cropper.setAspectRatio(resolveRatio(button.dataset.ratio));
                    setActiveRatioButton(button);
                });
            });

            document.getElementById('crop-zoom-in').addEventListener('click', () => cropper && cropper.zoom(0.1));
            document.getElementById('crop-zoom-out').addEventListener('click', () => cropper && cropper.zoom(-0.1));
            document.getElementById('crop-reset').addEventListener('click', () => cropper && cropper.reset());

            document.getElementById('crop-cancel').addEventListener('click', () => {
                if (activeInput) activeInput.value = '';
                closeModal();
            });

            document.getElementById('crop-apply').addEventListener('click', () => {
                if (!cropper || !activeInput || !activeFile) return;

                const isPng = activeFile.type === 'image/png';
                const mime = isPng ? 'image/png' : 'image/jpeg';
                const input = activeInput;

                cropper.getCroppedCanvas({ maxWidth: 2560, maxHeight: 2560 }).toBlob((blob) => {
                    const name = activeFile.name.replace(/\.[^.]+$/, '') + (isPng ? '.png' : '.jpg');
                    const cropped = new File([blob], name, { type: mime });

                    const transfer = new DataTransfer();
                    transfer.items.add(cropped);
                    input.files = transfer.files;

                    // Update / create the preview near the input
                    let preview = input.parentElement.querySelector('[data-crop-preview]');
                    if (!preview) {
                        preview = document.createElement('img');
                        preview.setAttribute('data-crop-preview', '');
                        preview.className = 'mb-3 h-32 rounded-lg object-cover';
                        input.parentElement.insertBefore(preview, input);
                    }
                    preview.src = URL.createObjectURL(cropped);
                    preview.classList.add('ring-2', 'ring-cyan-400/60');

                    closeModal();
                }, mime, 0.9);
            });
        })();
    </script>
    @stack('scripts')
</body>
</html>
