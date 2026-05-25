export default (apiUrl) => ({
    loading: true,
    data: {},
    apiUrl: apiUrl || 'http://10.0.2.2:8000/api',

    init() {
        this.fetchData();
    },

    async fetchData() {
        this.loading = true;
        try {
            console.log('Landing API URL:', `${this.apiUrl}/landing`);
            const response = await fetch(`${this.apiUrl}/landing`);
            console.log('Landing response status:', response.status);
            const json = await response.json();
            console.log('Landing API data:', json);
            if (json.success) {
                this.data = json.data;
                console.log('Stats:', this.data.stats);
                console.log('Feedbacks:', this.data.feedbacks);
            } else {
                console.error('API returned error:', json.message);
            }
        } catch (e) {
            console.error("Erreur API landing:", e);
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
    },

    getPhotoUrl(path) {
        if (!path) return '';
        const baseUrl = this.apiUrl.replace('/api', '');
        const url = `${baseUrl}/storage/${path}`;
        console.log('Photo URL:', url);
        return url;
    },

    getInitials(auteur) {
        if (!auteur) return 'U';
        if (auteur.prenom && auteur.nom) {
            return (auteur.prenom[0] + auteur.nom[0]).toUpperCase();
        }
        return (auteur.prenom || 'U')[0].toUpperCase();
    }
});
