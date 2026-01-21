import Glide from "@glidejs/glide";

export const initLogoGrid = () => {
    const gliders = document.querySelectorAll('.ds-logo-grid--glider');

    gliders.forEach(glider => {
        const glide = new Glide(glider, {
            autoplay: 3000,
            hoverpause: false,
            perView: 1,
        });

        glide.mount();
    });
}