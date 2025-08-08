import { defineConfig } from 'vite';
import { resolve } from 'path';
import autoprefixer from 'autoprefixer';

export default defineConfig({
  server: {
    host: '0.0.0.0',
    port: 3000,
    hmr: {
      host: 'localhost',
      port: 3000,
    },
    cors: true,
    watch: {
      usePolling: true,
      interval: 1000
    }
  },

  build: {
    outDir: 'dist',
    emptyOutDir: true,
    manifest: true,
    watch: process.env.NODE_ENV === 'development' ? {} : null,
    rollupOptions: {
      input: {
        main: resolve(__dirname, 'assets/js/main.ts'),
        style: resolve(__dirname, 'assets/scss/style.scss'),
        admin: resolve(__dirname, 'assets/js/admin.ts')
      },
      output: {
        entryFileNames: 'js/[name].[hash].js',
        chunkFileNames: 'js/[name].[hash].js',
        assetFileNames: (assetInfo) => {
          if (assetInfo.name && assetInfo.name.endsWith('.css')) {
            return 'css/[name].[hash][extname]';
          }
          return 'assets/[name].[hash][extname]';
        }
      }
    }
  },

  // plugins: [
  //   {
  //     name: 'wordpress-hmr',
  //     handleHotUpdate({ file, server }) {
  //       if (file.includes('.scss')) {
  //         server.ws.send({
  //           type: 'full-reload'
  //         });
  //       }
  //     }
  //   }
  // ],

  css: {
    preprocessorOptions: {
      scss: {
        additionalData: `
          @import "./assets/scss/abstracts/variables";
          @import "./assets/scss/abstracts/mixins";
        `
      }
    },
    postcss: {
      plugins: [
        autoprefixer
      ]
    }
  },

  resolve: {
    alias: {
      '@': resolve(__dirname, 'assets')
    }
  }
});
