import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue2'

export default defineConfig({
    plugins: [
        laravel({
            input: 'resources/js/app.js',
            // ssr: 'resources/js/ssr.js',
            detectTls: 'l11-inertia-vue2-boilerplate.test',
            refresh: true,
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
    ],
    resolve: {
        alias: {
            '~': '/resources/',
            '@': '/resources/js',
            'vue$': 'vue/dist/vue.runtime.esm.js',
        },
    },
});
