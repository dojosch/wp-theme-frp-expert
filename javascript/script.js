import Alpine from 'alpinejs';
import { initImageSlider } from './layouts/image-slider.js';
import { initTestimonials } from './layouts/testimonials.js';


window.Alpine = Alpine;

Alpine.start();

initImageSlider();
initTestimonials();