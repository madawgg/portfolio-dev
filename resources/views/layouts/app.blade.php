<!DOCTYPE html>
<html lang="es" class="scroll-smooth dark">
<head>
    <meta charset="UTF-8">
    <script>
        // Oscuro por defecto; si el visitante eligió claro, se respeta.
        // Va antes del CSS para evitar el parpadeo de tema al cargar.
        if (localStorage.getItem('theme') === 'light') {
            document.documentElement.classList.remove('dark');
        }
    </script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Portfolio') — {{ $siteProfile->full_name }}</title>
    <meta name="description" content="@yield('meta_description', $siteProfile->headline.' — Portfolio de '.$siteProfile->full_name)">
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">

    {{-- Tarjetas de vista previa al compartir (LinkedIn, X, WhatsApp...) --}}
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="{{ $siteProfile->full_name }}">
    <meta property="og:title" content="@yield('title', 'Portfolio') — {{ $siteProfile->full_name }}">
    <meta property="og:description" content="@yield('meta_description', $siteProfile->headline)">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:locale" content="es_ES">
    <meta name="twitter:card" content="summary">
    @if ($siteProfile->photoUrl())
        <meta property="og:image" content="{{ $siteProfile->photoUrl() }}">
        <meta name="twitter:image" content="{{ $siteProfile->photoUrl() }}">
    @endif

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-50 dark:bg-slate-950 text-slate-800 dark:text-slate-200 antialiased flex flex-col">

    <header class="sticky top-0 z-50 border-b border-slate-200/80 dark:border-slate-800/80 bg-white/80 dark:bg-slate-950/80 backdrop-blur">
        <nav class="mx-auto flex h-16 max-w-6xl items-center justify-between px-4 sm:px-6">
            <a href="{{ route('home') }}" class="flex items-center gap-2 text-lg font-bold tracking-tight text-slate-900 dark:text-white">
                <span class="text-emerald-600 dark:text-emerald-400 font-mono">&lt;/&gt;</span>
                {{ $siteProfile->full_name }}
            </a>

            <div class="flex items-center gap-1 sm:hidden">
                @include('partials.theme-toggle')
            </div>

            <input type="checkbox" id="nav-toggle" class="peer hidden">
            <label for="nav-toggle" class="cursor-pointer p-2 text-slate-700 dark:text-slate-300 sm:hidden" aria-label="Abrir menú">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </label>

            <div class="absolute left-0 top-16 hidden w-full flex-col gap-1 border-b border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-950 p-4 peer-checked:flex sm:static sm:flex sm:w-auto sm:flex-row sm:items-center sm:gap-1 sm:border-0 sm:bg-transparent sm:p-0">
                @foreach ([
                    'home' => 'Inicio',
                    'about' => 'Sobre mí',
                    'projects' => 'Proyectos',
                    'contact' => 'Contacto',
                ] as $routeName => $label)
                    <a href="{{ route($routeName) }}"
                       class="rounded-lg px-3 py-2 text-sm font-medium transition
                              {{ request()->routeIs($routeName) ? 'text-emerald-600 dark:text-emerald-400' : 'text-slate-700 dark:text-slate-300 hover:bg-slate-200/70 dark:hover:bg-slate-800/60 hover:text-slate-900 dark:hover:text-white' }}">
                        {{ $label }}
                    </a>
                @endforeach

                @auth
                    <a href="{{ route('admin.dashboard') }}"
                       class="ml-0 rounded-lg border border-emerald-500/40 px-3 py-2 text-sm font-medium text-emerald-600 dark:text-emerald-400 transition hover:bg-emerald-500/10 sm:ml-2">
                        Panel admin
                    </a>
                @else
                    <a href="{{ route('login') }}"
                       class="ml-0 rounded-lg border border-slate-300 dark:border-slate-700 px-3 py-2 text-sm font-medium text-slate-700 dark:text-slate-300 transition hover:border-emerald-500/40 hover:text-emerald-600 dark:hover:text-emerald-400 sm:ml-2">
                        Login
                    </a>
                @endauth

                <span class="hidden sm:ml-1 sm:block">
                    @include('partials.theme-toggle')
                </span>
            </div>
        </nav>
    </header>

    <main class="flex-1">
        @yield('content')
    </main>

    <footer class="border-t border-slate-200/80 dark:border-slate-800/80 py-8">
        <div class="mx-auto flex max-w-6xl flex-col items-center justify-between gap-4 px-4 text-sm text-slate-500 sm:flex-row sm:px-6">
            <p>© {{ date('Y') }} {{ $siteProfile->full_name }}</p>
            <div class="flex items-center gap-4">
                @if ($siteProfile->github_url)
                    <a href="{{ $siteProfile->github_url }}" target="_blank" rel="noopener noreferrer" class="transition hover:text-emerald-600 dark:hover:text-emerald-400">GitHub</a>
                @endif
                @if ($siteProfile->linkedin_url)
                    <a href="{{ $siteProfile->linkedin_url }}" target="_blank" rel="noopener noreferrer" class="transition hover:text-emerald-600 dark:hover:text-emerald-400">LinkedIn</a>
                @endif
                @if ($siteProfile->public_email)
                    <a href="mailto:{{ $siteProfile->public_email }}" class="transition hover:text-emerald-600 dark:hover:text-emerald-400">Email</a>
                @endif
            </div>
        </div>
    </footer>

</body>
</html>
