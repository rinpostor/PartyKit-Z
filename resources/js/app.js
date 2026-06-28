import { createApp } from 'vue';
import AppNavbar from './components/AppNavbar.vue';

// Determine which page component to mount
const pageMap = {
    'home-app': () => import('./pages/HomePage.vue'),
    'packages-app': () => import('./pages/PackagesPage.vue'),
    'about-app': () => import('./pages/AboutPage.vue'),
    'consultation-app': () => import('./pages/ConsultationPage.vue'),
};

// Mount Navbar (always present)
const navbarEl = document.getElementById('vue-navbar');
if (navbarEl) {
    createApp(AppNavbar).mount('#vue-navbar');
}

// Mount page-specific app
for (const [id, importer] of Object.entries(pageMap)) {
    const el = document.getElementById(id);
    if (el) {
        importer().then(({ default: Component }) => {
            createApp(Component).mount(`#${id}`);
        });
        break;
    }
}
