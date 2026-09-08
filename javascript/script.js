import Alpine from 'alpinejs';
import { initNavigation } from './alpine/navigation';
import { initPopup } from './alpine/popup';

document.addEventListener('alpine:init', () => {
    // Alpine.data('dsFunction', dsFunction);
    Alpine.data('dsNavigation', initNavigation);
});

window.Alpine = Alpine;
Alpine.start();

initPopup();