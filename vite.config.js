import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import react from "@vitejs/plugin-react";
import fg from "fast-glob";

const pageInputs = fg.sync("resources/js/Pages/**/index.tsx");

export default defineConfig({
    plugins: [
        laravel({
            input: ["resources/js/app.tsx", ...pageInputs],
            ssr: "resources/js/ssr.tsx",
            refresh: true,
        }),
        react(),
    ],
});
