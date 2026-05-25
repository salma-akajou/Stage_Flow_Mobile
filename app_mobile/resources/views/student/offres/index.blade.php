@extends('layouts.app')

@section('title', 'Catalogue des Offres - StageFlow Mobile')

@section('content')
<div class="min-h-screen pb-24 pt-14" x-data="offersCatalogue()" x-init="init()" x-cloak>
    <div class="sticky top-14 z-40 bg-white/80 backdrop-blur-xl border-b border-slate-100 px-6 py-4 space-y-4 shadow-sm">
        <div class="flex items-center justify-between">
            <h1 class="text-xl font-bold text-slate-900 tracking-tight text-left">Explorer les Offres</h1>
            <span class="py-1 px-3 bg-indigo-50 text-indigo-600 text-[10px] font-bold rounded-lg uppercase tracking-widest" x-text="count + ' offres'"></span>
        </div>

        <div class="relative group">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <svg class="size-4 text-slate-400 group-focus-within:text-indigo-600 transition-colors" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
            </div>
            <input type="text" 
                   x-model.debounce.500ms="search" 
                   placeholder="Rechercher un stage..." 
                   class="w-full py-3.5 pl-11 pr-4 bg-slate-50 border-transparent focus:bg-white focus:border-indigo-600 focus:ring-4 focus:ring-indigo-50 rounded-2xl text-xs font-medium placeholder:text-slate-400 transition-all outline-none">
        </div>

        <div class="flex gap-2 overflow-x-auto hide-scrollbar pb-1">
            <select x-model="filters.ville_id" class="flex-none py-2 px-4 bg-slate-100 border-none rounded-xl text-[10px] font-bold text-slate-600 outline-none focus:ring-2 focus:ring-indigo-200">
                <option value="">Toutes les Villes</option>
                <template x-for="v in villes" :key="v.id">
                    <option :value="v.id" x-text="v.nom"></option>
                </template>
            </select>

            <select x-model="filters.secteur" class="flex-none py-2 px-4 bg-slate-100 border-none rounded-xl text-[10px] font-bold text-slate-600 outline-none focus:ring-2 focus:ring-indigo-200">
                <option value="">Tous les Secteurs</option>
                <template x-for="s in secteurs" :key="s">
                    <option :value="s" x-text="s"></option>
                </template>
            </select>
        </div>
    </div>

    <div class="px-6 py-6 space-y-4">
        <template x-if="loading">
            <div class="space-y-4">
                <template x-for="i in 3">
                    <div class="bg-white border border-slate-100 rounded-3xl p-6 space-y-4 animate-pulse">
                        <div class="flex gap-4">
                            <div class="size-12 bg-slate-100 rounded-2xl"></div>
                            <div class="space-y-2 grow">
                                <div class="h-3 bg-slate-100 rounded w-3/4"></div>
                                <div class="h-2 bg-slate-100 rounded w-1/2"></div>
                            </div>
                        </div>
                        <div class="h-10 bg-slate-100 rounded-2xl w-full"></div>
                    </div>
                </template>
            </div>
        </template>

        <template x-if="!loading && offres.length === 0">
            <div class="flex flex-col items-center justify-center py-20 text-center space-y-4">
                <div class="size-20 bg-slate-50 rounded-full flex items-center justify-center text-3xl">🕊️</div>
                <div class="space-y-1">
                    <h3 class="text-sm font-bold text-slate-900">Aucune offre trouvée</h3>
                    <p class="text-xs text-slate-400">Essaie d'ajuster tes filtres de recherche.</p>
                </div>
                <button @click="resetFilters" class="text-[10px] font-black text-indigo-600 uppercase tracking-widest underline">Réinitialiser</button>
            </div>
