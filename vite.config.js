import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'

// https://vitejs.dev/config/
export default defineConfig({
  build: {
    outDir: 'vendor/orchestra/testbench-core/laravel/public'
  },
  plugins: [vue()],

})
