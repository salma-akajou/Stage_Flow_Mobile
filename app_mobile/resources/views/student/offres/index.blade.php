@extends('layouts.app')

@section('title', 'Catalogue des Offres - StageFlow Mobile')

@section('content')
<div class="min-h-screen pb-24" x-data="offersCatalogue()" x-init="init()" x-cloak>
    
    <!-- Header -->
    <div class="sticky top-0 z-40 bg-white/80 backdrop-blur-xl border-b border-slate-100 px-6 py-4 space-y-4 shadow-sm">
        <div class="flex items-center justify-between">
            <h1 class="text-xl font-bold text-slate-900 tracking-tight text-left">Explorer les Offres</h1>
            <span class="py-1 px-3 bg-indigo-50 text-indigo-600 text-[10px] font-bold rounded-lg uppercase tracking-widest" x-text="count + ' offres'"></span>
        </div>

        <!-- Barre de Recherche -->
        <div class="relative group">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <svg class="size-4 text-slate-400 group-focus-within:text-indigo-600 transition-colors" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
            </div>
            <input type="text" 
                   x-model.debounce.500ms="search" 
                   placeholder="Rechercher un stage..." 
                   class="w-full py-3.5 pl-11 pr-4 bg-slate-50 border-transparent focus:bg-white focus:border-indigo-600 focus:ring-4 focus:ring-indigo-50 rounded-2xl text-xs font-medium placeholder:text-slate-400 transition-all outline-none">
        </div>

        <!-- Filtres  -->
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

    <!-- Liste des Offres -->
    <div class="px-6 py-6 space-y-4">
        
        <!-- Loading skeletons -->
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

        <!-- No results -->
        <template x-if="!loading && offres.length === 0">
            <div class="flex flex-col items-center justify-center py-20 text-center space-y-4">
                <div class="size-20 bg-slate-50 rounded-full flex items-center justify-center text-3xl">🕊️</div>
                <div class="space-y-1">
                    <h3 class="text-sm font-bold text-slate-900">Aucune offre trouvée</h3>
                    <p class="text-xs text-slate-400">Essaie d'ajuster tes filtres de recherche.</p>
                </div>
                <button @click="resetFilters" class="text-[10px] font-black text-indigo-600 uppercase tracking-widest underline">Réinitialiser</button>
            </div>
        </template>

        <!-- Offres Grid -->
        <div class="grid gap-4">
            <template x-for="offre in offres" :key="offre.id">
                <div class="group flex flex-col bg-white border border-slate-100 shadow-xl shadow-slate-200/40 rounded-[2.5rem] p-6 active:scale-[0.98] transition-all text-left">
                    <div class="flex items-center gap-4 mb-5">
                        <div class="size-14 bg-slate-50 flex items-center justify-center rounded-2xl border border-slate-100 overflow-hidden shrink-0">
                            <template x-if="offre.entreprise?.user?.photo">
                                <img :src="'{{ str_replace('/api', '', env('VITE_API_URL')) }}/storage/' + offre.entreprise.user.photo" class="size-10 object-contain">
                            </template>
                            <template x-if="!offre.entreprise?.user?.photo">
                                <span class="text-indigo-600 font-bold text-xl" x-text="(offre.entreprise?.nom_entreprise || 'S').substring(0,1)"></span>
                            </template>
                        </div>
                        <div class="min-w-0 flex-1">
                            <h4 class="text-sm font-black text-slate-900 leading-tight truncate mb-1" x-text="offre.titre"></h4>
                            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest truncate" x-text="(offre.entreprise?.nom_entreprise || 'StageFlow') + ' • ' + (offre.ville?.nom || 'Maroc')"></p>
                        </div>
                    </div>

                    <p class="text-[11px] text-slate-600 leading-relaxed line-clamp-2 mb-6" x-text="offre.description"></p>

                    <div class="flex flex-wrap gap-2 mb-8">
                        <span class="py-1.5 px-3 rounded-xl text-[9px] font-bold bg-indigo-50 text-indigo-700" x-text="offre.secteur"></span>
                        <span class="py-1.5 px-3 rounded-xl text-[9px] font-bold bg-slate-50 text-slate-500" x-text="offre.duree"></span>
                        <template x-if="offre.remuneration === 'Payé'">
                            <span class="py-1.5 px-3 rounded-xl text-[9px] font-bold bg-emerald-50 text-emerald-700 uppercase tracking-wider">Payé</span>
                        </template>
                    </div>

                    <div class="mt-auto pt-6 border-t border-slate-50 flex items-center justify-between">
                        <span class="text-[9px] font-bold text-slate-400 italic" x-text="'Publié ' + timeSince(offre.created_at)"></span>
                        <a :href="'/offres/' + offre.id" class="py-3 px-6 bg-indigo-600 text-white text-[10px] font-black rounded-xl uppercase tracking-[0.1em] shadow-lg shadow-indigo-100 active:scale-95 transition-all">
                            Voir Détails
                        </a>
                    </div>
                </div>
            </template>
        </div>

        <!-- Pagination Numérotée -->
        <template x-if="totalPages > 1">
            <div class="flex items-center justify-center gap-1.5 pt-8">
                <button @click="goToPage(page - 1)" 
                        :disabled="page === 1"
                        :class="page === 1 ? 'opacity-30 cursor-not-allowed' : 'active:scale-95 bg-white border-slate-100 shadow-sm'"
                        class="size-10 rounded-xl flex items-center justify-center border transition-all text-slate-500">
                    <svg class="size-4" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><path d="m15 18-6-6 6-6"/></svg>
                </button>

                <template x-for="p in totalPages" :key="p">
                    <button @click="goToPage(p)"
                            :class="page === p ? 'bg-indigo-600 border-indigo-600 text-white shadow-lg shadow-indigo-100' : 'bg-white border-slate-100 text-slate-600'"
                            class="size-10 rounded-xl border flex items-center justify-center text-xs font-black transition-all"
                            x-text="p">
                    </button>
                </template>

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

