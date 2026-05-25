@extends('layouts.app')

@section('title', 'Tableau de bord - StageFlow Mobile')

@section('content')
<div class="min-h-screen pb-24 space-y-6" 
     x-data="studentDashboard()" 
     x-init="init()">
    <template x-if="loading && !data.etudiant">
        <div class="flex flex-col items-center justify-center min-h-[60vh] space-y-4">
             <div class="size-12 border-4 border-indigo-600 border-t-transparent rounded-full animate-spin"></div>
             <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest animate-pulse">Chargement de ton univers...</p>
        </div>
    </template>


    <div x-show="!loading || data.etudiant" x-cloak class="space-y-6 pt-14">
        <section class="px-6">
            <div class="bg-indigo-950 rounded-[2.5rem] p-8 relative overflow-hidden shadow-2xl shadow-indigo-100/50">
                <div class="relative z-10 space-y-4 text-left">
                    <div class="mb-6">
                        <h1 class="text-2xl font-bold text-white tracking-tight">Bonjour, <span x-text="data.etudiant?.user?.prenom || 'Étudiant'"></span> 👋</h1>
                        <p class="text-indigo-300 text-[10px] font-medium mt-1 uppercase tracking-widest">
                            <span x-text="data.etudiant?.filiere || 'Filière'"></span> - <span x-text="data.etudiant?.etablissement || 'Établissement'"></span>
                        </p>
                    </div>
                    <h2 class="text-3xl font-black text-white leading-tight tracking-tight">Propulse ton potentiel avec StageFlow.</h2>
                    <p class="text-indigo-200 text-xs leading-relaxed max-w-[90%]">Trouve le stage de tes rêves parmi des centaines d'opportunités adaptées à ton profil.</p>
                    <div class="flex gap-3 pt-4">
                        <a href="{{ route('offres.index') }}" class="py-3 px-6 bg-white text-indigo-950 text-[10px] font-bold rounded-xl uppercase tracking-widest">Explorer</a>
                        <a href="#recommended-offers" class="py-3 px-6 border border-white/20 text-white text-[10px] font-bold rounded-xl uppercase tracking-widest">Recommandations</a>
                    </div>
                </div>
                <div class="absolute -bottom-10 -right-10 opacity-10 rotate-12">
                    <svg class="size-48 text-white" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24">
                        <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5" />
                    </svg>
                </div>
            </div>
        </section>

        <section class="px-6">
            <div class="grid grid-cols-2 gap-4">
                <div class="flex flex-col bg-white border border-gray-100 shadow-sm rounded-[2rem] p-5 active:border-indigo-200 transition">
                    <div class="flex items-center justify-between mb-3">
                        <p class="text-[9px] font-bold text-gray-400 uppercase tracking-widest">Candidatures</p>
                        <div class="size-8 bg-indigo-50 text-indigo-600 rounded-lg flex items-center justify-center">
                            <svg class="size-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        </div>
                    </div>
                    <div class="flex items-center gap-x-2">
                        <h3 class="text-2xl font-bold text-gray-800 tracking-tight" x-text="formatNumber(data.stats?.candidatures)"></h3>
                        <span class="text-emerald-500 text-[8px] font-bold">+15%</span>
                    </div>
                </div>
                <div class="flex flex-col bg-white border border-gray-100 shadow-sm rounded-[2rem] p-5 active:border-indigo-200 transition">
                    <div class="flex items-center justify-between mb-3">
                        <p class="text-[9px] font-bold text-gray-400 uppercase tracking-widest">Vues Profil</p>
                        <div class="size-8 bg-emerald-50 text-emerald-600 rounded-lg flex items-center justify-center">
                            <svg class="size-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        </div>
                    </div>
                    <div class="font-bold text-2xl text-gray-800 tracking-tight" x-text="formatNumber(data.stats?.vues)"></div>
                </div>
                <div class="flex flex-col bg-white border border-gray-100 shadow-sm rounded-[2rem] p-5 active:border-indigo-200 transition">
                    <div class="flex items-center justify-between mb-3">
                        <p class="text-[9px] font-bold text-gray-400 uppercase tracking-widest">Retenues</p>
                        <div class="size-8 bg-amber-50 text-amber-600 rounded-lg flex items-center justify-center">
                            <svg class="size-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"/></svg>
                        </div>
                    </div>

        <!-- Recommandations -->
        <section class="space-y-4">
            <h3 class="text-lg font-bold text-gray-800 tracking-tight flex items-center gap-2 text-left">
                <span class="size-2 bg-indigo-500 rounded-full animate-ping"></span>
                Recommandés pour vous
            </h3>
            
            <div class="flex gap-4 overflow-x-auto pb-4 hide-scrollbar">
                <template x-for="offre in (data.recommandations || [])" :key="offre.id">
                    <div class="bg-white border border-gray-100 shadow-xl shadow-gray-200/20 rounded-[2.5rem] p-6 w-72 shrink-0 flex flex-col text-left">
                        <div class="flex items-center gap-4 mb-4">
                            <div class="size-12 bg-gray-50 flex items-center justify-center rounded-2xl border border-gray-100 overflow-hidden shadow-inner shrink-0">
                                <img :src="getStorageUrl(offre.entreprise?.logo)"
                                     class="size-8 object-contain"
                                     loading="lazy"
                                     onerror="this.style.display='none'; this.parentElement.querySelector('.fallback').style.display='flex'">
                                <span class="fallback text-indigo-600 font-bold text-xs hidden" x-text="getCompanyInitial(offre.entreprise)"></span>
                            </div>
                            <div class="min-w-0">
                                <h4 class="text-sm font-bold text-gray-800 truncate" x-text="offre.titre"></h4>
                                <p class="text-[9px] text-gray-400 font-bold uppercase tracking-widest truncate" x-text="(offre.entreprise?.nom_entreprise || 'STAGEFLOW') + ' • ' + (offre.ville?.nom || 'MAROC')"></p>
                            </div>
                        </div>
                        <p class="text-[11px] text-gray-600 line-clamp-2 mb-4 leading-relaxed lowercase" x-text="offre.description"></p>
                        <div class="mt-auto flex items-center justify-between pt-4 border-t border-gray-50">
                            <span class="text-[10px] font-bold text-gray-400 italic" x-text="timeSince(offre.created_at)"></span>
                            <a :href="'/offres/' + offre.id" class="py-2 px-4 inline-flex items-center gap-x-2 text-xs font-bold rounded-lg bg-indigo-600 text-white hover:bg-indigo-700 transition shadow-lg shadow-indigo-100">Voir</a>
                        </div>
                    </div>
                </template>
            </div>
        </section>

    </div>
</div>
@endsection
