@extends('layouts.app')

@section('title', 'Mes Candidatures - StageFlow Mobile')

@section('content')
<div class="min-h-screen bg-slate-50 pb-24" x-data="suiviCandidatures()" x-init="init()" x-cloak>
    
    <!-- Header -->
    <div class="bg-white border-b border-slate-100 px-6 py-8 space-y-6">
        <div class="flex flex-col gap-2">
            <h2 class="text-2xl font-black text-slate-800 tracking-tight text-left">Mes Candidatures</h2>
            <p class="text-xs text-slate-500 text-left leading-relaxed">Suivez l'état d'avancement de vos demandes de stage en temps réel.</p>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-2 gap-3">
            <div class="flex flex-col bg-white border border-slate-100 shadow-sm rounded-2xl p-4 text-left">
                <p class="text-[9px] uppercase tracking-widest text-slate-400 font-bold">Total Candidatures</p>
                <h3 class="text-xl font-black text-slate-800 mt-2" x-text="stats.total">0</h3>
            </div>
            <div class="flex flex-col bg-white border border-amber-100 shadow-sm rounded-2xl p-4 text-left">
                <p class="text-[9px] uppercase tracking-widest text-amber-500 font-bold">En attente</p>
                <h3 class="text-xl font-black text-slate-800 mt-2" x-text="stats.attente">0</h3>
            </div>
            <div class="flex flex-col bg-white border border-emerald-100 shadow-sm rounded-2xl p-4 text-left">
                <p class="text-[9px] uppercase tracking-widest text-emerald-500 font-bold">Acceptées</p>
                <h3 class="text-xl font-black text-slate-800 mt-2" x-text="stats.accepte">0</h3>
            </div>
            <div class="flex flex-col bg-white border border-rose-100 shadow-sm rounded-2xl p-4 text-left">
                <p class="text-[9px] uppercase tracking-widest text-rose-500 font-bold">Refusées</p>
                <h3 class="text-xl font-black text-slate-800 mt-2" x-text="stats.refuse">0</h3>
            </div>
        </div>

        <!-- Search & Filter -->
        <div class="flex flex-col gap-3">
            <div class="relative w-full">
                <div class="absolute inset-y-0 start-0 flex items-center ps-4 pointer-events-none">
                    <svg class="size-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
                <input type="text" x-model="search"
                    class="py-3 ps-11 pe-4 block w-full border-slate-100 bg-slate-50 rounded-xl text-xs font-medium focus:border-indigo-500 focus:ring-indigo-500 outline-none transition"
                    placeholder="Chercher entreprise ou poste...">
            </div>

            <select x-model="statutFilter"
                class="py-3 px-4 pe-9 block w-full border-slate-100 bg-slate-50 rounded-xl text-xs font-bold text-slate-700 focus:border-indigo-500 focus:ring-indigo-500 outline-none border-none">
                <option value="">Tous les statuts</option>
                <option value="En attente">En attente</option>
                <option value="Accepté">Accepté</option>
                <option value="Refusé">Refusé</option>
            </select>
        </div>
    </div>

    <!-- Liste des Candidatures -->
    <div class="px-6 py-6 space-y-4">
        
        <!-- Loading -->
        <template x-if="loading">
            <div class="space-y-4">
                <template x-for="i in 3">
                    <div class="h-28 bg-white border border-slate-100 rounded-[2rem] animate-pulse shadow-sm"></div>
                </template>
            </div>
        </template>

        <!-- No Results -->
        <template x-if="!loading && filteredCandidatures.length === 0">
            <div class="bg-white border-2 border-dashed border-slate-200 rounded-[2.5rem] p-12 text-center">
                <div class="size-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="size-8 text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <h3 class="text-base font-black text-slate-800">Aucune candidature</h3>
                <p class="text-xs text-slate-400 mt-2 leading-relaxed">Explorez nos offres et postulez pour lancer votre carrière !</p>
                <a href="{{ route('offres.index') }}" class="mt-6 inline-flex items-center gap-x-2 py-3.5 px-8 text-xs font-black rounded-2xl bg-indigo-600 text-white shadow-xl shadow-indigo-100 uppercase tracking-widest active:scale-95 transition">
                    Voir le catalogue
                </a>
            </div>
        </template>

        <!-- List Cards -->
        <div class="space-y-4">
            <template x-for="c in filteredCandidatures" :key="c.id">
                <div class="bg-white border border-slate-100 rounded-[2.5rem] p-5 shadow-sm hover:shadow-md transition active:scale-[0.98]">
                    <div class="flex gap-4">
                        <!-- Logo -->
                        <div class="shrink-0 size-14 bg-indigo-50 flex justify-center items-center rounded-2xl border border-indigo-100 overflow-hidden shadow-inner">
                            <template x-if="c.offre?.entreprise?.user?.photo">
                                <img :src="'{{ str_replace('/api', '', env('VITE_API_URL')) }}/storage/' + c.offre.entreprise.user.photo" class="size-10 object-contain">
                            </template>
                            <template x-if="!c.offre?.entreprise?.user?.photo">
                                <span class="text-indigo-600 font-black text-xl" x-text="(c.offre?.entreprise?.nom_entreprise || 'S').substring(0,1)"></span>
                            </template>
                        </div>
                        
                        <!-- Details -->
                        <div class="grow min-w-0 text-left">
                            <h4 class="font-black text-slate-800 text-[13px] leading-tight mb-2 truncate" x-text="c.offre?.titre || 'Offre supprimée'"></h4>
                            <div class="flex items-center gap-x-2 text-[10px] text-slate-400 font-bold uppercase tracking-widest truncate">
                                <span x-text="c.offre?.entreprise?.nom_entreprise || 'Inconnu'"></span>
                                <span>•</span>
                                <span x-text="c.offre?.ville?.nom || 'Maroc'"></span>
                            </div>
                        </div>
                    </div>

                    <!-- Footer Card -->
                    <div class="mt-5 pt-5 border-t border-slate-50 flex items-center justify-between">
                        <div class="flex flex-col gap-1.5">
                            <span :class="getStatusClasses(c.statut)" class="inline-flex items-center gap-1.5 py-1.5 px-3 rounded-full text-[10px] font-black uppercase tracking-wider">
                                <span class="size-1.5 rounded-full" :class="getStatusDot(c.statut)"></span>
                                <span x-text="c.statut"></span>
                            </span>
                            <p class="text-[9px] text-slate-400 italic font-bold" x-text="'Postulé ' + timeSince(c.created_at)"></p>
                        </div>
                        
                        <a :href="'/offres/' + c.offre_id" class="size-10 bg-slate-50 border border-slate-100 rounded-xl flex items-center justify-center text-slate-400 active:text-indigo-600 active:bg-indigo-50 transition shadow-sm">
                            <svg class="size-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        </a>
                    </div>
                </div>
            </template>
        </div>
    </div>
