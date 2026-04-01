@extends('layouts.app')

@section('title', 'Tableau de bord - StageFlow Mobile')

@section('content')
<div class="min-h-screen pb-24 space-y-6" 
     x-data="studentDashboard()" 
     x-init="init()">
    
    <!-- Skeleton Loading -->
    <template x-if="loading && !data.etudiant">
        <div class="flex flex-col items-center justify-center min-h-[60vh] space-y-4">
             <div class="size-12 border-4 border-indigo-600 border-t-transparent rounded-full animate-spin"></div>
             <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest animate-pulse">Chargement de ton univers...</p>
        </div>
    </template>


    <!-- Main Content -->
    <div x-show="!loading || data.etudiant" x-cloak class="space-y-6">
        
        <!-- Header / Banner --->
        <section class="px-6 pt-6">
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

        <!-- Stats Grid  -->
        <section class="px-6">
            <div class="grid grid-cols-2 gap-4">
                <!-- Candidatures -->
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
                <!-- Vues -->
                <div class="flex flex-col bg-white border border-gray-100 shadow-sm rounded-[2rem] p-5 active:border-indigo-200 transition">
                    <div class="flex items-center justify-between mb-3">
                        <p class="text-[9px] font-bold text-gray-400 uppercase tracking-widest">Vues Profil</p>
                        <div class="size-8 bg-emerald-50 text-emerald-600 rounded-lg flex items-center justify-center">
                            <svg class="size-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        </div>
                    </div>
                    <div class="font-bold text-2xl text-gray-800 tracking-tight" x-text="formatNumber(data.stats?.vues)"></div>
                </div>
                <!-- Retenues -->
                <div class="flex flex-col bg-white border border-gray-100 shadow-sm rounded-[2rem] p-5 active:border-indigo-200 transition">
                    <div class="flex items-center justify-between mb-3">
                        <p class="text-[9px] font-bold text-gray-400 uppercase tracking-widest">Retenues</p>
                        <div class="size-8 bg-amber-50 text-amber-600 rounded-lg flex items-center justify-center">
                            <svg class="size-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7"/></svg>
                        </div>
                    </div>
                    <div class="font-bold text-2xl text-gray-800 tracking-tight" x-text="formatNumber(data.stats?.retenues)"></div>
                </div>
                <!-- Favoris -->
                <div class="flex flex-col bg-white border border-gray-100 shadow-sm rounded-[2rem] p-5 active:border-indigo-200 transition">
                    <div class="flex items-center justify-between mb-3">
                        <p class="text-[9px] font-bold text-gray-400 uppercase tracking-widest">Favoris</p>
                        <div class="size-8 bg-rose-50 text-rose-600 rounded-lg flex items-center justify-center">
                            <svg class="size-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                        </div>
                    </div>
                    <div class="font-bold text-2xl text-gray-800 tracking-tight" x-text="formatNumber(data.stats?.favoris)"></div>
                </div>
            </div>
        </section>

        <!-- Recommended Offers  -->
        <section id="recommended-offers" class="space-y-4 overflow-hidden">
            <div class="px-6 flex justify-between items-center">
                <h3 class="text-lg font-bold text-gray-800 tracking-tight">Stages recommandés</h3>
                <a class="text-[10px] font-bold text-indigo-600 uppercase tracking-widest" href="{{ route('offres.index') }}">Tout voir</a>
            </div>

            <div class="flex gap-4 overflow-x-auto px-6 hide-scrollbar pb-6">
                <template x-for="offre in (data.recommandations || [])" :key="offre.id">
                    <div class="min-w-[280px] group flex flex-col bg-white border border-gray-100 shadow-xl shadow-indigo-100/30 rounded-3xl p-6 transition text-left">
                        <div class="flex items-center gap-x-4 mb-4">
                            <div class="size-12 bg-gray-50 flex items-center justify-center rounded-2xl border border-gray-100 shrink-0 overflow-hidden">
                                <template x-if="offre.entreprise?.user?.photo">
                                    <img :src="'{{ str_replace('/api', '', env('VITE_API_URL')) }}/storage/' + (offre.entreprise.user.photo || offre.entreprise.logo)" class="size-8 object-contain">
                                </template>
                                <template x-if="!offre.entreprise?.user?.photo">
                                     <span class="text-indigo-600 font-bold text-xs" x-text="(offre.entreprise?.nom_entreprise || 'S').substring(0, 1)"></span>
                                </template>
                            </div>
                            <div class="min-w-0">
                                <h4 class="text-sm font-bold text-gray-800 truncate" x-text="offre.titre"></h4>
                                <p class="text-[9px] text-gray-400 font-bold uppercase tracking-widest truncate" x-text="(offre.entreprise?.nom_entreprise || 'STAGEFLOW') + ' • ' + (offre.ville?.nom || 'MAROC')"></p>
                            </div>
                        </div>
                        <p class="text-[11px] text-gray-600 line-clamp-2 mb-4 leading-relaxed lowercase" x-text="offre.description"></p>
                        <div class="flex flex-wrap gap-2 mb-6">
                            <span class="py-1 px-2.5 rounded-lg text-[9px] font-bold bg-indigo-50 text-indigo-700" x-text="offre.secteur || 'Digital'"></span>
                            <span class="py-1 px-2.5 rounded-lg text-[9px] font-bold bg-gray-100 text-gray-600" x-text="offre.duree || '6 mois'"></span>
                            <template x-if="offre.remuneration === 'Payé'">
                                <span class="inline-flex items-center gap-1.5 py-0.5 px-2 rounded-full text-[9px] font-bold bg-green-100 text-green-800">Payé</span>
                            </template>
                            <template x-if="offre.remuneration !== 'Payé'">
                                <span class="inline-flex items-center gap-1.5 py-0.5 px-2 rounded-full text-[9px] font-bold bg-red-100 text-red-800">Non-payé</span>
                            </template>
                        </div>
                        <div class="mt-auto flex items-center justify-between pt-4 border-t border-gray-50">
                            <span class="text-[10px] font-bold text-gray-400 italic" x-text="timeSince(offre.created_at)"></span>
                            <a :href="'/offres/' + offre.id" class="py-2 px-4 inline-flex items-center gap-x-2 text-xs font-bold rounded-lg bg-indigo-600 text-white hover:bg-indigo-700 transition shadow-lg shadow-indigo-100">Voir Détails</a>
                        </div>
                    </div>
                </template>
            </div>
        </section>

        <!-- Recent Candidatures -->
        <section class="px-6 space-y-4">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-bold text-gray-800 tracking-tight">Candidatures Récentes</h3>
                <a href="{{ route('student.candidatures', ['id' => 1]) }}" class="text-[10px] font-bold text-indigo-600 uppercase tracking-widest">Tout voir</a>
            </div>
            <div class="bg-white border border-gray-100 shadow-sm rounded-[2.5rem] p-6 space-y-6">
                <template x-for="cand in (data.candidatures_recentes || [])" :key="cand.id">
                    <div class="flex items-center gap-x-4 pb-4 border-b border-gray-50 last:border-0 last:pb-0">
                        <div class="size-10 bg-gray-50 flex-none flex items-center justify-center rounded-xl border border-gray-100 overflow-hidden">
                             <template x-if="cand.offre?.entreprise?.user?.photo">
                                <img :src="'{{ str_replace('/api', '', env('VITE_API_URL')) }}/storage/' + cand.offre.entreprise.user.photo" class="size-6 object-contain">
                             </template>
                             <template x-if="!cand.offre?.entreprise?.user?.photo">
                                <span class="text-indigo-600 font-bold text-[10px]" x-text="(cand.offre?.entreprise?.nom_entreprise || 'S').substring(0, 1)"></span>
                             </template>
                        </div>
                        <div class="grow min-w-0 text-left">
                            <h4 class="text-xs font-bold text-gray-800 truncate" x-text="cand.offre?.titre || 'Stage'"></h4>
                            <p class="text-[9px] text-gray-400 font-bold uppercase tracking-widest truncate" x-text="cand.offre?.entreprise?.nom_entreprise || 'StageFlow'"></p>
                        </div>
                        <div class="flex-none">
                            <span class="py-1 px-2.5 text-[8px] font-black uppercase tracking-widest rounded-lg"
                                :class="getStatusClass(cand.statut)" x-text="cand.statut"></span>
                        </div>
                    </div>
                </template>
                <template x-if="(data.candidatures_recentes || []).length === 0">
                    <p class="text-center py-6 text-gray-400 italic text-[10px] items-center">Aucune candidature récente.</p>
                </template>
            </div>
        </section>

    </div>
