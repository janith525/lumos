import {
    defineConfig
} from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from "@tailwindcss/vite";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/scss/frontend/app.scss',
                'resources/scss/frontend/pages/home.scss',
                'resources/scss/frontend/pages/about.scss',
                'resources/scss/frontend/pages/gallery.scss',
                'resources/scss/frontend/pages/contact.scss',
                'resources/scss/frontend/pages/services_listing.scss',
                'resources/scss/frontend/pages/service_detail.scss',
                'resources/scss/frontend/pages/product_detail.scss',
                'resources/scss/frontend/pages/auth.scss',
                'resources/js/app.js'
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
    server: {
        cors: true,
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});
