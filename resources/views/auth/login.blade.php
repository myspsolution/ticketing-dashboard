<x-guest-layout>
  {{-- Container --}}
  <div class="mx-auto max-w-md w-full p-6">
    {{-- Header small brand --}}
    <div class="mb-6 flex items-center justify-center gap-3">
      {{--<img src="{{ asset('images/02-Logo-OranT.svg') }}" alt="Logo {{ config('app.name') }}" class="h-9 w-auto">--}}
      <h1 class="text-xl font-bold text-slate-900 dark:text-slate-100">Login</h1>
    </div>

    {{-- Card --}}
    <div class="rounded-2xl bg-white/90 dark:bg-slate-900/70 backdrop-blur ring-1 ring-slate-200 dark:ring-white/10 shadow">
      <div class="p-6">
        <h2 class="text-lg font-semibold text-slate-900 dark:text-slate-100">Masuk ke akun Anda</h2>
        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Gunakan email dan kata sandi yang terdaftar.</p>

        {{-- Session status (e.g., "Password reset link sent") --}}
        <x-auth-session-status class="mt-4" :status="session('status')" />

        {{-- Error summary (aksesibilitas) --}}
        @if ($errors->any())
          <div class="mt-4 rounded-lg border border-red-200 dark:border-red-800 bg-red-50 dark:bg-red-950/40 p-3 text-sm text-red-700 dark:text-red-300">
            <div class="font-medium mb-1">Tidak dapat masuk:</div>
            <ul class="list-disc ms-5">
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <form method="POST" action="{{ route('login') }}" x-data="{ show: false, loading: false }" x-on:submit="loading = true">
          @csrf

          {{-- Email --}}
          <div class="mt-5">
            <x-input-label for="email" :value="__('Email')" />
            <div class="relative mt-1">
              <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center ps-3">
                {{-- mail icon --}}
                <svg class="h-5 w-5 text-slate-400" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                  <path d="M20 4H4a2 2 0 00-2 2v.4l10 6 10-6V6a2 2 0 00-2-2z"/>
                  <path d="M22 8.15l-10 6-10-6V18a2 2 0 002 2h16a2 2 0 002-2V8.15z"/>
                </svg>
              </span>
              <x-text-input
                id="email"
                class="block w-full ps-10"
                type="email"
                name="email"
                :value="old('email')"
                required
                autofocus
                inputmode="email"
                autocomplete="username"
                placeholder="name@company.com"
              />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
          </div>

          {{-- Password --}}
          <div class="mt-4">
            <div class="flex items-center justify-between">
              <x-input-label for="password" :value="__('Password')" />
              @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}"
                   class="text-xs text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-slate-200 underline">
                  {{ __('Forgot your password?') }}
                </a>
              @endif
            </div>

            <div class="relative mt-1">
              <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center ps-3">
                {{-- lock icon --}}
                <svg class="h-5 w-5 text-slate-400" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                  <path d="M17 8V7a5 5 0 10-10 0v1H5v14h14V8h-2zm-8 0V7a3 3 0 116 0v1H9z"/>
                </svg>
              </span>
              <x-text-input
                id="password"
                class="block w-full ps-10 pe-10"
                x-bind:type="show ? 'text' : 'password'"
                name="password"
                required
                autocomplete="current-password"
                placeholder="••••••••"
              />
              <button type="button"
                      x-on:click="show = !show"
                      aria-label="Toggle password visibility"
                      class="absolute inset-y-0 right-0 pe-3 flex items-center text-slate-400 hover:text-slate-600 dark:hover:text-slate-300">
                <svg x-show="!show" class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor"><path d="M12 5c-7 0-10 7-10 7s3 7 10 7 10-7 10-7-3-7-10-7zm0 12a5 5 0 110-10 5 5 0 010 10z"/></svg>
                <svg x-show="show" x-cloak class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor"><path d="M3 4.27L4.28 3 21 19.72 19.73 21l-2.23-2.23C15.94 19.53 14.03 20 12 20 5 20 2 13 2 13a20.8 20.8 0 015.58-6.86L3 4.27zM12 7a6 6 0 016 6c0 .84-.15 1.64-.43 2.38l-2.15-2.15A3 3 0 0012 9a3 3 0 00-1.88.66L8.4 7.94C9.5 7.33 10.72 7 12 7z"/></svg>
              </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
          </div>

          {{-- Remember me --}}
          <div class="mt-4">
            <label for="remember_me" class="inline-flex items-center gap-2">
              <input id="remember_me" type="checkbox"
                     class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800"
                     name="remember">
              <span class="text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
            </label>
          </div>

          {{-- Submit --}}
          <div class="mt-5">
            <button
              type="submit"
              x-bind:class="loading ? 'opacity-70 cursor-not-allowed' : ''"
              class="w-full inline-flex items-center justify-center gap-2 rounded-xl bg-indigo-600 px-4 py-2.5 text-white font-medium hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-slate-900">
              <svg x-show="loading" class="h-5 w-5 animate-spin" viewBox="0 0 24 24" fill="none">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
              </svg>
              <span>{{ __('Log in') }}</span>
            </button>
          </div>

          {{-- Divider --}}
          @if (Route::has('oauth.microsoft') || Route::has('oauth.google'))
            <div class="mt-6 flex items-center gap-3">
              <div class="h-px flex-1 bg-slate-200 dark:bg-slate-700"></div>
              <span class="text-xs text-slate-400 dark:text-slate-500">atau</span>
              <div class="h-px flex-1 bg-slate-200 dark:bg-slate-700"></div>
            </div>

            {{-- SSO Buttons --}}
            <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-3">
              @if (Route::has('oauth.microsoft'))
                <a href="{{ route('oauth.microsoft') }}"
                   class="inline-flex items-center justify-center gap-2 rounded-xl border border-slate-300 dark:border-slate-700 px-4 py-2.5 text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-900/40 font-medium">
                  <img src="https://upload.wikimedia.org/wikipedia/commons/4/44/Microsoft_logo.svg" class="h-4 w-auto" alt="Microsoft">
                  <span>Sign in with Microsoft</span>
                </a>
              @endif
              @if (Route::has('oauth.google'))
                <a href="{{ route('oauth.google') }}"
                   class="inline-flex items-center justify-center gap-2 rounded-xl border border-slate-300 dark:border-slate-700 px-4 py-2.5 text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-900/40 font-medium">
                  <img src="https://upload.wikimedia.org/wikipedia/commons/2/2d/Google-favicon-2015.png" class="h-4 w-4" alt="Google">
                  <span>Sign in with Google</span>
                </a>
              @endif
            </div>
          @endif

          {{-- Link ke register (opsional) --}}
          @if (Route::has('register'))
            <p class="mt-6 text-center text-sm text-slate-500 dark:text-slate-400">
              Belum punya akun?
              <a href="{{ route('register') }}" class="font-medium text-indigo-600 hover:text-indigo-500">
                Daftar sekarang
              </a>
            </p>
          @endif
        </form>
      </div>
    </div>

    {{-- Footnote --}}
    <p class="mt-6 text-center text-xs text-slate-500 dark:text-slate-400">
      © {{ now()->year }} {{ config('app.name','Aplikasi') }} · Keamanan terjaga · Privasi dihormati
    </p>
  </div>

  {{-- Alpine.js untuk interaksi kecil (opsional, hapus jika sudah punya Alpine global) --}}
  <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</x-guest-layout>
