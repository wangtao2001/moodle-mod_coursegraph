import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'
import { resolve } from 'path'

export default defineConfig({
  plugins: [vue()],
  define: {
    'process.env': process.env
  },
  build: {
    lib: {
      entry: resolve(__dirname, 'src/main.js'),
      name: 'coursegraph',
    },
    rollupOptions: {
      output: {
        dir: resolve(__dirname, '../amd/src'),
        entryFileNames: 'index.js',
        format: 'es',
        assetFileNames: 'index.[ext]'
      }
    }
  }
})
