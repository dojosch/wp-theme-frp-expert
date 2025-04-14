// browsersync.js
const browserSync = require('browser-sync').create();

browserSync.init({
  proxy: 'http://test.local', // Change to your local dev domain
  files: [
    './theme/**/*.php',
    './theme/**/*.css',
    './theme/**/*.js',
    './javascript/**/*.js',
    './tailwind/**/*.css',
  ],
  notify: true,
  open: false,
});
