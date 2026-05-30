export default (apiUrl, studentId, initialData, token) => ({
    loading: initialData ? false : true,
    favoris: initialData?.data || [],
    total: initialData?.total || 0,
    page: 1,
    totalPages: initialData?.last_page || 1,
    apiUrl: apiUrl || 'http://10.0.2.2:8000/api',
    studentId: studentId || 1,
    token: token || '',

    init() {
        if (!initialData) {
            this.fetchData();
        }
    },

    async fetchData() {
        this.loading = true;
        try {
            let response = await fetch(`${this.apiUrl}/student/${this.studentId}/favoris?page=${this.page}`, {
                headers: {
                    'Authorization': `Bearer ${this.token}`,
                    'Accept': 'application/json'
                }
            });
            let json = await response.json();
            if (json.success) {
                this.favoris    = json.data.data;
                this.total      = json.data.total;
                this.totalPages = json.data.last_page;
            }
        } catch (e) {
            console.error('Erreur fetch favoris', e);
        } finally {
            this.loading = false;
        }
    },

    async toggleFavori(offreId) {
        try {
            let response = await fetch(`${this.apiUrl}/student/${this.studentId}/favoris/${offreId}/toggle`, {
                method: 'POST',
                headers: {
                    'Authorization': `Bearer ${this.token}`,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            });
            let json = await response.json();
            if (json.success && !json.favoris) {
                // Retiré des favoris → supprimer localement
                this.favoris = this.favoris.filter(f => f.id !== offreId);
                this.total = Math.max(0, this.total - 1);
            }
        } catch (e) {
            console.error('Erreur toggle favori', e);
        }
    },

    goToPage(p) {
        if (p < 1 || p > this.totalPages) return;
        this.page = p;
        this.fetchData();
        window.scrollTo({ top: 0, behavior: 'smooth' });
    },

    getPagesRange() {
        let range = [];
        for (let i = 1; i <= this.totalPages; i++) range.push(i);
        return range;
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
        return `${baseUrl}/storage/${path}`;
    },

    getCompanyInitial(entreprise) {
        if (!entreprise || !entreprise.nom_entreprise) return 'S';
        return entreprise.nom_entreprise.substring(0, 1).toUpperCase();
    }
});
