export const initImageSlider = () => {
    const containers = document.querySelectorAll('.ds-image-slider');

    containers.forEach((container) => {
        const slider = container.querySelector('.ds-image-slider--slider');
        const cursor = container.querySelector('.ds-image-slider--cursor');

        // Duplicate content for seamless looping
        slider.innerHTML += slider.innerHTML;

        let isPaused = false;
        let isDragging = false;
        let startX, scrollLeft;
        const sliderSpeed = 1; // Adjust speed as needed

        // Cursor movement
        function moveCursor(e) {
            const sliderRect = slider.getBoundingClientRect();
            const offsetX = e.clientX - sliderRect.left;
            const offsetY = e.clientY - sliderRect.top;
            cursor.style.transform = `translate(${offsetX - 32}px, ${offsetY - 24}px)`;
        }

        // Show/hide cursor on hover for desktop only
        function updateCursorOnEnter() {
            cursor.classList.remove("hidden");
            cursor.classList.add("flex");
            isPaused = true;
        }

        function resetCursorOnLeave() {
            cursor.classList.remove("flex");
            cursor.classList.add("hidden");
            isPaused = false;
        }

        // Autoscroll animation
        function autoSlide() {
            if (!isPaused && !isDragging) {
                slider.scrollLeft += sliderSpeed;
                if (slider.scrollLeft >= slider.scrollWidth / 2) {
                    slider.scrollLeft = 0;
                }
            }
            requestAnimationFrame(autoSlide);
        }

        autoSlide();

        // Only show cursor on pointer devices (desktop)
        if (window.matchMedia("(hover: hover) and (pointer: fine)").matches) {
            slider.addEventListener("mousemove", moveCursor);
            slider.addEventListener("mouseenter", updateCursorOnEnter);
            slider.addEventListener("mouseleave", resetCursorOnLeave);
        }

        // Pause on focus (keyboard/screenreader users)
        slider.addEventListener('focusin', () => isPaused = true);
        slider.addEventListener('focusout', () => isPaused = false);

        // Drag scroll (desktop)
        slider.addEventListener('mousedown', (e) => {
            isDragging = true;
            startX = e.pageX - slider.offsetLeft;
            scrollLeft = slider.scrollLeft;
            slider.classList.add('active');
        });

        slider.addEventListener('mouseup', () => {
            isDragging = false;
            slider.classList.remove('active');
        });

        slider.addEventListener('mouseleave', () => {
            isDragging = false;
            slider.classList.remove('active');
        });

        slider.addEventListener('mousemove', (e) => {
            if (!isDragging) return;
            e.preventDefault();
            const x = e.pageX - slider.offsetLeft;
            const walk = (x - startX) * 2;
            slider.scrollLeft = scrollLeft - walk;
        });

        // Drag scroll (mobile touch)
        slider.addEventListener('touchstart', (e) => {
            isDragging = true;
            startX = e.touches[0].pageX - slider.offsetLeft;
            scrollLeft = slider.scrollLeft;
        });

        slider.addEventListener('touchend', () => {
            isDragging = false;
        });

        slider.addEventListener('touchmove', (e) => {
            if (!isDragging) return;
            const x = e.touches[0].pageX - slider.offsetLeft;
            const walk = (x - startX) * 2;
            slider.scrollLeft = scrollLeft - walk;
        });
    });
};