<script>
    function offersCatalogue() {
        return {
            loading: true,
            offres: [],
            count: 0,
            page: 1,
            totalPages: 1,
            villes: [],
            secteurs: ['Informatique', 'Marketing', 'Finance', 'Design', 'Management', 'Ventes'],
            search: '',
            filters: {
                ville_id: '',
                secteur: ''
            },
            apiUrl: '{{ env('VITE_API_URL', 'http://10.0.2.2:8000/api') }}',

            init() {
                this.fetchFiltersData();
                this.fetchData();
                
                this.$watch('search', () => { this.page = 1; this.fetchData(); });
                this.$watch('filters.ville_id', () => { this.page = 1; this.fetchData(); });
                this.$watch('filters.secteur', () => { this.page = 1; this.fetchData(); });
            },

            async fetchFiltersData() {
                try {
                    let response = await fetch(`${this.apiUrl}/villes`);
                    let json = await response.json();
                    if (json.success) {
                        this.villes = json.data;
                    }
                } catch (e) {
                    console.error("Erreur fetch villes", e);
                }
            },

            async fetchData() {
                this.loading = true;
                try {
                    let params = new URLSearchParams({
                        titre: this.search,
                        secteur: this.filters.secteur,
                        ville_id: this.filters.ville_id,
                        page: this.page
                    });

                    let response = await fetch(`${this.apiUrl}/offres?${params.toString()}`);
                    let json = await response.json();
                    if (json.success) {
                        this.offres = json.data.data;
                        this.count = json.data.total;
                        this.totalPages = json.data.last_page;
                    }
                } catch (e) {
                    console.error("Erreur fetch offres", e);
                } finally {
                    this.loading = false;
                }
            },

            goToPage(p) {
                if (p < 1 || p > this.totalPages) return;
                this.page = p;
                this.fetchData();
                window.scrollTo({ top: 0, behavior: 'smooth' });
            },

            resetFilters() {
                this.search = '';
                this.filters.ville_id = '';
                this.filters.secteur = '';
            },

            timeSince(date) {
                if (!date) return 'Récemment';
                const seconds = Math.floor((new Date() - new Date(date)) / 1000);
                let interval = seconds / 31536000;
                if (interval > 1) return 'il y a ' + Math.floor(interval) + " ans";
                interval = seconds / 2592000;
                if (interval > 1) return 'il y a ' + Math.floor(interval) + " mois";
                interval = seconds / 86400;
                if (interval > 1) return 'il y a ' + Math.floor(interval) + " jrs";
                interval = seconds / 3600;
                if (interval > 1) return 'il y a ' + Math.floor(interval) + " h";
                interval = seconds / 60;
                if (interval > 1) return 'il y a ' + Math.floor(interval) + " min";
                return "à l'instant";
            }
        }
    }
</script>
@endsection
