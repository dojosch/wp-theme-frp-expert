module.exports = {
	content: [
		'./theme/**/*.php',
		'./theme/**/*.js',
		'./styles/tailwind/**/*.css',
		'./javascript/**/*.js',
	],
	theme: {
		extend: {
			// your customizations
		},
	},
	plugins: [
		require('@tailwindcss/typography'),
		// any other plugins
	],
};
