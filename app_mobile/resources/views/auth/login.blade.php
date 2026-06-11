@extends('layouts.app')

@section('title', 'Connexion - StageFlow')

@section('content')
<div class="min-h-screen bg-slate-50 flex flex-col" x-data="loginPage()">

    {{-- Header --}}
    <div class="relative h-52 overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-br from-indigo-600 via-indigo-700 to-violet-800"></div>
        <div class="absolute -top-10 -right-10 size-52 bg-white/10 rounded-full blur-2xl"></div>
        <div class="absolute -bottom-10 -left-10 size-40 bg-indigo-400/20 rounded-full blur-2xl"></div>
        <div class="relative z-10 flex flex-col justify-end px-6 pb-8 h-full">
            <div class="inline-flex items-center gap-x-2 mb-4">
                <div class="size-10 bg-white rounded-2xl flex items-center justify-center shadow-lg overflow-hidden p-1.5">
                    <img src="{{ asset('logo_app.png') }}" alt="Logo" class="size-full object-contain">
                </div>
                <span class="text-white font-black text-xl tracking-tight">StageFlow</span>
            </div>
            <h1 class="text-2xl font-black text-white leading-tight">Bon retour ! 👋</h1>
            <p class="text-indigo-200 text-xs font-medium mt-1">Connectez-vous pour accéder à votre espace</p>
        </div>
    </div>

    {{-- Form Card --}}
    <div class="flex-1 px-6 -mt-6 relative z-10 pb-10">
        <div class="bg-white rounded-[2.5rem] shadow-2xl shadow-indigo-100 p-6 space-y-5">


            <form method="POST" action="/login" class="space-y-4" novalidate>
                @csrf

                {{-- Email --}}
                <div class="space-y-1.5">
                    <label for="email" class="text-xs font-bold text-slate-600 uppercase tracking-widest pl-1">Email</label>
                    <div class="relative">
                        <div class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                        </div>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="votre@email.com"
                            required
                            autocomplete="email"
                            class="w-full pl-11 pr-4 py-4 rounded-2xl border-2 border-slate-100 bg-slate-50 text-sm font-medium text-slate-800 placeholder-slate-300 focus:outline-none focus:border-indigo-400 focus:bg-white transition-all @error('email') border-red-300 @enderror"
                        >
                    </div>
                    @error('email')
                        <p class="text-[10px] text-red-500 font-semibold pl-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="space-y-1.5">
                    <label for="password" class="text-xs font-bold text-slate-600 uppercase tracking-widest pl-1">Mot de passe</label>
                    <div class="relative">
                        <div class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                        </div>
                        <input
                            :type="showPwd ? 'text' : 'password'"
                            id="password"
                            name="password"
                            placeholder="••••••••"
                            required
                            autocomplete="current-password"
                            class="w-full pl-11 pr-12 py-4 rounded-2xl border-2 border-slate-100 bg-slate-50 text-sm font-medium text-slate-800 placeholder-slate-300 focus:outline-none focus:border-indigo-400 focus:bg-white transition-all @error('password') border-red-300 @enderror"
                        >
                        <button type="button" @click="showPwd = !showPwd" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400">
                            <svg x-show="!showPwd" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7z"/><circle cx="12" cy="12" r="3"/></svg>
                            <svg x-show="showPwd" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M9.88 9.88a3 3 0 1 0 4.24 4.24"/><path d="M10.73 5.08A10.43 10.43 0 0 1 12 5c7 0 10 7 10 7a13.16 13.16 0 0 1-1.67 2.68"/><path d="M6.61 6.61A13.526 13.526 0 0 0 2 12s3 7 10 7a9.74 9.74 0 0 0 5.39-1.61"/><line x1="2" y1="2" x2="22" y2="22"/></svg>
                        </button>
                    </div>
                    @error('password')
                        <p class="text-[10px] text-red-500 font-semibold pl-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Submit Button --}}
                <button
                    type="submit"
                    class="w-full py-4 rounded-2xl bg-indigo-600 text-white font-black text-sm shadow-xl shadow-indigo-200 active:scale-95 transition-all flex items-center justify-center gap-2 mt-2"
                >
                    Se connecter
                </button>
            </form>

            <div class="text-center pt-2">
                <p class="text-xs text-slate-400 font-medium">
                    Nouveau sur StageFlow ? 
                    <a href="{{ route('register') }}" class="text-indigo-600 font-bold hover:underline">Créer un compte</a>
                </p>
            </div>

        </div>

        {{-- Footer --}}
        <p class="text-center text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-4">
            © 2026 StageFlow Maroc
        </p>
    </div>

</div>
@endsection
