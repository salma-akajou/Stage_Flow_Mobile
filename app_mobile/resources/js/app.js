import './bootstrap';
import 'preline';
import Alpine from 'alpinejs';
import collapse from '@alpinejs/collapse';

import landingPage from './components/landingPage';
import studentDashboard from './components/studentDashboard';
import suiviCandidatures from './components/suiviCandidatures';
import offersCatalogue from './components/offersCatalogue';
import loginPage from './components/loginPage';
import favorisPage from './components/favorisPage';
import registerPage from './components/registerPage';

window.Alpine = Alpine;
Alpine.plugin(collapse);

document.addEventListener('alpine:init', () => {
    Alpine.data('landingPage', landingPage);
    Alpine.data('studentDashboard', studentDashboard);
    Alpine.data('suiviCandidatures', suiviCandidatures);
    Alpine.data('offersCatalogue', offersCatalogue);
    Alpine.data('loginPage', loginPage);
    Alpine.data('favorisPage', favorisPage);
    Alpine.data('registerPage', registerPage);
});

Alpine.start();
