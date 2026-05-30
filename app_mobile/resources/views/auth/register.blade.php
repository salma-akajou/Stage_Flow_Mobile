@extends('layouts.app')

@section('title', 'Inscription - StageFlow')

@section('content')
<div class="min-h-screen bg-slate-50 flex flex-col pb-16" x-data="registerPage()">

    {{-- Header --}}
    <div class="relative h-44 overflow-hidden shrink-0">
        <div class="absolute inset-0 bg-gradient-to-br from-indigo-600 via-indigo-700 to-violet-800"></div>
        <div class="absolute -top-10 -right-10 size-44 bg-white/10 rounded-full blur-2xl"></div>
        <div class="absolute -bottom-10 -left-10 size-36 bg-indigo-400/20 rounded-full blur-2xl"></div>
        <div class="relative z-10 flex flex-col justify-end px-6 pb-6 h-full text-left">
            <div class="inline-flex items-center gap-x-2 mb-2">
                <div class="size-8 bg-white rounded-xl flex items-center justify-center shadow-lg overflow-hidden p-1">
                    <img src="{{ asset('logo_app.png') }}" alt="Logo" class="size-full object-contain">
                </div>
                <span class="text-white font-black text-lg tracking-tight">StageFlow</span>
            </div>
            <h1 class="text-xl font-black text-white leading-tight">Rejoignez-nous ! 👋</h1>
            <p class="text-indigo-200 text-[10px] font-medium mt-0.5">Créez votre compte étudiant en quelques instants</p>
        </div>
    </div>

    {{-- Form Card --}}
    <div class="flex-1 px-6 -mt-6 relative z-10">
        <div class="bg-white rounded-[2.5rem] shadow-2xl shadow-indigo-100 p-6 space-y-5">

            {{-- Erreur globale --}}
            @if ($errors->any())
            <div class="p-4 rounded-2xl bg-red-50 border border-red-100 flex items-start gap-3">
                <svg class="size-5 text-red-500 shrink-0 mt-0.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                <p class="text-xs text-red-600 font-semibold">{{ $errors->first() }}</p>
            </div>
            @endif

            <form method="POST" action="{{ route('register.submit') }}" class="space-y-4" @submit="submitForm()">
                @csrf
                <input type="hidden" name="role" value="etudiant">

                {{-- Nom & Prénom (Stacked side-by-side) --}}
                <div class="grid grid-cols-2 gap-3">
                    <div class="space-y-1.5">
                        <label for="prenom" class="text-[10px] font-bold text-slate-600 uppercase tracking-widest pl-1">Prénom</label>
                        <input
                            type="text"
                            id="prenom"
                            name="prenom"
                            value="{{ old('prenom') }}"
                            placeholder="Prénom"
                            required
                            class="w-full px-4 py-3.5 rounded-2xl border-2 border-slate-100 bg-slate-50 text-xs font-medium text-slate-800 placeholder-slate-300 focus:outline-none focus:border-indigo-400 focus:bg-white transition-all"
                        >
                    </div>
                    <div class="space-y-1.5">
                        <label for="nom" class="text-[10px] font-bold text-slate-600 uppercase tracking-widest pl-1">Nom</label>
                        <input
                            type="text"
                            id="nom"
                            name="nom"
                            value="{{ old('nom') }}"
                            placeholder="Nom"
                            required
                            class="w-full px-4 py-3.5 rounded-2xl border-2 border-slate-100 bg-slate-50 text-xs font-medium text-slate-800 placeholder-slate-300 focus:outline-none focus:border-indigo-400 focus:bg-white transition-all"
                        >
                    </div>
                </div>

                {{-- Email --}}
                <div class="space-y-1.5">
                    <label for="email" class="text-[10px] font-bold text-slate-600 uppercase tracking-widest pl-1">Email</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="votre@email.com"
                        required
                        class="w-full px-4 py-3.5 rounded-2xl border-2 border-slate-100 bg-slate-50 text-xs font-medium text-slate-800 placeholder-slate-300 focus:outline-none focus:border-indigo-400 focus:bg-white transition-all"
                    >
                </div>

                {{-- Ville (Dynamic List) --}}
                <div class="space-y-1.5">
                    <label for="ville_id" class="text-[10px] font-bold text-slate-600 uppercase tracking-widest pl-1">Ville</label>
                    <select
                        id="ville_id"
                        name="ville_id"
                        required
                        class="w-full px-4 py-3.5 rounded-2xl border-2 border-slate-100 bg-slate-50 text-xs font-medium text-slate-800 focus:outline-none focus:border-indigo-400 focus:bg-white transition-all"
                    >
                        <option value="" disabled selected>Sélectionnez votre ville</option>
                        @foreach($villes as $ville)
                            <option value="{{ $ville['id'] }}" {{ old('ville_id') == $ville['id'] ? 'selected' : '' }}>{{ $ville['nom'] }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Établissement & Niveau d'études (Grid) --}}
                <div class="grid grid-cols-2 gap-3">
                    <div class="space-y-1.5">
                        <label for="etablissement" class="text-[10px] font-bold text-slate-600 uppercase tracking-widest pl-1">Établissement</label>
                        <select
                            id="etablissement"
                            name="etablissement"
                            required
                            class="w-full px-3 py-3.5 rounded-2xl border-2 border-slate-100 bg-slate-50 text-xs font-medium text-slate-800 focus:outline-none focus:border-indigo-400 focus:bg-white transition-all"
                        >
                            <option value="" disabled selected>Établissement</option>
                            @foreach(['Solicode', 'Faculté', 'ISTA', 'EMSI', 'ENSI', 'BTS', 'Autre'] as $etab)
                                <option value="{{ $etab }}" {{ old('etablissement') == $etab ? 'selected' : '' }}>{{ $etab }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="space-y-1.5">
                        <label for="niveau_etude" class="text-[10px] font-bold text-slate-600 uppercase tracking-widest pl-1">Niveau d'études</label>
                        <select
                            id="niveau_etude"
                            name="niveau_etude"
                            required
                            class="w-full px-3 py-3.5 rounded-2xl border-2 border-slate-100 bg-slate-50 text-xs font-medium text-slate-800 focus:outline-none focus:border-indigo-400 focus:bg-white transition-all"
                        >
                            <option value="" disabled selected>Niveau d'études</option>
                            @foreach(['Bac+2', 'Bac+3', 'Master', 'Doctorat', 'Autre'] as $niv)
                                <option value="{{ $niv }}" {{ old('niveau_etude') == $niv ? 'selected' : '' }}>{{ $niv }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Filière --}}
                <div class="space-y-1.5">
                    <label for="filiere" class="text-[10px] font-bold text-slate-600 uppercase tracking-widest pl-1">Filière / Spécialisation</label>
                    <input
                        type="text"
                        id="filiere"
                        name="filiere"
                        value="{{ old('filiere') }}"
                        placeholder="Développement Web"
                        required
                        class="w-full px-4 py-3.5 rounded-2xl border-2 border-slate-100 bg-slate-50 text-xs font-medium text-slate-800 placeholder-slate-300 focus:outline-none focus:border-indigo-400 focus:bg-white transition-all"
                    >
                </div>

                {{-- Bio --}}
                <div class="space-y-1.5">
                    <label for="bio" class="text-[10px] font-bold text-slate-600 uppercase tracking-widest pl-1">À propos de vous (Bio)</label>
                    <textarea
                        id="bio"
                        name="bio"
                        placeholder="Quelques mots sur vous..."
                        rows="2"
                        class="w-full px-4 py-3 rounded-2xl border-2 border-slate-100 bg-slate-50 text-xs font-medium text-slate-800 placeholder-slate-300 focus:outline-none focus:border-indigo-400 focus:bg-white transition-all resize-none"
                    >{{ old('bio') }}</textarea>
                </div>

                {{-- GitHub & LinkedIn --}}
                <div class="grid grid-cols-2 gap-3">
                    <div class="space-y-1.5">
                        <label for="github" class="text-[10px] font-bold text-slate-600 uppercase tracking-widest pl-1">GitHub</label>
                        <input
                            type="text"
                            id="github"
                            name="github"
                            value="{{ old('github') }}"
                            placeholder="nom_utilisateur"
                            class="w-full px-4 py-3.5 rounded-2xl border-2 border-slate-100 bg-slate-50 text-xs font-medium text-slate-800 placeholder-slate-300 focus:outline-none focus:border-indigo-400 focus:bg-white transition-all"
                        >
                    </div>
                    <div class="space-y-1.5">
                        <label for="linkedin" class="text-[10px] font-bold text-slate-600 uppercase tracking-widest pl-1">LinkedIn</label>
                        <input
                            type="text"
                            id="linkedin"
                            name="linkedin"
                            value="{{ old('linkedin') }}"
                            placeholder="identifiant"
                            class="w-full px-4 py-3.5 rounded-2xl border-2 border-slate-100 bg-slate-50 text-xs font-medium text-slate-800 placeholder-slate-300 focus:outline-none focus:border-indigo-400 focus:bg-white transition-all"
                        >
                    </div>
                </div>

                {{-- Mot de passe & Confirmation (Grid) --}}
                <div class="grid grid-cols-2 gap-3 pt-2">
                    <div class="space-y-1.5">
                        <label for="password" class="text-[10px] font-bold text-slate-600 uppercase tracking-widest pl-1">Mot de passe</label>
                        <div class="relative">
                            <input
                                :type="showPwd ? 'text' : 'password'"
                                id="password"
                                name="password"
                                placeholder="••••••••"
                                required
                                class="w-full pl-4 pr-10 py-3.5 rounded-2xl border-2 border-slate-100 bg-slate-50 text-xs font-medium text-slate-800 placeholder-slate-300 focus:outline-none focus:border-indigo-400 focus:bg-white transition-all"
                            >
                            <button type="button" @click="showPwd = !showPwd" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400">
                                <svg x-show="!showPwd" class="size-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7z"/><circle cx="12" cy="12" r="3"/></svg>
                                <svg x-show="showPwd" class="size-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M9.88 9.88a3 3 0 1 0 4.24 4.24"/><path d="M10.73 5.08A10.43 10.43 0 0 1 12 5c7 0 10 7 10 7a13.16 13.16 0 0 1-1.67 2.68"/><path d="M6.61 6.61A13.526 13.526 0 0 0 2 12s3 7 10 7a9.74 9.74 0 0 0 5.39-1.61"/><line x1="2" y1="2" x2="22" y2="22"/></svg>
                            </button>
                        </div>
                    </div>
                    <div class="space-y-1.5">
                        <label for="password_confirmation" class="text-[10px] font-bold text-slate-600 uppercase tracking-widest pl-1">Confirmation</label>
                        <div class="relative">
                            <input
                                :type="showConfirmPwd ? 'text' : 'password'"
                                id="password_confirmation"
                                name="password_confirmation"
                                placeholder="••••••••"
                                required
                                class="w-full pl-4 pr-10 py-3.5 rounded-2xl border-2 border-slate-100 bg-slate-50 text-xs font-medium text-slate-800 placeholder-slate-300 focus:outline-none focus:border-indigo-400 focus:bg-white transition-all"
                            >
                            <button type="button" @click="showConfirmPwd = !showConfirmPwd" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400">
                                <svg x-show="!showConfirmPwd" class="size-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7z"/><circle cx="12" cy="12" r="3"/></svg>
                                <svg x-show="showConfirmPwd" class="size-4.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M9.88 9.88a3 3 0 1 0 4.24 4.24"/><path d="M10.73 5.08A10.43 10.43 0 0 1 12 5c7 0 10 7 10 7a13.16 13.16 0 0 1-1.67 2.68"/><path d="M6.61 6.61A13.526 13.526 0 0 0 2 12s3 7 10 7a9.74 9.74 0 0 0 5.39-1.61"/><line x1="2" y1="2" x2="22" y2="22"/></svg>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Submit Button --}}
                <button
                    type="submit"
                    :disabled="loading"
                    :class="loading ? 'opacity-50 cursor-not-allowed' : 'active:scale-95 shadow-xl shadow-indigo-100 hover:bg-indigo-700'"
                    class="w-full py-4 rounded-2xl bg-indigo-600 text-white font-black text-xs uppercase tracking-widest transition-all flex items-center justify-center gap-2 mt-4"
                >
                    <span x-show="!loading">Créer mon compte</span>
                    <span x-show="loading" class="flex items-center gap-2">
                        <svg class="animate-spin h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Création en cours...
                    </span>
                </button>
            </form>

            <div class="text-center pt-2">
                <p class="text-xs text-slate-400 font-medium">
                    Déjà un compte ? 
                    <a href="{{ route('login') }}" class="text-indigo-600 font-bold hover:underline">Se connecter</a>
                </p>
            </div>

        </div>
    </div>

</div>
@endsection
