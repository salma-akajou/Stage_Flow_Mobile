export default (apiUrl, studentId, initialData, token) => ({
    loading: initialData ? false : true,
    data: initialData || {},
    error: false,
    errorMsg: '',
    studentId: studentId || 1, 
    apiUrl: apiUrl || 'http://10.0.2.2:8000/api',
    token: token || '',

    init() {
        if (!initialData) {
            this.fetchData();
        }
    },

    async fetchData() {
        this.loading = true;
        this.error = false;
        try {
            console.log('Fetching from:', `${this.apiUrl}/student/${this.studentId}/dashboard`);
            let response = await fetch(`${this.apiUrl}/student/${this.studentId}/dashboard`, {
                headers: {
                    'Authorization': `Bearer ${this.token}`,
                    'Accept': 'application/json'
                }
            });
            console.log('Response status:', response.status);
            if (!response.ok) throw new Error('Données indisponibles');
            const json = await response.json();
            console.log('API Response:', json);
            if (json.success) {
                this.data = json.data;
                console.log('Stats:', this.data.stats);
                console.log('Recommandations:', this.data.recommandations);
            } else {
                throw new Error(json.message);
            }
        } catch (e) {
            console.error('Fetch error:', e);
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
