import Alpine from 'alpinejs';
import { initNavigation } from './alpine/navigation';
import { initPopup } from './alpine/popup';
import { initContentSlider } from './alpine/content-slider';
import { initCalculator } from './alpine/calculator';
import { initBlogSlider } from './alpine/blog-slider';

document.addEventListener('alpine:init', () => {
	// Alpine.data('dsFunction', dsFunction);
	Alpine.data('dsNavigation', initNavigation);
	Alpine.data('dsContentSlider', initContentSlider);
	Alpine.data('dsCalculator', initCalculator);
	Alpine.data('dsBlogSlider', initBlogSlider);
});

window.Alpine = Alpine;
Alpine.start();

initPopup();
