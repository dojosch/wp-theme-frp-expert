export const initNavigation = () => {
	return {
		isSubmenuOpen: false,
		isScrolled: false,

		init() {
			this.handleScroll();
			window.addEventListener('scroll', () => this.handleScroll(), {
				passive: true,
			});
		},
		handleScroll() {
			this.isScrolled = window.scrollY > 0;
		},
	};
};
