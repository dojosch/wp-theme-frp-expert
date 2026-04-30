export const initNavigation = () => {
    return {
        isSubmenuOpen: false,
        isScrolled: false,
        hasHeader: document.querySelector('.ds-header') !== null,
        hasHeaderMain: document.querySelector('.ds-section--header-main') !== null,

        init() {
            this.handleScroll();
            window.addEventListener('scroll', () => this.handleScroll());
        },
        handleScroll() {
            this.isScrolled = window.scrollY > 0;
        },
        isActive(url) {
            const normalize = (u) => u.split('#')[0].replace(/\/$/, '');
            return normalize(window.location.href) === normalize(url);
        }
    }
}