</div>

<script>
    function studentDashboard() {
        return {
            loading: true,
            data: {},
            error: false,
            errorMsg: '',
            studentId: 1, 
            apiUrl: '{{ env('VITE_API_URL') }}',

            init() {
                this.fetchData();
            },

            async fetchData() {
                this.loading = true;
                this.error = false;
                try {
                    let response = await fetch(`${this.apiUrl}/student/${this.studentId}/dashboard`);
                    if (!response.ok) throw new Error('Données indisponibles');
                    const json = await response.json();
                    if (json.success) {
                        this.data = json.data;
                    } else {
                        throw new Error(json.message);
                    }
                } catch (e) {
                    this.error = true;
                    this.errorMsg = "Connexion à StageFlow impossible 📡";
                } finally {
                    this.loading = false;
                }
            },

            formatNumber(num) {
                if (!num && num !== 0) return '00';
                return num < 10 ? `0${num}` : num;
            },

            getStatusClass(statut) {
                const s = (statut || '').toLowerCase();
                if (s.includes('accept')) return 'bg-emerald-100 text-emerald-800';
                if (s.includes('refus')) return 'bg-rose-100 text-rose-800';
                return 'bg-amber-100 text-amber-800';
            },

            timeSince(date) {
                if (!date) return 'Récemment';
                const seconds = Math.floor((new Date() - new Date(date)) / 1000);
                let interval = seconds / 31536000;
                if (interval > 1) return 'il y a ' + Math.floor(interval) + " ans";
                interval = seconds / 2592000;
                if (interval > 1) return 'il y a ' + Math.floor(interval) + " mois";
                interval = seconds / 86400;
                if (interval > 1) return 'il y a ' + Math.floor(interval) + " jours";
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
