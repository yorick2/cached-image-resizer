import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'


// https://vitejs.dev/config/
export default defineConfig({
    build: {
        outDir: 'vendor/orchestra/testbench-core/laravel/public'
    },
    plugins: [vue()],
    server: {
        proxy: {
            // with options: http://localhost:5173/api/bar-> http://jsonplaceholder.typicode.com/bar
            '/pm-image-resizer': {
                target: 'http://localhost:8000',
                changeOrigin: true,
                rewrite: (path) => path.replace(/^\/pm-image-resizer/, '/pm-image-resizer'),
            },
        },
    },
})
