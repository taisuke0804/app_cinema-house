import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],

    server: {
      host: '0.0.0.0', // コンテナ内で動作させる
      port: 5173,      // ポート番号を明示
      hmr: {
        host: 'localhost', // ブラウザアクセス用のホスト名
      },
    },
});
