const SPEED = 1;

export const initMarquee = () => {
	let frame = null;
	let listeners = null;
	let paused = false;
	let dragging = false;
	let startX = 0;
	let startScroll = 0;

	return {
		init() {
			const track = this.$refs.track;
			const originals = track.children.length;

			if (!originals) return;

			// Fill at least twice the visible width, then mirror the whole strip
			// so wrapping back at half the scroll width is invisible.
			const source = track.innerHTML;
			let guard = 0;

			while (track.scrollWidth < track.clientWidth * 2 && guard < 20) {
				track.insertAdjacentHTML('beforeend', source);
				guard++;
			}

			track.insertAdjacentHTML('beforeend', track.innerHTML);

			// Everything past the real logos is decoration: hide it from
			// assistive tech and take the cloned links out of the tab order.
			Array.from(track.children).forEach((child, index) => {
				if (index < originals) return;

				child.setAttribute('aria-hidden', 'true');
				child
					.querySelectorAll('a')
					.forEach((link) => link.setAttribute('tabindex', '-1'));
			});

			const wrap = () => {
				const cycle = track.scrollWidth / 2;

				if (track.scrollLeft >= cycle) {
					track.scrollLeft -= cycle;
				} else if (track.scrollLeft <= 0) {
					track.scrollLeft += cycle;
				}
			};

			const step = () => {
				if (!paused && !dragging) {
					track.scrollLeft += SPEED;
					wrap();
				}

				frame = requestAnimationFrame(step);
			};

			listeners = new AbortController();
			const options = { signal: listeners.signal };

			if (
				window.matchMedia('(hover: hover) and (pointer: fine)').matches
			) {
				track.addEventListener(
					'mouseenter',
					() => (paused = true),
					options
				);
				track.addEventListener(
					'mouseleave',
					() => (paused = false),
					options
				);
			}

			// Pause while a logo link is focused so keyboard users can reach it.
			track.addEventListener('focusin', () => (paused = true), options);
			track.addEventListener('focusout', () => (paused = false), options);

			track.addEventListener(
				'mousedown',
				(event) => {
					dragging = true;
					startX = event.pageX;
					startScroll = track.scrollLeft;
					track.classList.add('cursor-grabbing');
				},
				options
			);

			track.addEventListener(
				'mousemove',
				(event) => {
					if (!dragging) return;

					event.preventDefault();
					track.scrollLeft = startScroll - (event.pageX - startX) * 2;
					wrap();
				},
				options
			);

			['mouseup', 'mouseleave'].forEach((name) => {
				track.addEventListener(
					name,
					() => {
						dragging = false;
						track.classList.remove('cursor-grabbing');
					},
					options
				);
			});

			track.addEventListener(
				'touchstart',
				(event) => {
					dragging = true;
					startX = event.touches[0].pageX;
					startScroll = track.scrollLeft;
				},
				{ ...options, passive: true }
			);

			track.addEventListener(
				'touchmove',
				(event) => {
					if (!dragging) return;

					track.scrollLeft =
						startScroll - (event.touches[0].pageX - startX) * 2;
					wrap();
				},
				{ ...options, passive: true }
			);

			track.addEventListener(
				'touchend',
				() => (dragging = false),
				options
			);

			frame = requestAnimationFrame(step);
		},

		destroy() {
			cancelAnimationFrame(frame);
			listeners?.abort();
		},
	};
};
