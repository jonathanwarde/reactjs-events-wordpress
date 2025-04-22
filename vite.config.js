// vite.config.js
import { defineConfig } from "vite";
import react      from "@vitejs/plugin-react";
import path       from "path";
import liveReload from "vite-plugin-live-reload";

export default defineConfig(({ mode }) => ({
  plugins: [
    react(),
    liveReload([ '**/*.php' ]),
  ],

  base: mode === 'development'
    ? '/web/'   // <-- so dev assets live under /web/
    : '/wp-content/themes/topsecret-4/dist/',

  server: {
    host: 'localhost',
    port: 3000,
    strictPort: true,
    watch: { usePolling: true },
    https: false,           // HTTP only
  },

  build: {
    outDir:      'dist',
    emptyOutDir: true,
    manifest:    true,
    rollupOptions: {
      input: {
        reactevents: path.resolve(__dirname, "src/vitereacttopsecretevents.jsx"),
        app: path.resolve(__dirname, "src/app.js"),
        styles: path.resolve(__dirname, "src/css/vite.css"),
        sitestyles: path.resolve(__dirname, "src/scss/sitestyles.scss"),
      },
      output: {
        assetFileNames: 'assets/[name].[hash].[ext]',
      }
    }
  },

  css: {
    preprocessorOptions: {
      sass: {
        additionalData: `@import "./src/styles/variables.scss";`
      }
    }
  }
}));
