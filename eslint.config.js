// eslint.config.js
import eslintPluginImport from 'eslint-plugin-import';

export default [
	{
		ignores: ['theme/dist/**', 'node_modules/**'],
		files: ['**/*.js'],
		languageOptions: {
			ecmaVersion: 'latest',
			sourceType: 'module',
			globals: {
				wp: 'readonly',
				jQuery: 'readonly',
				alpine: 'readonly',
			},
		},
		plugins: {
			import: eslintPluginImport,
		},
		rules: {
			'no-console': 'warn',
			'no-unused-vars': 'warn',
		},
	},
];
this;
