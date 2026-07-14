<!DOCTYPE html>
<html lang="es" class="dark">
<head>
    <meta charset="UTF-8">
    <script>
        if (localStorage.getItem('theme') === 'light') {
            document.documentElement.classList.remove('dark');
        }
    </script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="noindex, nofollow">
    <title>@yield('title', 'Panel') — Admin</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-50 dark:bg-slate-950 text-slate-800 dark:text-slate-200 antialiased">

    <div class="flex min-h-screen">
        <aside class="hidden w-60 shrink-0 flex-col border-r border-slate-200 dark:border-slate-800 bg-white shadow-sm dark:bg-slate-900/50 dark:shadow-none md:flex">
            <a href="{{ route('admin.dashboard') }}" class="flex h-16 items-center gap-2 border-b border-slate-200 dark:border-slate-800 px-5 font-bold text-slate-900 dark:text-white">
                <span class="font-mono text-emerald-600 dark:text-emerald-400">&lt;/&gt;</span> Admin
            </a>
            <nav class="flex flex-1 flex-col gap-1 p-3">
                @foreach ([
                    ['admin.dashboard', 'admin.dashboard', 'Dashboard'],
                    ['admin.perfil.edit', 'admin.perfil.*', 'Perfil'],
                    ['admin.proyectos.index', 'admin.proyectos.*', 'Proyectos'],
                    ['admin.experiencia.index', 'admin.experiencia.*', 'Experiencia'],
                    ['admin.formacion.index', 'admin.formacion.*', 'Formación'],
                    ['admin.mensajes.index', 'admin.mensajes.*', 'Mensajes'],
                    ['admin.cuenta.edit', 'admin.cuenta.*', 'Cuenta'],
                ] as [$routeName, $pattern, $label])
                    <a href="{{ route($routeName) }}"
                       class="rounded-lg px-3 py-2 text-sm font-medium transition
                              {{ request()->routeIs($pattern) ? 'bg-emerald-500/10 text-emerald-600 dark:text-emerald-400' : 'text-slate-700 dark:text-slate-300 hover:bg-slate-200/70 dark:hover:bg-slate-800/60 hover:text-slate-900 dark:hover:text-white' }}">
                        {{ $label }}
                    </a>
                @endforeach
            </nav>
            <div class="border-t border-slate-200 dark:border-slate-800 p-3">
                <a href="{{ route('home') }}" class="block rounded-lg px-3 py-2 text-sm text-slate-600 dark:text-slate-400 transition hover:bg-slate-200/70 dark:hover:bg-slate-800/60 hover:text-slate-900 dark:hover:text-white">← Ver la web</a>
            </div>
        </aside>

        <div class="flex min-w-0 flex-1 flex-col">
            <header class="flex h-16 items-center justify-between border-b border-slate-200 dark:border-slate-800 bg-white/60 dark:bg-slate-900/30 px-4 sm:px-6">
                <div class="flex items-center gap-3">
                    <a href="{{ route('admin.dashboard') }}" class="font-bold text-slate-900 dark:text-white md:hidden"><span class="font-mono text-emerald-600 dark:text-emerald-400">&lt;/&gt;</span> Admin</a>
                    <h1 class="hidden text-lg font-semibold text-slate-900 dark:text-white md:block">@yield('title', 'Panel de administración')</h1>
                </div>
                <div class="flex items-center gap-3">
                    @include('partials.theme-toggle')
                    <span class="hidden text-sm text-slate-600 dark:text-slate-400 sm:block">{{ auth()->user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="rounded-lg border border-slate-300 dark:border-slate-700 px-3 py-1.5 text-sm text-slate-700 dark:text-slate-300 transition hover:border-red-500/40 hover:text-red-600 dark:hover:text-red-400">
                            Cerrar sesión
                        </button>
                    </form>
                </div>
            </header>

            {{-- Navegación móvil del panel --}}
            <nav class="flex gap-1 overflow-x-auto border-b border-slate-200 dark:border-slate-800 bg-white/60 dark:bg-slate-900/30 p-2 md:hidden">
                @foreach ([
                    ['admin.dashboard', 'Dashboard'],
                    ['admin.perfil.edit', 'Perfil'],
                    ['admin.proyectos.index', 'Proyectos'],
                    ['admin.experiencia.index', 'Experiencia'],
                    ['admin.formacion.index', 'Formación'],
                    ['admin.mensajes.index', 'Mensajes'],
                    ['admin.cuenta.edit', 'Cuenta'],
                ] as [$routeName, $label])
                    <a href="{{ route($routeName) }}" class="whitespace-nowrap rounded-lg px-3 py-1.5 text-sm text-slate-700 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-800">{{ $label }}</a>
                @endforeach
            </nav>

            <main class="flex-1 p-4 sm:p-6">
                @if (session('status'))
                    <div class="mb-5 rounded-lg border border-emerald-500/30 bg-emerald-500/10 px-4 py-3 text-sm text-emerald-700 dark:text-emerald-300">
                        {{ session('status') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-5 rounded-lg border border-red-500/30 bg-red-500/10 px-4 py-3 text-sm text-red-700 dark:text-red-300">
                        <ul class="list-inside list-disc space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

</body>
</html>
