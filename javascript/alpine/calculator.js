const currencyFormat = new Intl.NumberFormat('de-DE', {
	minimumFractionDigits: 2,
	maximumFractionDigits: 2,
});

export const initCalculator = (config = {}) => {
	return {
		active: 0,
		modes: config.modes ?? [],

		// Slider position between min and max as 0–1, drives the fill and thumb.
		progress(slider) {
			const range = slider.max - slider.min;
			return range > 0 ? (slider.value - slider.min) / range : 0;
		},

		// Placeholder until the calculation logic exists: the values from the design.
		// Read the inputs from this.modes[this.active].sliders (by `key`) once it does.
		get results() {
			return { cost: 825, comparison: 5500, savings: 4675 };
		},

		formatCurrency(value) {
			return `€ ${currencyFormat.format(value)}`;
		},
	};
};
