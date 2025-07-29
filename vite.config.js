import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/css/frontend.css', // [+] Tambahkan ini
                'resources/js/frontend.js',   // [+] Tambahkan ini
            ],
            refresh: true,
        }),
    ],
    define: {
        global: 'globalThis',
    },
    server: {
        host: '127.0.0.1',
        port: 5173,
        hmr: {
            host: '127.0.0.1',
        },
    },
    resolve: {
        alias: {
            '@': '/resources/js',
        },
    },
    optimizeDeps: {
        include: ['crypto-js']
    },
    build: {
        rollupOptions: {
            external: ['crypto']
        }
    }
});
