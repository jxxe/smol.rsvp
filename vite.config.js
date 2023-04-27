import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { svelte } from '@sveltejs/vite-plugin-svelte';
import * as sveltePreprocess from 'svelte-preprocess';

export default defineConfig({
    plugins: [
        laravel.default({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        svelte({
            preprocess: sveltePreprocess.default()
        }),
        // sveltePreprocess.typescript()
    ]
});
