import { defineConfig } from 'vite'
import path from 'path'
import babel from 'vite-plugin-babel'

export default defineConfig({
	root: path.resolve(__dirname),

	plugins: [
		babel({
			babelConfig: {
				plugins: ['@babel/plugin-transform-flow-strip-types'],
			},
			filter: /src\/.*\.(js|jsx)$/,
		}),
	],

	resolve: {
		alias: {
			vue: 'vue/dist/vue.esm-bundler.js',

			'@css': path.resolve(__dirname, 'src/css'),
			'@application': path.resolve(__dirname, 'src/application'),
			'@layout': path.resolve(__dirname, 'src/layout'),
			'@component': path.resolve(__dirname, 'src/component'),
			'@const': path.resolve(__dirname, 'src/const'),
			'@lib': path.resolve(__dirname, 'src/lib'),
			'@model': path.resolve(__dirname, 'src/model'),
			'@provider': path.resolve(__dirname, 'src/provider'),
			'@service': path.resolve(__dirname, 'src/provider/service'),
			'@pull': path.resolve(__dirname, 'src/provider/pull'),
		},
	},
	server: {
		host: 'localhost',
		port: 5173,
		strictPort: true,
		cors: true
	},
	build: {
		outDir: path.resolve(__dirname, '../kernel'),
		assetsDir: 'assets',
		emptyOutDir: false,
		manifest: true,
		base: '/',
		rollupOptions: {
			input: {
				main: path.resolve(__dirname, 'src/application/main.js'),
				test: path.resolve(__dirname, 'src/application/test.js'),
			},
		},
	},
})