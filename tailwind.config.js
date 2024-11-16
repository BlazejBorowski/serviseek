import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: "selector",
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./resources/js/**/*.tsx",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ["Figtree", ...defaultTheme.fontFamily.sans],
            },
            colors: {
                // Pallete 1
                // color1: "#F4F6FF",
                // color2: "#F3C623",
                // color3: "#EB8317",
                // color4: "#10375C",
                // Pallete 2
                // color1: "#FF6500",
                // color2: "#1E3E62",
                // color3: "#0B192C",
                // color4: "#000000",
                // Pallete 3
                // color1: "#EEEEEE",
                // color2: "#686D76",
                // color3: "#373A40",
                // color4: "#DC5F00",
                // Pallete 4
                // color1: "#222831",
                // color2: "#31363F",
                // color3: "#76ABAE",
                // color4: "#EEEEEE",
                // Pallete 5
                // color1: "#384B70",
                // color2: "#507687",
                // color3: "#FCFAEE",
                // color4: "#B8001F",
            },
        },
    },

    plugins: [forms],
};
