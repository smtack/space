import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        laravel({
            input: 'resources/js/app.js',
            refresh: true,
        }),
        tailwindcss(),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ]
    /* For Laragon: */
    /* server: {
        cors: {
            origin: /^https?:\/\/(?:(?:[^:]+\.)?localhost|space\.test|127\.0\.0\.1|\[::1\])(?::\d+)?$/,
        },
    },*/
});
