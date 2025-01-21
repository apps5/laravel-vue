import { defineConfig } from 'vite';
import vue from '@vitejs/plugin-vue';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/js/app.js', 'resources/css/app.css'],
            refresh: true,
        }),
        vue(),
    ],
    server: {
      host: '0.0.0.0', // Listen on all interfaces
      port: 5173, // Default Vite port
      strictPort: true, // Fail if the port is already in use
      hmr: {
          host: 'localhost', // Set the HMR (Hot Module Reloading) host
      },
    },
});
