<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
    <title>@yield('title', 'StageFlow Mobile')</title>
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

    @if(!Route::is('landing'))
    <nav class="fixed bottom-0 left-0 right-0 bg-white/95 backdrop-blur-md border-t border-slate-100 px-4 py-3 z-50 flex justify-around items-center shadow-2xl pb-[env(safe-area-inset-bottom)]">
        <a href="{{ route('student.dashboard', ['id' => 1]) }}" class="flex flex-col items-center gap-1 {{ request()->routeIs('student.dashboard') ? 'text-indigo-600' : 'text-slate-400' }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><rect width="7" height="9" x="3" y="3" rx="1"/><rect width="7" height="5" x="14" y="3" rx="1"/><rect width="7" height="9" x="14" y="12" rx="1"/><rect width="7" height="5" x="3" y="16" rx="1"/></svg>
            <span class="text-[9px] font-bold uppercase tracking-wide">Accueil</span>
        </a>

        <a href="{{ route('offres.index') }}" class="flex flex-col items-center gap-1 {{ request()->routeIs('offres.*') ? 'text-indigo-600' : 'text-slate-400' }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
            <span class="text-[9px] font-bold uppercase tracking-wide">Offres</span>
        </a>

        <a href="{{ route('student.candidatures', ['id' => 1]) }}" class="flex flex-col items-center gap-1 {{ request()->routeIs('student.candidatures') ? 'text-indigo-600' : 'text-slate-400' }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"/><path d="M14 2v4a2 2 0 0 0 2 2h4"/><path d="M9 13h6"/><path d="M9 17h3"/></svg>
            <span class="text-[9px] font-bold uppercase tracking-wide">Suivi</span>
        </a>
    </nav>
    @endif

</body>
</html>