</div>

<script>
    function suiviCandidatures() {
        return {
            loading: true,
            candidatures: [],
            stats: { total: 0, attente: 0, accepte: 0, refuse: 0 },
            search: '',
            statutFilter: '',
            apiUrl: '{{ env('VITE_API_URL') }}',
            etudiantId: {{ $etudiantId ?? 1 }}, 

            init() {
                this.fetchData();
            },

            async fetchData() {
                this.loading = true;
                try {
                    let response = await fetch(`${this.apiUrl}/student/${this.etudiantId}/candidatures`);
                    let json = await response.json();
                    if (json.success) {
                        // Laravel Paginator : les données sont dans json.data.data
                        this.candidatures = json.data.data || [];
                        this.calculateStats(json.data.total); 
                    }
                } catch (e) {
                    console.error("Erreur fetch candidatures", e);
                } finally {
                    this.loading = false;
                }
            },

            calculateStats(total) {
                this.stats.total = total || this.candidatures.length;
                this.stats.attente = this.candidatures.filter(c => c.statut === 'En attente').length;
                this.stats.accepte = this.candidatures.filter(c => c.statut === 'Accepté').length;
                this.stats.refuse = this.candidatures.filter(c => c.statut === 'Refusé').length;
            },

            get filteredCandidatures() {
                return this.candidatures.filter(c => {
                    const matchesSearch = (c.offre?.titre || '').toLowerCase().includes(this.search.toLowerCase()) || 
                                         (c.offre?.entreprise?.nom_entreprise || '').toLowerCase().includes(this.search.toLowerCase());
                    const matchesStatut = this.statutFilter === '' || c.statut === this.statutFilter;
                    return matchesSearch && matchesStatut;
                });
            },

            getStatusClasses(s) {
                if (s === 'En attente') return 'bg-amber-50 text-amber-600';
                if (s === 'Accepté') return 'bg-emerald-50 text-emerald-600';
                if (s === 'Refusé') return 'bg-rose-50 text-rose-600';
                return 'bg-slate-50 text-slate-600';
            },

            getStatusDot(s) {
                if (s === 'En attente') return 'bg-amber-400';
                if (s === 'Accepté') return 'bg-emerald-500';
                if (s === 'Refusé') return 'bg-rose-500';
                return 'bg-slate-400';
            },

            timeSince(date) {
                if (!date) return 'Récemment';
                const seconds = Math.floor((new Date() - new Date(date)) / 1000);
                let interval = seconds / 31536000;
                if (interval > 1) return Math.floor(interval) + " ans";
                interval = seconds / 2592000;
                if (interval > 1) return Math.floor(interval) + " mois";
                interval = seconds / 86400;
                if (interval > 1) return "il y a " + Math.floor(interval) + " jours";
                interval = seconds / 3600;
                if (interval > 1) return "il y a " + Math.floor(interval) + " h";
                interval = seconds / 60;
                if (interval > 1) return "il y a " + Math.floor(interval) + " m";
                return "à l'instant";
            }
        }
    }
</script>
@endsection
