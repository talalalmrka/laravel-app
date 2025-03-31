import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/preview.js',
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
    server: {
        watch: {
            usePolling: true,
            interval: 1000 // Default is ~100ms; increasing reduces CPU usage
        }
    }
    /*server:{
      cors: true,
      watch: {
        usePolling: true,
        interval: 5000,
      }
    }*/
});
