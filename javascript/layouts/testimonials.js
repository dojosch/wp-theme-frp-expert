import Glide from '@glidejs/glide';

export const initTestimonials = () => {
    const glide = document.querySelectorAll('.ds-testimonials--glider');

    glide.forEach((glideElement) => {
        const glider = new Glide(glideElement, {
            type: 'carousel',
            perView: 1,
            gap: 0,
            autoplay: 8000,
        });

        glider.mount();
    });
}