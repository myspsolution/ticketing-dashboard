<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Welcome — {{ config('app.name', 'Aplikasi') }}</title>
  <meta name="color-scheme" content="light dark" />

  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: { brand: { DEFAULT: '#2563eb' } },
          boxShadow: { soft: '0 12px 30px -12px rgba(0,0,0,.25)' },
          backgroundImage: {
            'grid-light': 'radial-gradient(circle at 1px 1px, rgba(0,0,0,0.06) 1px, transparent 0)',
            'grid-dark': 'radial-gradient(circle at 1px 1px, rgba(255,255,255,0.08) 1px, transparent 0)',
          }
        }
      }
    }
  </script>
</head>

<body class="h-full bg-slate-50 dark:bg-slate-950 antialiased">

  {{-- Background subtle pattern --}}
  <div class="fixed inset-0 -z-10 [background-size:18px_18px] bg-grid-light dark:bg-grid-dark"></div>
  <div class="fixed inset-0 -z-10 bg-gradient-to-b from-transparent via-transparent to-slate-50/70 dark:to-slate-950/80"></div>

  <main class="min-h-full">

    {{-- Header --}}
    <header class="container mx-auto px-6 py-5">
      <div class="flex items-center justify-between">
        <div class="flex items-center gap-3">
          <img src="{{ asset('images/02-Logo-OranT.svg') }}" alt="Logo" class="h-10 w-auto">
          {{--<span class="text-lg sm:text-xl font-bold text-slate-900 dark:text-slate-100">
            {{ config('app.name', 'Aplikasi') }}
          </span>--}}
        </div>

        <div class="hidden sm:flex items-center gap-2 text-xs text-slate-500 dark:text-slate-400">
          <span>Powered by</span>
          <img src="{{ asset('images/01-Logo-OranT.png') }}" class="h-6 w-auto rounded" alt="OranT Logo">
        </div>
      </div>
    </header>

    {{-- Hero Section --}}
    <section class="container mx-auto px-6 pt-2 pb-10">
      <div class="grid lg:grid-cols-2 gap-10 items-center">

        {{-- Left Section --}}
        <div>
          <div class="inline-flex items-center gap-2 rounded-full px-3 py-1 text-xs font-medium ring-1 ring-brand/20 bg-brand/5 text-brand mb-4">
            Selamat Datang di Report Progress Digital Innovation
          </div>

          <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight text-slate-900 dark:text-white">
            Akses <span class="text-brand"> Report Progress</span> untuk laporan developer.
          </h1>
          <p class="mt-3 text-slate-600 dark:text-slate-300 max-w-prose">
            Masuk jika sudah memiliki akun, atau daftar akun baru dengan cepat.  
            Semua data tersimpan aman dan terlindungi.
          </p>

          {{-- Card Login / Register --}}
          <div class="mt-6 rounded-2xl bg-white/80 dark:bg-slate-900/60 backdrop-blur ring-1 ring-slate-200 dark:ring-white/10 shadow-soft p-5">
            <h2 class="text-base font-semibold text-slate-900 dark:text-slate-100">Pilih Tindakan</h2>
            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Login atau buat akun baru.</p>

            <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-3">
              @if (Route::has('login'))
                <a href="{{ route('login') }}"
                   class="inline-flex items-center justify-center gap-2 rounded-xl bg-brand px-4 py-2.5 text-white font-medium hover:brightness-110 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand">
                  <svg class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor"><path d="M10 17l5-5-5-5v10z"/><path d="M4 4h8v2H6v12h6v2H4z"/></svg>
                  Login
                </a>
              @endif

              @if (Route::has('register'))
                <a href="{{ route('register') }}"
                   class="inline-flex items-center justify-center gap-2 rounded-xl border border-slate-300 dark:border-slate-700 px-4 py-2.5 text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-900/40 font-medium">
                  <svg class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor"><path d="M12 12a5 5 0 100-10 5 5 0 000 10zM21 20a8.1 8.1 0 00-9-8 8.1 8.1 0 00-9 8v1h18v-1z"/></svg>
                  Register
                </a>
              @endif
            </div>
          </div>

          {{-- Info --}}
          <div class="mt-6 flex items-center gap-3 text-xs text-slate-500 dark:text-slate-400">
            <svg class="h-4 w-4 text-emerald-500" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l7 4v6c0 5-3.8 9.6-7 10-3.2-.4-7-5-7-10V6l7-4zm-1 13l6-6-1.4-1.4L11 12.2l-2.6-2.6L7 11l4 4z"/></svg>
            Data terenkripsi & diaudit keamanan kelas enterprise.
          </div>
        </div>

        {{-- Right Section (Image) --}}
        <div class="relative">
          <div class="absolute -inset-6 -z-10 blur-2xl opacity-40 bg-gradient-to-tr from-brand/30 to-fuchsia-500/30 rounded-3xl"></div>

          {{-- Hero Image --}}
          <div class="overflow-hidden rounded-3xl ring-1 ring-slate-200 dark:ring-white/10 shadow-soft">
            <img src="{{ asset('images/cover.png') }}" alt="Gambar utama aplikasi"
                 class="w-full h-72 sm:h-96 object-cover">
          </div>

          {{-- Thumbnails --}}
          <div class="mt-4 grid grid-cols-3 gap-3">
            <img src="{{ asset('images/1.jpeg') }}" alt="Thumbnail 1"
                 class="h-24 w-full object-cover rounded-2xl ring-1 ring-slate-200 dark:ring-white/10">
            <img src="{{ asset('images/2.jpeg') }}" alt="Thumbnail 2"
                 class="h-24 w-full object-cover rounded-2xl ring-1 ring-slate-200 dark:ring-white/10">
            <img src="{{ asset('images/3.jpeg') }}" alt="Thumbnail 3"
                 class="h-24 w-full object-cover rounded-2xl ring-1 ring-slate-200 dark:ring-white/10">
          </div>
        </div>
      </div>
    </section>

    {{-- Footer --}}
    <footer class="pb-10 text-center text-xs text-slate-500 dark:text-slate-400">
      © {{ now()->year }} {{ config('app.name', 'Aplikasi') }} · Dibuat dengan ♥ · Powered by OranT
    </footer>
  </main>

</body>
</html>
