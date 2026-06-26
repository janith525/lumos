import 'bootstrap/dist/js/bootstrap.bundle.min.js';

const siteHeader = document.querySelector('.js-site-header');

if (siteHeader) {
    document.body.classList.add('has-fixed-header');

    const setHeaderHeight = () => {
        const headerHeight = siteHeader.offsetHeight;
        document.body.style.setProperty('--site-header-height', `${headerHeight}px`);
    };

    setHeaderHeight();
    window.addEventListener('resize', setHeaderHeight);

    let lastScrollTop = window.scrollY;

    window.addEventListener('scroll', () => {
        const currentScrollTop = window.scrollY;

        if (currentScrollTop <= 0) {
            siteHeader.classList.remove('is-hidden');
        } else if (currentScrollTop > lastScrollTop && currentScrollTop > 120) {
            siteHeader.classList.add('is-hidden');
        } else if (currentScrollTop < lastScrollTop) {
            siteHeader.classList.remove('is-hidden');
        }

        lastScrollTop = currentScrollTop;
    }, { passive: true });
}

const heroSlider = document.querySelector('#heroSlider');

if (heroSlider) {
    const currentSlideElement = heroSlider.querySelector('.js-current-slide');
    const totalSlidesElement = heroSlider.querySelector('.js-total-slides');
    const carouselItems = heroSlider.querySelectorAll('.carousel-item');

    const formatSlideNumber = (value) => String(value).padStart(2, '0');

    if (totalSlidesElement) {
        totalSlidesElement.textContent = formatSlideNumber(carouselItems.length);
    }

    heroSlider.addEventListener('slid.bs.carousel', (event) => {
        if (currentSlideElement) {
            currentSlideElement.textContent = formatSlideNumber(event.to + 1);
        }
    });
}