<div x-data="offersCatalogue('{{ env('VITE_API_URL', 'http://10.0.2.2:8000/api') }}')" class="min-h-screen bg-slate-50 pb-32 pt-14">
    <!-- Header -->
    <div class="sticky top-14 z-50 bg-white/80 backdrop-blur-xl border-b border-slate-100 px-6 py-4 flex items-center justify-between">
        <h1 class="text-sm font-black text-slate-800 uppercase tracking-widest">Catalogue Stages</h1>
    </div>

    <!-- Search & Filters -->
    <div class="px-6 pt-8 space-y-6">
        <div class="relative w-full group">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-indigo-600 transition-colors">
                <svg class="size-4" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            </div>
            <input type="text" x-model="search" placeholder="Rechercher un stage (titre)..." 
                   class="w-full pl-11 pr-4 py-3.5 bg-white border border-slate-100 rounded-2xl text-xs font-medium focus:border-indigo-500 focus:ring-indigo-500 shadow-sm transition">
        </div>

        <div class="grid grid-cols-2 gap-3">
            <!-- Ville Filter -->
            <div class="relative">
                <select x-model="filters.ville_id" class="w-full py-3 px-4 bg-white border border-slate-100 rounded-xl text-xs font-bold text-slate-600 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm transition appearance-none">
                    <option value="">Toutes les Villes</option>
                    <template x-for="v in villes" :key="v.id">
                        <option :value="v.id" x-text="v.nom"></option>
                    </template>
                </select>
            </div>

            <!-- Secteur Filter -->
            <div class="relative">
                <select x-model="filters.secteur" class="w-full py-3 px-4 bg-white border border-slate-100 rounded-xl text-xs font-bold text-slate-600 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm transition appearance-none">
                    <option value="">Tous Secteurs</option>
                    <template x-for="s in secteurs" :key="s">
                        <option :value="s" x-text="s"></option>
                    </template>
                </select>
            </div>
        </div>
    </div>

    <!-- Catalogue List -->
    <div class="px-6 py-8">
        <div class="space-y-6">
            <template x-for="offre in offres" :key="offre.id">
                <div class="bg-white border border-slate-100 rounded-[2.5rem] p-6 shadow-xl shadow-slate-200/20 text-left flex flex-col">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="size-12 bg-slate-50 rounded-2xl border border-slate-100 flex items-center justify-center overflow-hidden shrink-0 shadow-inner">
                            <img :src="getStorageUrl(offre.entreprise?.logo)"
                                 class="size-8 object-contain"
                                 loading="lazy"
                                 onerror="this.style.display='none'; this.parentElement.querySelector('.fallback').style.display='flex'">
                            <span class="fallback text-indigo-600 font-bold text-xs hidden" x-text="getCompanyInitial(offre.entreprise)"></span>
                        </div>
                        <div class="min-w-0 text-left">
                            <h4 class="text-xs font-bold text-gray-800 truncate" x-text="offre.titre"></h4>
                            <p class="text-[9px] text-gray-400 font-bold uppercase tracking-widest truncate" x-text="(offre.entreprise?.nom_entreprise || 'STAGEFLOW') + ' • ' + (offre.ville?.nom || 'MAROC')"></p>
                        </div>
                    </div>
                    
                    <p class="text-[10px] text-gray-500 line-clamp-2 mb-4 leading-relaxed lowercase" x-text="offre.description"></p>
                    
                    <div class="flex flex-wrap gap-2 mb-6">
                        <span class="py-1 px-2.5 rounded-lg text-[9px] font-bold bg-indigo-50/50 text-indigo-700" x-text="offre.secteur || 'Digital'"></span>
                        <span class="py-1 px-2.5 rounded-lg text-[9px] font-bold bg-gray-100/50 text-gray-600" x-text="offre.duree || '6 mois'"></span>
                        <template x-if="offre.remuneration === 'Payé'">
                            <span class="inline-flex items-center py-0.5 px-2 rounded-full text-[9px] font-bold bg-green-100 text-green-800">Payé</span>
                        </template>
                    </div>

                    <div class="mt-auto flex items-center justify-between pt-4 border-t border-gray-50">
                        <span class="text-[9px] font-bold text-gray-400 italic" x-text="timeSince(offre.created_at)"></span>
                        <a :href="'/offres/' + offre.id" class="py-2 px-4 inline-flex items-center gap-x-2 text-xs font-bold rounded-lg bg-indigo-600 text-white hover:bg-indigo-700 transition shadow-lg shadow-indigo-100">Voir</a>
                    </div>
                </div>
            </template>

            <!-- Empty State -->
            <template x-if="!loading && offres.length === 0">
                <div class="py-12 text-center text-slate-400 font-bold uppercase tracking-widest text-xs">Aucune offre trouvée</div>
            </template>
        </div>

        <!-- Pagination -->
        <template x-if="totalPages > 1">
            <div class="mt-8 flex justify-center items-center gap-2">
                <button @click="goToPage(page - 1)" 
                        :disabled="page === 1"
                        :class="page === 1 ? 'opacity-30 cursor-not-allowed' : 'active:scale-95 bg-white border-slate-100 shadow-sm'"
                        class="size-10 rounded-xl flex items-center justify-center border transition-all text-slate-500">
                    <svg class="size-4" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path d="m15 18-6-6 6-6"/></svg>
                </button>
                <button @click="goToPage(page + 1)" 
                        :disabled="page === totalPages"
                        :class="page === totalPages ? 'opacity-30 cursor-not-allowed' : 'active:scale-95 bg-white border-slate-100 shadow-sm'"
                        class="size-10 rounded-xl flex items-center justify-center border transition-all text-slate-500">
                    <svg class="size-4" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path d="m9 18 6-6-6-6"/></svg>
                </button>
            </div>
        </template>
    </div>
</div>
@endsection
