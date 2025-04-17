import { defineConfig } from "vite";
import react from "@vitejs/plugin-react";
import path from "path";

export default defineConfig({
  plugins: [
    react()
  ],
  build: {
    rollupOptions: {
      input: {
        reactevents: path.resolve(__dirname, "src/vitereacttopsecretevents.jsx"),  
        style1: path.resolve(__dirname, "src/scss/vitetest.scss"),  
      },
      output: {
        // Output multiple CSS files based on entry points
        assetFileNames: 'assets/[name].[ext]',
      }
    }
  },
  css: {
    preprocessorOptions: {
      sass: {
        additionalData: `@import "./src/styles/variables.scss";` // Global Sass imports
      }
    }
  }
});
