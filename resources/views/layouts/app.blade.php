@php
    $viteManifest = public_path('build/manifest.json');
    $viteHot = public_path('hot');
    $assetsReady = file_exists($viteManifest) || file_exists($viteHot);
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Mini Issue Tracker') — {{ config('app.name', 'Laravel') }}</title>

    @if ($assetsReady)
        @fonts
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>
<body class="min-h-screen bg-slate-50 text-slate-900 antialiased">
    @unless ($assetsReady)
        <div style="background:#fffbeb;border-bottom:1px solid #fcd34d;padding:12px 16px;text-align:center;font-size:14px;color:#78350f;">
            <strong>Tailwind CSS is not loaded.</strong>
            Run <code style="background:#fef3c7;padding:2px 6px;border-radius:4px;font-family:monospace;font-size:12px;">npm install && npm run build</code>
            in the project folder, then refresh.
            For live reload, use <code style="background:#fef3c7;padding:2px 6px;border-radius:4px;font-family:monospace;font-size:12px;">npm run dev</code>.
        </div>
    @endunless

    <nav class="border-b border-slate-200 bg-white shadow-sm">
        <div class="mx-auto flex max-w-7xl items-center justify-between gap-4 px-4 py-4 sm:px-6 lg:px-8">
            <a href="{{ route('projects.index') }}" class="text-lg font-semibold text-indigo-600 hover:text-indigo-700">
                Mini Issue Tracker
            </a>
            <div class="flex flex-wrap items-center gap-1 sm:gap-2">
                <a href="{{ route('projects.index') }}"
                   class="rounded-md px-3 py-2 text-sm font-medium {{ request()->routeIs('projects.*') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                    Projects
                </a>
                <a href="{{ route('issues.index') }}"
                   class="rounded-md px-3 py-2 text-sm font-medium {{ request()->routeIs('issues.*') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                    Issues
                </a>
                <a href="{{ route('tags.index') }}"
                   class="rounded-md px-3 py-2 text-sm font-medium {{ request()->routeIs('tags.*') ? 'bg-indigo-50 text-indigo-700' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}">
                    Tags
                </a>

                @auth
                    <form action="{{ route('logout') }}" method="POST" class="ml-2">
                        @csrf
                        <button type="submit"
                                class="rounded-md px-3 py-2 text-sm font-medium text-slate-600 hover:bg-slate-100 hover:text-slate-900">
                            Logout ({{ auth()->user()->name }})
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}"
                       class="ml-2 rounded-md bg-indigo-600 px-3 py-2 text-sm font-medium text-white hover:bg-indigo-700">
                        Login
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <main class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
        @include('partials._flash')
        @yield('content')
    </main>

    @stack('modals')
</body>
</html>
