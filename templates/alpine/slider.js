import Swiper from 'swiper';
import { Navigation } from 'swiper/modules';

const DESKTOP_BREAKPOINT = 1024;

export const initSlider = () => {
	// Kept out of the returned object so Alpine's reactive proxy never wraps the Swiper instance.
	let swiper = null;

	return {
		init() {
			swiper = new Swiper(this.$refs.slider, {
				modules: [Navigation],
				slidesPerView: 1.15,
				spaceBetween: 20,
				navigation: {
					prevEl: this.$refs.prev,
					nextEl: this.$refs.next,
					disabledClass: 'ds-slider-nav--disabled',
				},
				breakpoints: {
					// From lg up the slider stays active and shows three slides at once.
					[DESKTOP_BREAKPOINT]: {
						slidesPerView: 3,
						spaceBetween: 30,
					},
				},
			});
		},

		destroy() {
			swiper?.destroy();
			swiper = null;
		},
	};
};
