export default (apiUrl) => ({
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
    apiUrl: apiUrl || 'http://10.0.2.2:8000/api',

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
