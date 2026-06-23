@extends('layouts.app')

@section('title', 'Login')

@section('content')
    <div class="mx-auto max-w-md">
        <h1 class="text-2xl font-bold text-slate-900">Sign in</h1>
        <p class="mt-1 text-sm text-slate-600">Use a seeded account to manage your own projects.</p>

        <div class="mt-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
            @include('partials._errors')

            <form action="{{ route('login') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label for="email" class="mb-1 block text-sm font-medium text-slate-700">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                           class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500">
                </div>

                <div>
                    <label for="password" class="mb-1 block text-sm font-medium text-slate-700">Password</label>
                    <input type="password" name="password" id="password" required
                           class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500">
                </div>

                <label class="flex items-center gap-2 text-sm text-slate-600">
                    <input type="checkbox" name="remember" value="1" class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                    Remember me
                </label>

                <button type="submit"
                        class="w-full rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700">
                    Sign in
                </button>
            </form>

            <p class="mt-4 text-xs text-slate-500">
                Demo: alice@example.com / password
            </p>
        </div>
    </div>
@endsection
