import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import tailwindcss from "@tailwindcss/vite";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/js/app.js",
                "resources/js/pages/static-pages.js",
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
});
