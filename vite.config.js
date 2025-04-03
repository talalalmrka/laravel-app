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
    /*server:{
      cors: true,
      watch: {
        usePolling: true,
        interval: 5000,
      }
    }*/
});
