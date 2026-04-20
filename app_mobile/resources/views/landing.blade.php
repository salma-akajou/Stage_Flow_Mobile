@extends('layouts.app')

@section('title', 'StageFlow - Accueil Premium')

@section('content')
<div x-data="landingPage()" x-init="init()">
    <!-- Hero Section Mobile -->
    <section class="relative min-h-[70vh] flex items-center px-6 pt-16 pb-24 overflow-hidden">
        <!-- Background Hero Image -->
        <div class="absolute inset-0 z-0">
            <img src="https://i.pinimg.com/1200x/e0/1e/8c/e01e8c03de998fc0aa35b45fafd88cea.jpg" 
                 alt="Hero background" 
                 class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-b from-slate-900/60 via-slate-900/40 to-slate-50"></div>
        </div>

        <div class="relative z-10 space-y-6 w-full text-left">
            <div class="inline-flex items-center gap-x-2 py-1.5 px-4 rounded-full bg-white/20 backdrop-blur-md border border-white/30">
                <span class="size-2 rounded-full bg-indigo-400 animate-pulse"></span>
                <span class="text-[10px] font-bold text-white uppercase tracking-widest">StageFlow Premium</span>
            </div>

            <h1 class="text-4xl font-black text-white leading-tight tracking-tight">
                Propulsez votre <br>
                <span class="text-indigo-400">avenir</span> professionnel.
            </h1>

            <p class="text-sm text-slate-200 max-w-xs leading-relaxed font-medium">
                La plateforme marocaine de référence pour connecter les étudiants ambitieux.
            </p>

            <div class="pt-6">
                <a href="{{ route('student.dashboard', ['id' => 1]) }}" class="w-full py-4 px-8 inline-flex items-center justify-center gap-x-2 text-sm font-bold rounded-2xl bg-indigo-600 text-white shadow-2xl shadow-indigo-500/20 active:scale-95 transition-transform leading-none">
                    Trouver mon stage
                    <svg class="size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
                </a>
            </div>
        </div>
    </section>

    <!-- Statistiques Complètes  -->
    <section class="py-12 px-6 -mt-12 relative z-20">
        <div class="grid grid-cols-2 gap-4">
            <div class="p-6 rounded-3xl bg-white shadow-xl shadow-slate-200/50 border border-slate-100 flex flex-col items-center text-center">
                <span class="text-2xl font-black text-slate-900 leading-none mb-1" x-text="(data.stats?.partenaires || 350) + '+'"></span>
                <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">Partenaires</span>
            </div>
            <div class="p-6 rounded-3xl bg-white shadow-xl shadow-slate-200/50 border border-slate-100 flex flex-col items-center text-center">
                <span class="text-2xl font-black text-slate-900 leading-none mb-1" x-text="data.stats?.offres_an || '15k'"></span>
                <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">Offres</span>
            </div>
            <div class="p-6 rounded-3xl bg-white shadow-xl shadow-slate-200/50 border border-slate-100 flex flex-col items-center text-center">
                <span class="text-2xl font-black text-emerald-600 leading-none mb-1" x-text="formatSatisfaction(data.stats?.satisfaction)"></span>
                <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">Satisfaction</span>
            </div>
            <div class="p-6 rounded-3xl bg-white shadow-xl shadow-slate-200/50 border border-slate-100 flex flex-col items-center text-center">
                <span class="text-2xl font-black text-indigo-600 leading-none mb-1" x-text="data.stats?.rep_moyenne || '48h'"></span>
                <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">Réponse</span>
            </div>
        </div>
    </section>

    <!-- Expérience StageFlow -->
    <section class="py-12 px-6 space-y-12 bg-white rounded-t-[3rem]">
        <div class="text-center space-y-3 pt-6">
            <h2 class="text-2xl font-black text-slate-900 tracking-tight">Expérience StageFlow</h2>
            <p class="text-xs text-slate-500 max-w-[280px] mx-auto leading-relaxed uppercase tracking-wider">Notre algorithme propriétaire analyse votre profil pour vous suggérer les offres qui correspondent réellement à vos ambitions.</p>
        </div>

        <div class="space-y-4">
            <div class="p-6 rounded-[2.5rem] bg-indigo-50/50 border border-indigo-100 flex gap-5 items-start">
                <div class="size-12 rounded-2xl bg-white shadow-sm flex items-center justify-center shrink-0 text-xl">🔍</div>
                <div class="space-y-1 text-left">
                    <h3 class="font-bold text-slate-900 text-sm">Matching Intelligent</h3>
                    <p class="text-[11px] text-slate-500 leading-relaxed">Gérez vos candidatures, suivez les retours des recruteurs et organisez vos entretiens depuis un tableau de bord immersif.</p>
                </div>
            </div>
            <div class="p-6 rounded-[2.5rem] bg-emerald-50/50 border border-emerald-100 flex gap-5 items-start">
                <div class="size-12 rounded-2xl bg-white shadow-sm flex items-center justify-center shrink-0 text-xl">✨</div>
                <div class="space-y-1 text-left">
                    <h3 class="font-bold text-slate-900 text-sm">Postulez en 1-Clic</h3>
                    <p class="text-[11px] text-slate-500 leading-relaxed">Gérez vos candidatures, suivez les retours des recruteurs et organisez vos entretiens depuis un tableau de bord immersif.</p>
                </div>
            </div>
            <div class="p-6 rounded-[2.5rem] bg-amber-50/50 border border-amber-100 flex gap-5 items-start">
                <div class="size-12 rounded-2xl bg-white shadow-sm flex items-center justify-center shrink-0 text-xl text-left">💎</div>
                <div class="space-y-1 text-left">
                    <h3 class="font-bold text-slate-900 text-sm">Réseau Elite</h3>
                    <p class="text-[11px] text-slate-500 leading-relaxed text-left">Accédez à des opportunités exclusives chez les leaders du marché technologique au Maroc..</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimoniaux -->
    <section class="py-16 bg-slate-50 relative overflow-hidden">
        <div class="px-6 relative z-10 space-y-8">
            <h2 class="text-2xl font-black text-slate-900 text-center tracking-tight">Ils nous font confiance</h2>
            <div class="space-y-4">
                <template x-for="feedback in (data.feedbacks || [])" :key="feedback.id">
                    <div class="bg-white p-6 rounded-[2.5rem] shadow-sm border border-slate-100 text-left">
                        <p class="text-slate-600 text-xs leading-relaxed mb-4 italic text-left" x-text="'&quot;' + feedback.texte + '&quot;'"></p>
                        <div class="flex items-center gap-3">
                            <div class="size-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold overflow-hidden shadow-inner text-sm" x-text="(feedback.auteur?.prenom || 'U').substring(0, 1)">
                            </div>
                            <div class="text-left">
                                <h4 class="font-bold text-slate-900 text-[11px] text-left" x-text="getFullName(feedback.auteur)"></h4>
                                <p class="text-[9px] text-slate-400 font-bold uppercase tracking-widest text-left" x-text="getAuthorType(feedback.auteur)"></p>
                            </div>
                        </div>
                    </div>
                </template>
                <template x-if="!loading && (data.feedbacks || []).length === 0">
                    <div class="text-center py-8 text-slate-400 text-sm font-bold uppercase tracking-widest">Rejoignez l'aventure StageFlow</div>
                </template>
            </div>
        </div>
    </section>

    <!-- FAQ Spéciale Étudiant -->
    <section class="py-16 px-6 bg-white" x-data="{ active: null }">
        <h2 class="text-2xl font-black text-slate-900 mb-10 text-center tracking-tight">Questions fréquentes</h2>
        <div class="space-y-3">
            <template x-for="(faq, index) in [
                {q: 'Comment postuler ?', a: 'Uploadez votre CV et postulez en un clic sur l\'offre de votre choix.'},
                {q: 'Est-ce que l\'application est gratuite ?', a: 'Oui, StageFlow est totalement gratuit pour tous les étudiants et stagiaires.'},
                {q: 'Candidature retenue ?', a: 'Vous recevrez une notification instantanée dès qu\'un recruteur change le statut de votre candidature.'},
                {q: 'Modifier mon profil ?', a: 'Oui, vous pouvez mettre à jour vos compétences et votre CV à tout moment depuis votre espace profil.'}
            ]" :key="index">
                <div class="border border-slate-100 rounded-[2rem] overflow-hidden shadow-sm transition-all duration-300" :class="active === index ? 'border-indigo-200 bg-indigo-50/20' : ''">
                    <button @click="active = active === index ? null : index" class="w-full py-5 px-6 flex justify-between items-center text-left">
                        <span class="text-[13px] font-bold text-slate-800" x-text="faq.q"></span>
                        <svg class="size-4 text-slate-400 transition-transform duration-300" :class="active === index ? 'rotate-180 text-indigo-600' : ''" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><path d="m6 9 6 6 6-6"/></svg>
                    </button>
                    <div x-show="active === index" x-collapse x-cloak>
                        <div class="px-6 pb-6 text-[11px] text-slate-500 leading-relaxed text-left" x-text="faq.a"></div>
                    </div>
                </div>
            </template>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-12 px-6">
        <div class="bg-indigo-600 rounded-[3rem] p-10 text-center shadow-2xl shadow-indigo-200 relative overflow-hidden">
            <h2 class="text-3xl font-black text-white mb-8 leading-tight relative z-10 tracking-tight text-left">Prêt à décrocher <br>votre futur stage ?</h2>
            <a href="{{ route('student.dashboard', ['id' => 1]) }}" class="w-full py-5 bg-white text-indigo-600 font-black rounded-2xl text-xs shadow-xl active:scale-95 transition-transform relative z-10 block text-center leading-none uppercase">
                Créer mon compte maintenant
            </a>
            <div class="absolute -top-12 -right-12 size-40 bg-white/10 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-12 -left-12 size-40 bg-indigo-400/20 rounded-full blur-3xl"></div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-10 text-center">
        <p class="text-[9px] text-slate-400 uppercase font-black tracking-[0.3em]">© 2026 StageFlow Maroc</p>
    </footer>
</div>

<script>
    function landingPage() {
        return {
            loading: true,
            data: {},
            apiUrl: '{{ env('VITE_API_URL', 'http://10.0.2.2:8000/api') }}',

            init() {
                this.fetchData();
            },

            async fetchData() {
                this.loading = true;
                try {
                    const response = await fetch(`${this.apiUrl}/landing`);
                    const json = await response.json();
                    if (json.success) {
                        this.data = json.data;
                    }
                } catch (e) {
                    console.error("Erreur API landing", e);
                } finally {
                    this.loading = false;
                }
            },

            getFullName(user) {
                if (!user) return 'Anonyme';
                return (user.prenom || '') + ' ' + (user.nom || '');
            },

            getAuthorType(user) {
                if (!user) return 'Utilisateur StageFlow';
                if (user.entreprise) return 'Entreprise Partenaire';
                if (user.etudiant) return 'Candidat StageFlow';
                return 'Utilisateur StageFlow';
            },

            formatSatisfaction(val) {
                if (!val) return '5%';
                return Math.round(val) + '%';
            }
        }
    }
</script>
@endsection
