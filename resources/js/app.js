import { createInertiaApp } from '@inertiajs/svelte';

createInertiaApp({
    progress: {
        color: '#4984EE'
    },
    resolve: name => {
        const pages = import.meta.glob('./Pages/**/*.svelte', { eager: true });
        const page = pages[`./Pages/${name}.svelte`];
        return {
            default: page.default,
            layout: page.layout ?? null
        }
    },
    setup({ el, App, props }) {
        new App({ target: el, props });
    }
});