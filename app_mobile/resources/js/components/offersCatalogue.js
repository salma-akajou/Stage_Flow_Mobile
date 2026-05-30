export default (apiUrl, studentId, authToken) => ({
    loading: true,
    offres: [],
    count: 0,
    page: 1,
    totalPages: 1,
    villes: [],
    secteurs: [],
    search: '',
    filters: {
        ville_id: '',
        secteur: ''
    },
    apiUrl: apiUrl || 'http://10.0.2.2:8000/api',
    studentId: studentId || null,
    authToken: authToken || '',
    favorisIds: [],

    init() {
        this.fetchFiltersData();
        this.fetchData();
        if (this.studentId && this.authToken) {
            this.fetchFavorisIds();
        }
        this.$watch('search', () => { this.page = 1; this.fetchData(); });
        this.$watch('filters.ville_id', () => { this.page = 1; this.fetchData(); });
        this.$watch('filters.secteur', () => { this.page = 1; this.fetchData(); });
    },

    async fetchFavorisIds() {
        try {
            let response = await fetch(`${this.apiUrl}/student/${this.studentId}/favoris/ids`, {
                headers: { 'Authorization': `Bearer ${this.authToken}`, 'Accept': 'application/json' }
            });
            let json = await response.json();
            if (json.success) this.favorisIds = json.data;
        } catch (e) {
            console.error('Erreur fetch favoris ids', e);
        }
    },

    isFavori(offreId) {
        return this.favorisIds.includes(offreId);
    },

    async toggleFavori(offreId) {
        if (!this.studentId || !this.authToken) return;
        // optimiste
        if (this.favorisIds.includes(offreId)) {
            this.favorisIds = this.favorisIds.filter(id => id !== offreId);
        } else {
            this.favorisIds.push(offreId);
        }
        try {
            await fetch(`${this.apiUrl}/student/${this.studentId}/favoris/${offreId}/toggle`, {
                method: 'POST',
                headers: { 'Authorization': `Bearer ${this.authToken}`, 'Accept': 'application/json' }
            });
        } catch (e) {
            console.error('Erreur toggle favori', e);
            // rollback
            await this.fetchFavorisIds();
        }
    },

    async fetchFiltersData() {
        try {
            let [villesRes, secteursRes] = await Promise.all([
                fetch(`${this.apiUrl}/villes`),
                fetch(`${this.apiUrl}/secteurs`)
            ]);
            let [villesJson, secteursJson] = await Promise.all([
                villesRes.json(),
                secteursRes.json()
            ]);
            if (villesJson.success) {
                this.villes = villesJson.data;
            }
            if (secteursJson.success) {
                this.secteurs = secteursJson.data;
            }
        } catch (e) {
            console.error("Erreur fetch filtres", e);
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
    },

    getPagesRange() {
        let range = [];
        for (let i = 1; i <= this.totalPages; i++) {
            range.push(i);
        }
        return range;
    }
});
