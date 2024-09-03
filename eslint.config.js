import globals from "globals";
import pluginJs from "@eslint/js";
import tseslint from "typescript-eslint";
import pluginReact from "eslint-plugin-react";


export default [
  {
    files: ["resources/**/*.{js,mjs,cjs,ts,jsx,tsx}"],
    ignores: ["node_modules/**", "vendor/**"],
  },
  { languageOptions: { globals: globals.browser } },
  {
    rules: {
      ...pluginJs.configs.recommended.rules,
      'no-empty-pattern': 'warn',
      'indent': ['warn', 2],
    }
  },
  ...tseslint.configs.recommended.map((config) => {
    return {
      ...config,
      rules: {
        ...config.rules,
        '@typescript-eslint/no-empty-object-type': 'off',
        '@typescript-eslint/no-unused-vars': 'warn',
        '@typescript-eslint/no-explicit-any': 'warn',
      }
    };
  }),
  {
    ...pluginReact.configs.flat.recommended,
    rules: {
      "react/jsx-uses-vars": "warn",
    }
  }
];
