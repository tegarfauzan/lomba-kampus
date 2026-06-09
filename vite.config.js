import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            // input: ['resources/css/app.css', 'resources/js/app.js'],
            input: ['build/assets/app-FnBGe-P1.css', 'build/assets/app-CpXTcIz4.js'],
            
            refresh: true,
        }),
    ],
});
