import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
				'resources/js/admin/clients/index.js',
				'resources/js/admin/clients/show.js',
                'resources/js/admin/projects/index.js',
				'resources/js/admin/projects/create.js',
				'resources/js/admin/projects/show.js',
            ],
            refresh: true,
        }),
    ],
});
