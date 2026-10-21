import Swiper from 'swiper';

export const initBlogSlider = () => {
	// Kept outside the reactive state so Alpine doesn't proxy the Swiper instance.
	let swiper = null;

	return {
		isBeginning: true,
		isEnd: false,

		init() {
			swiper = new Swiper(this.$refs.swiper, {
				speed: 600,
				slidesPerView: 1,
				spaceBetween: 10,
				breakpoints: {
					1024: { slidesPerView: 3 },
				},
				on: {
					afterInit: (instance) => this.update(instance),
					slideChange: (instance) => this.update(instance),
					resize: (instance) => this.update(instance),
				},
			});
		},
		update(instance) {
			this.isBeginning = instance.isBeginning;
			this.isEnd = instance.isEnd;
		},
		prev() {
			swiper?.slidePrev();
		},
		next() {
			swiper?.slideNext();
		},
	};
};
