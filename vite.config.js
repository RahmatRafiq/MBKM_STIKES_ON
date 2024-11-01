import { defineConfig } from 'vite'
import laravel from 'laravel-vite-plugin'
import react from '@vitejs/plugin-react'
import process from 'process'


export default defineConfig({
  plugins: [
    laravel({
      input: [
        'resources/css/app.css',
        'resources/js/app.js',
        'resources/js/dropzoner.js',
        'resources/js/react.tsx',
        'resources/css/react.css',
      ],
      refresh: true,
    }),
    react(),
  ],
  // no hashing output
  build: {
    // target esmodule
    target: 'esnext',
    rollupOptions: {
      output: {
        entryFileNames: 'js/[name].js',
        chunkFileNames: 'js/[name].js',
        assetFileNames: 'css/[name].css',
      }
    },
  },
  esbuild: {
    drop: process.env.APP_ENV === 'production' ? ['console', 'debugger'] : [],
  }
})
