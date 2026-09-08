// browsersync.js
const dotenv = require('dotenv').config();
const browserSync = require('browser-sync').create();

browserSync.init({
  proxy:  process.env.BROWSERSYNC_PROXY || 'http://test.local', // Change to your local dev domain
  files: [
    './theme/**/*.php',
    './theme/**/*.css',
    './theme/**/*.js',
    './javascript/**/*.js',
    './styles/**/*.css',
  ],
  notify: true,
  open: false,
});
