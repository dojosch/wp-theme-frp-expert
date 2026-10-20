import Alpine from 'alpinejs';
import { initNavigation } from './alpine/navigation';
import { initPopup } from './alpine/popup';
import { initContentSlider } from './alpine/content-slider';

document.addEventListener('alpine:init', () => {
	// Alpine.data('dsFunction', dsFunction);
	Alpine.data('dsNavigation', initNavigation);
	Alpine.data('dsContentSlider', initContentSlider);
});

window.Alpine = Alpine;
Alpine.start();

initPopup();
