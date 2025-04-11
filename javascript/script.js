import Alpine from 'alpinejs';
import { initImageSlider } from './layouts/image-slider.js';
import { initTestimonials } from './layouts/testimonials.js';
import { initMarquee } from './layouts/marquee.js';
import { initLogoGrid } from './layouts/logo-grid.js';

window.Alpine = Alpine;

Alpine.start();

initImageSlider();
initTestimonials();
initMarquee();
initLogoGrid();