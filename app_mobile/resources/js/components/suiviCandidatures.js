export default (apiUrl, etudiantId) => ({
    loading: true,
    candidatures: [],
    stats: { total: 0, attente: 0, accepte: 0, refuse: 0 },
    search: '',
    statutFilter: '',
    apiUrl: apiUrl || 'http://10.0.2.2:8000/api',
    etudiantId: etudiantId || 1, 

    init() {
        this.fetchData();
    },

    async fetchData() {
        this.loading = true;
        try {
            let response = await fetch(`${this.apiUrl}/student/${this.etudiantId}/candidatures`);
            let json = await response.json();
            if (json.success) {
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
    },

    getStorageUrl(path) {
        if (!path) return '';
        const baseUrl = this.apiUrl.replace('/api', '');
        const url = `${baseUrl}/storage/${path}`;
        console.log('Image URL:', url);
        return url;
    },

    getCompanyInitial(entreprise) {
        if (!entreprise || !entreprise.nom_entreprise) return 'S';
        return entreprise.nom_entreprise.substring(0, 1).toUpperCase();
    }
});
