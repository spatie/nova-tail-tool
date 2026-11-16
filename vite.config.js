import { defineConfig } from 'vite';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [vue()],
    build: {
        outDir: 'dist',
        lib: {
            entry: 'resources/js/tool.js',
            name: 'TailTool',
            cssFileName: 'tool',
            formats: ['iife'],
            fileName: () => 'js/tool.js',
        },
        rolldownOptions: {
            external: ['vue'],
            output: { globals: { vue: 'Vue' } },
        },
    },
});
