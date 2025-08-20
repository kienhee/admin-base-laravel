import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                //Common
                'resources/js/common/generate-slug.js',
                'resources/js/common/upload-image-alone.js',
                'resources/js/common/forms-selects.js',
                'resources/js/common/full-editor.js',
                //page
                'resources/js/pages/blog.js',
                'resources/js/pages/auth.js',
            ],
            refresh: true,
        }),
    ],
});
