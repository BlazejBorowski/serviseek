import url from "node:url";
import eslint from "@eslint/js";
import tseslint from "typescript-eslint";
import prettierConfig from "eslint-config-prettier";

const __dirname = url.fileURLToPath(new URL(".", import.meta.url));

export default tseslint.config(
    {
        files: ["**/*.ts", "**/*.tsx"],
    },
    {
        ignores: [
            "**/node_modules/**",
            "**/vendor/**",
            "**/storage/**",
            "**/public/**",
        ],
    },
    eslint.configs.recommended,
    ...tseslint.configs.recommended,
    prettierConfig,
    {
        languageOptions: {
            parserOptions: {
                projectService: true,
                tsconfigRootDir: __dirname,
            },
        },
    }
);
