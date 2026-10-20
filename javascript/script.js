import Alpine from 'alpinejs';
import { initNavigation } from './alpine/navigation';
import { initPopup } from './alpine/popup';
import { initContentSlider } from './alpine/content-slider';
import { initCalculator } from './alpine/calculator';

document.addEventListener('alpine:init', () => {
	// Alpine.data('dsFunction', dsFunction);
	Alpine.data('dsNavigation', initNavigation);
	Alpine.data('dsContentSlider', initContentSlider);
	Alpine.data('dsCalculator', initCalculator);
});

window.Alpine = Alpine;
Alpine.start();

initPopup();
