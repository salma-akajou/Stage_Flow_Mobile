@extends('layouts.app')

@section('title', 'Mon Profil - StageFlow Mobile')

@section('content')
@php
    $photoUrl = null;
    if (!empty($etudiant['photo'])) {
        $baseUrl = rtrim(str_replace('/api', '', $apiUrl), '/');
        $photoPath = ltrim(str_replace('\\', '/', $etudiant['photo']), '/');
        $photoUrl = $baseUrl . '/storage/' . $photoPath;
    }
    $initials = '';
    if (!empty($etudiant['user']['prenom']) && !empty($etudiant['user']['nom'])) {
        $initials = strtoupper(substr($etudiant['user']['prenom'], 0, 1) . substr($etudiant['user']['nom'], 0, 1));
    } else {
        $initials = strtoupper(substr($etudiant['user']['prenom'] ?? 'U', 0, 1));
    }
@endphp


<div class="min-h-screen bg-slate-50 pb-32">
    <!-- Header -->
    <div class="sticky top-0 z-50 bg-white border-b border-slate-200 px-6 pt-12 pb-4 flex items-center justify-between shadow-sm">
        <h1 class="text-sm font-black text-slate-800 uppercase tracking-widest">Mon profil</h1>
    </div>

    <!-- Profile Card (Top Area) -->
    <div class="bg-white p-6 border-b border-slate-200 flex flex-col items-center">
        <div class="relative mb-3">
            @if($photoUrl)
                <img class="w-20 h-20 rounded-full object-cover border-4 border-slate-100 shadow-sm" src="{{ $photoUrl }}" alt="Profile" onerror="this.style.display='none'; this.parentElement.querySelector('.fallback').style.display='flex'">
                <div class="fallback w-20 h-20 rounded-full text-white font-extrabold text-xl items-center justify-center shadow-sm" style="background-color: #4f46e5; display: none; align-items: center; justify-content: center; color: white;">
                    {{ $initials }}
                </div>
            @else
                <div class="w-20 h-20 rounded-full text-white font-extrabold text-xl flex items-center justify-center shadow-sm" style="background-color: #4f46e5; display: flex; align-items: center; justify-content: center; color: white;">
                    {{ $initials }}
                </div>
            @endif
        </div>
        <h2 class="text-lg font-bold text-slate-900 leading-tight">
            {{ ($etudiant['user']['prenom'] ?? '') . ' ' . ($etudiant['user']['nom'] ?? '') }}
        </h2>
    </div>

    <!-- Profile Details & Info Cards -->
    <div class="p-6 space-y-5">
        
        <!-- À propos de moi (Bio) -->
        @if(!empty($etudiant['bio']))
        <div class="bg-white rounded-2xl p-4 shadow-sm border border-slate-200">
            <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">À propos de moi</h3>
            <p class="text-xs text-slate-600 leading-relaxed font-medium">
                {{ $etudiant['bio'] }}
            </p>
        </div>
        @endif

        <!-- Academic Info -->
        <div class="bg-white rounded-2xl p-4 shadow-sm border border-slate-200">
            <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Informations Académiques</h3>
            <div class="space-y-3">
                <div class="flex justify-between items-center">
                    <span class="text-xs text-slate-500 font-medium">Établissement</span>
                    <span class="text-xs font-bold text-slate-900">{{ $etudiant['etablissement'] ?? 'Non renseigné' }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-xs text-slate-500 font-medium">Filière</span>
                    <span class="text-xs font-bold text-slate-900">{{ $etudiant['filiere'] ?? 'Non renseignée' }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-xs text-slate-500 font-medium">Niveau d'études</span>
                    <span class="text-xs font-bold text-slate-900">{{ $etudiant['niveau_etudes'] ?? 'Non renseigné' }}</span>
                </div>
            </div>
        </div>

        <!-- Contact Info -->
        <div class="bg-white rounded-2xl p-4 shadow-sm border border-slate-200">
            <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Coordonnées</h3>
            <div class="space-y-3">
                <div class="flex justify-between items-center">
                    <span class="text-xs text-slate-500 font-medium">Email</span>
                    <span class="text-xs font-bold text-slate-900">{{ $etudiant['user']['email'] ?? 'Non renseigné' }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-xs text-slate-500 font-medium">Ville</span>
                    <span class="text-xs font-bold text-slate-900">{{ $etudiant['ville']['nom'] ?? 'Non renseignée' }}</span>
                </div>
            </div>
        </div>

        <!-- Social Networks -->
        @if(!empty($etudiant['github']) || !empty($etudiant['linkedin']))
        <div class="bg-white rounded-2xl p-4 shadow-sm border border-slate-200">
            <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Réseaux Professionnels</h3>
            <div class="space-y-3">
                @if(!empty($etudiant['github']))
                <div class="flex justify-between items-center">
                    <span class="text-xs text-slate-500 font-medium">GitHub</span>
                    <a href="{{ str_contains($etudiant['github'], 'http') ? $etudiant['github'] : 'https://github.com/' . $etudiant['github'] }}" 
                       target="_blank"
                       class="text-xs font-bold text-indigo-600 flex items-center gap-1 hover:underline">
                        <span>Voir le profil</span>
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                        </svg>
                    </a>
                </div>
                @endif
                @if(!empty($etudiant['linkedin']))
                <div class="flex justify-between items-center">
                    <span class="text-xs text-slate-500 font-medium">LinkedIn</span>
                    <a href="{{ str_contains($etudiant['linkedin'], 'http') ? $etudiant['linkedin'] : 'https://linkedin.com/in/' . $etudiant['linkedin'] }}" 
                       target="_blank"
                       class="text-xs font-bold text-indigo-600 flex items-center gap-1 hover:underline">
                        <span>Voir le profil</span>
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                        </svg>
                    </a>
                </div>
                @endif
            </div>
        </div>
        @endif

        <!-- Profile Statistics -->
        <div class="bg-white rounded-2xl p-4 shadow-sm border border-slate-200">
            <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Statistiques</h3>
            <div class="space-y-3">
                <div class="flex justify-between items-center">
                    <span class="text-xs text-slate-500 font-medium">Vues du profil</span>
                    <span class="text-xs font-bold text-slate-900 flex items-center gap-1">
                        {{ $etudiant['vues'] ?? 0 }}
                    </span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-xs text-slate-500 font-medium">Candidatures</span>
                    <span class="text-xs font-bold text-slate-900 flex items-center gap-1">
                        {{ $etudiant['candidatures_count'] ?? 0 }}
                    </span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-xs text-slate-500 font-medium">Favoris</span>
                    <span class="text-xs font-bold text-slate-900 flex items-center gap-1">
                        {{ $etudiant['favoris_count'] ?? 0 }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Logout Action -->
        <div class="pt-2">
            <form action="{{ route('logout') }}" method="POST" class="w-full">
                @csrf
                <button type="submit" 
                        class="w-full py-3.5 rounded-2xl border border-rose-200 bg-rose-50 text-rose-600 font-bold text-xs active:bg-rose-100 active:scale-[0.98] transition-all flex items-center justify-center gap-2 shadow-sm">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    Déconnexion
                </button>
            </form>
        </div>

    </div>
</div>
@endsection
