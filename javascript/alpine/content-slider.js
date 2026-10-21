import Swiper from 'swiper';

export const initContentSlider = () => {
	// Kept outside the reactive state so Alpine doesn't proxy the Swiper instance.
	let swiper = null;

	return {
		active: 0,

		init() {
			swiper = new Swiper(this.$refs.swiper, {
				speed: 600,
				rewind: true,
				on: {
					slideChange: (instance) => {
						this.active = instance.realIndex;
					},
				},
			});
		},
		prev() {
			swiper?.slidePrev();
		},
		next() {
			swiper?.slideNext();
		},
	};
};
