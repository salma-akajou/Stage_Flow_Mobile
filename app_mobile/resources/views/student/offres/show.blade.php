@extends('layouts.app')

@section('title', ($offre['titre'] ?? 'Détail') . ' - StageFlow Mobile')

@section('content')
<div class="min-h-screen bg-slate-50 pb-32">
    <!-- Header -->
    <div class="sticky top-0 z-50 bg-white/80 backdrop-blur-xl border-b border-slate-100 px-6 py-4 flex items-center gap-4">
        <a href="{{ route('offres.index') }}" class="size-10 bg-slate-50 flex items-center justify-center rounded-xl border border-slate-100 active:scale-90 transition">
            <svg class="size-5 text-slate-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="m15 18-6-6 6-6"/></svg>
        </a>
        <h1 class="text-sm font-black text-slate-800 uppercase tracking-widest truncate">Détail de l'Offre</h1>
    </div>

    <!-- Main Content -->
    <div class="px-6 py-8 space-y-8 text-left">
        
        <!-- Header Card -->
        <div class="bg-white border border-slate-100 rounded-[2.5rem] p-8 shadow-xl shadow-slate-200/40 text-center relative overflow-hidden">
            <div class="absolute top-0 right-0 p-6 opacity-5 rotate-12">
                <svg class="size-24 text-indigo-600" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5z"/></svg>
            </div>

            <div class="size-24 bg-slate-50 border border-slate-100 rounded-3xl mx-auto flex items-center justify-center mb-6 overflow-hidden shadow-inner">
                @if(isset($offre['entreprise']['user']['photo']))
                    <img src="{{ str_replace('/api', '', env('VITE_API_URL')) }}/storage/{{ $offre['entreprise']['user']['photo'] }}" class="size-16 object-contain">
                @else
                    <span class="text-indigo-600 font-black text-3xl">{{ substr($offre['entreprise']['nom_entreprise'] ?? 'S', 0, 1) }}</span>
                @endif
            </div>

            <div class="space-y-2 relative z-10">
                <div class="flex items-center justify-center gap-1.5">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em]">{{ $offre['entreprise']['nom_entreprise'] ?? 'STAGEFLOW' }}</span>
                    <svg class="size-3.5 text-indigo-600" fill="currentColor" viewBox="0 0 24 24"><path d="M12 22S2 16 2 8V4l10-3 10 3v4c0 8-10 14-10 14Z" /></svg>
                </div>
                <h2 class="text-2xl font-black text-slate-900 leading-tight tracking-tight">{{ $offre['titre'] }}</h2>
                <div class="flex items-center justify-center gap-4 pt-2">
                    <span class="flex items-center gap-1.5 text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                        <svg class="size-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z" /></svg>
                        {{ $offre['ville']['nom'] ?? 'Maroc' }}
                    </span>
                    <span class="size-1 bg-slate-200 rounded-full"></span>
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest italic">
                        Publié {{ \Carbon\Carbon::parse($offre['created_at'])->diffForHumans() }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Info Grid -->
        <div class="grid grid-cols-2 gap-4">
            <div class="bg-white p-5 rounded-[2rem] border border-slate-100 shadow-sm flex flex-col items-center text-center gap-3">
                <div class="size-10 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center">
                    <svg class="size-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div class="space-y-0.5">
                    <p class="text-[8px] font-bold text-slate-400 uppercase tracking-widest">Durée</p>
                    <p class="text-xs font-black text-slate-800">{{ $offre['duree'] }}</p>
                </div>
            </div>
            <div class="bg-white p-5 rounded-[2rem] border border-slate-100 shadow-sm flex flex-col items-center text-center gap-3">
                <div class="size-10 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center">
                    <svg class="size-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div class="space-y-0.5">
                    <p class="text-[8px] font-bold text-slate-400 uppercase tracking-widest">Salaire</p>
                    <p class="text-xs font-black text-slate-800">{{ $offre['remuneration'] }}</p>
                </div>
            </div>
            <div class="bg-white p-5 rounded-[2rem] border border-slate-100 shadow-sm flex flex-col items-center text-center gap-3">
                <div class="size-10 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center">
                    <svg class="size-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                </div>
                <div class="space-y-0.5 truncate w-full">
                    <p class="text-[8px] font-bold text-slate-400 uppercase tracking-widest">Format</p>
                    <p class="text-xs font-black text-slate-800 truncate">{{ $offre['format'] ?? 'Hybride' }}</p>
                </div>
            </div>
            <div class="bg-white p-5 rounded-[2rem] border border-slate-100 shadow-sm flex flex-col items-center text-center gap-3">
                <div class="size-10 bg-amber-50 text-amber-600 rounded-2xl flex items-center justify-center">
                    <svg class="size-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                </div>
                <div class="space-y-0.5 truncate w-full">
                    <p class="text-[8px] font-bold text-slate-400 uppercase tracking-widest">Secteur</p>
                    <p class="text-xs font-black text-slate-800 truncate">{{ $offre['secteur'] }}</p>
                </div>
            </div>
        </div>

        <!-- À propos de l'offre -->
        <div class="bg-white border border-slate-100 rounded-[2.5rem] p-8 shadow-sm space-y-6">
            <h3 class="text-lg font-black text-slate-900 tracking-tight">À propos de l'offre</h3>
            <div class="text-[13px] text-slate-600 leading-relaxed">
                {!! nl2br(e($offre['description'])) !!}
            </div>
        </div>

        <!-- Responsabilités -->
        <div class="bg-white border border-slate-100 rounded-[2.5rem] p-8 shadow-sm space-y-6">
            <h3 class="text-lg font-black text-slate-900 tracking-tight">Vos responsabilités</h3>
            <ul class="space-y-4">
                @foreach(explode('|', $offre['responsabilites'] ?? '') as $resp)
                    @if(trim($resp))
                        <li class="flex gap-4 items-start">
                            <span class="size-6 bg-indigo-50 text-indigo-600 rounded-full flex items-center justify-center shrink-0 mt-0.5">
                                <svg class="size-3.5" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"/></svg>
                            </span>
                            <span class="text-[12px] text-slate-600 leading-relaxed">{{ trim($resp) }}</span>
                        </li>
                    @endif
                @endforeach
            </ul>
        </div>

        <!-- Profil Recherché -->
        <div class="bg-white border border-slate-100 rounded-[2.5rem] p-8 shadow-sm space-y-6">
            <h3 class="text-lg font-black text-slate-900 tracking-tight">Profil recherché</h3>
            <div class="grid gap-4">
                @foreach(explode('|', $offre['profil_recherche'] ?? '') as $profil)
                    @if(trim($profil))
                        <div class="flex gap-4 items-start">
                            <div class="size-2 bg-indigo-600 rounded-full mt-2 shrink-0 shadow-lg shadow-indigo-200"></div>
                            <span class="text-[12px] text-slate-600 leading-relaxed">{{ trim($profil) }}</span>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>

        <!-- Compétences Techniques -->
        @if(isset($offre['competences_techniques']) && count((array)$offre['competences_techniques']) > 0)
        <div class="bg-white border border-slate-100 rounded-[2.5rem] p-8 shadow-sm space-y-6">
            <h3 class="text-lg font-black text-slate-900 tracking-tight">Compétences Techniques</h3>
            <div class="flex flex-wrap gap-3">
                @foreach((array)$offre['competences_techniques'] as $skill)
                    <span class="py-2 px-4 bg-indigo-50/50 text-[10px] font-bold text-indigo-700 rounded-xl border border-indigo-100">
                        {{ $skill }}
                    </span>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Company Banner -->
        <div class="bg-indigo-900 rounded-[2.5rem] p-8 shadow-2xl relative overflow-hidden text-white">
            <div class="absolute -top-10 -right-10 opacity-10 rotate-12">
                <svg class="size-48 text-white" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
            </div>
            <div class="relative z-10 space-y-6">
                <div class="flex items-center gap-4">
                    <div class="size-12 bg-white rounded-2xl flex items-center justify-center shadow-lg p-2 shrink-0">
                        @if(isset($offre['entreprise']['user']['photo']))
                            <img src="{{ str_replace('/api', '', env('VITE_API_URL')) }}/storage/{{ $offre['entreprise']['user']['photo'] }}" class="size-8 object-contain">
                        @else
                            <span class="text-indigo-600 font-bold text-lg">{{ substr($offre['entreprise']['nom_entreprise'] ?? 'S', 0, 1) }}</span>
                        @endif
                    </div>
                    <h3 class="text-xs font-bold uppercase tracking-widest">{{ $offre['entreprise']['nom_entreprise'] ?? 'L\'ENTREPRISE' }}</h3>
                </div>
                <p class="text-[11px] text-indigo-100 leading-relaxed font-medium">
                    {{ Str::limit($offre['entreprise']['bio'] ?? 'Expert en innovation technologique.', 150) }}
                </p>
                <a href="#" class="inline-flex items-center gap-2 text-[10px] font-bold text-white hover:text-indigo-200 transition uppercase tracking-widest">
                    Voir le profil
                    <svg class="size-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
