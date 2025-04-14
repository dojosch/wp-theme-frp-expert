export const initMarquee = () => {
    const SPEED = 1;
    const containers = document.querySelectorAll('.ds-marquee');
    containers.forEach((container) => {
        if (!container) return;

        const direction = container.getAttribute('data-direction');

        const content = container.children[0];
        if (!content) return;

        const clone = content.cloneNode(true);
        container.append(clone);
        container.append(clone);


        let position = 0;

        const animate = () => {
            if(direction == 'left') {
                if (position >= content.clientWidth) {
                    position = direction == 'left' ? 0 : -content.clientWidth;
                }
                container.style.marginLeft = `-${position}px`;
            } else {
                if (position >= 0) {
                    position = -content.clientWidth;
                }
    
                container.style.marginLeft = `${position}px`;
            }

            position += SPEED;
            requestAnimationFrame(animate);
        };

        animate();
    })
};