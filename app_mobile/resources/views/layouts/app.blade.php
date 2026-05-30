<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <title>@yield('title', 'StageFlow Mobile')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        [x-cloak] { display: none !important; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .hide-scrollbar::-webkit-scrollbar { display: none; }
        .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="bg-slate-50 text-slate-900 antialiased overflow-x-hidden pb-10">

    <main>
        @yield('content')
    </main>

    @if(!Route::is('landing') && !Route::is('login'))
    @php $sid = session('student_id', 1); @endphp
    <nav class="fixed bottom-0 left-0 right-0 bg-white/95 backdrop-blur-md border-t border-slate-100 px-4 py-3 z-50 flex justify-between items-center shadow-2xl pb-[env(safe-area-inset-bottom)]">
        <a href="{{ route('student.dashboard', ['id' => $sid]) }}" class="flex flex-col items-center gap-0.5 {{ request()->routeIs('student.dashboard') ? 'text-indigo-600 font-bold' : 'text-slate-400' }}">
            <svg class="size-5 transition-transform active:scale-90" fill="currentColor" viewBox="0 0 24 24"><path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/></svg>
            <span class="text-[8px] uppercase tracking-[0.1em]">Accueil</span>
        </a>

        <a href="{{ route('offres.index') }}" class="flex flex-col items-center gap-0.5 {{ request()->routeIs('offres.*') ? 'text-indigo-600 font-bold' : 'text-slate-400' }}">
            <svg class="size-5 transition-transform active:scale-90" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            <span class="text-[8px] uppercase tracking-[0.1em]">Explorer</span>
        </a>

        <a href="{{ route('student.favoris', ['id' => $sid]) }}" class="flex flex-col items-center gap-0.5 {{ request()->routeIs('student.favoris') ? 'text-rose-500 font-bold' : 'text-slate-400' }}">
            <svg class="size-5 transition-transform active:scale-90" fill="{{ request()->routeIs('student.favoris') ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
            </svg>
            <span class="text-[8px] uppercase tracking-[0.1em]">Favoris</span>
        </a>

        <a href="{{ route('student.candidatures', ['id' => $sid]) }}" class="flex flex-col items-center gap-0.5 {{ request()->routeIs('student.candidatures') ? 'text-indigo-600 font-bold' : 'text-slate-400' }}">
            <svg class="size-5 transition-transform active:scale-90" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
            <span class="text-[8px] uppercase tracking-[0.1em]">Suivi</span>
        </a>

        <a href="{{ route('student.profile', ['id' => $sid]) }}" class="flex flex-col items-center gap-0.5 {{ request()->routeIs('student.profile') ? 'text-indigo-600 font-bold' : 'text-slate-400' }}">
            <svg class="size-5 transition-transform active:scale-90" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
            <span class="text-[8px] uppercase tracking-[0.1em]">Profil</span>
        </a>
    </nav>
    @endif

</body>
</html>
