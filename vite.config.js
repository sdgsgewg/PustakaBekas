import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            input: ["resources/css/app.css", "resources/js/app.js"], // Correct paths
            refresh: true,
        }),
    ],
    define: {
        "process.env.NODE_ENV": '"production"', // Explicitly define NODE_ENV for production
    },
    build: {
        mode: "production", // Set the mode to production for proper optimizations
    },
});
