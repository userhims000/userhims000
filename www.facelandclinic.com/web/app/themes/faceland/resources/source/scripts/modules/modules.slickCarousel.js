/*------------------------------------------------------------------------*/
/*  Rodesk slick carousel module script
/*------------------------------------------------------------------------*/

window.rodeskSlickCarousel = (() => {
    let settings, $carousel;

    const defaults = {
        carousel: '.js-carousel',
        carouselDots: '.slick-dots',
        carouselDotsContainer: '.c-carousel__dots',
        carouselPrev: '.js-carousel-prev',
        carouselNext: '.js-carousel-next',
        carouselSlide: '.slick-slide',
        carouselDelay: 0,

        carouselSettings: {
            arrows: false,
            accessibility: false,
            centerMode: false,
            centerPadding: 0,
            dots: true,
            draggable: false,
            slidesToShow: 1,
            lazyLoad: 'ondemand',
            useCSS: true,
            infinite: false,
            initialSlide: 0,
            fade: true,
            speed: 300,
            autoplay: true,
            autoplaySpeed: 5000,
            adaptiveHeight: true,
            swipe: true,
            pauseOnFocus: true,
            pauseOnHover: true,
            focusOnSelect: false,
            mobileFirst: false
        },

        callBacks: {
            init: () => {
                setTimeout(() => {
                    $.fn.matchHeight._update();
                }, 500);
            }
        }
    };

    /**
     * Init slick carousel
     *
     */
    const _initSlick = () => {
        $carousel = $(settings.carousel);

        $carousel.on('init', settings.callBacks.init);

        $carousel.each((i, element) => {
            $(element).slick({
                arrows: settings.carouselSettings.arrows,
                accessibility: settings.carouselSettings.accessibility,
                dots: settings.carouselSettings.dots,
                centerMode: settings.carouselSettings.centerMode,
                centerPadding: settings.carouselSettings.centerPadding,
                draggable: settings.carouselSettings.draggable,
                slidesToShow: settings.carouselSettings.slidesToShow,
                lazyLoad: settings.carouselSettings.lazyLoad,
                useCSS: settings.carouselSettings.useCSS,
                infinite: settings.carouselSettings.infinite,
                initialSlide: settings.carouselSettings.initialSlide,
                fade: settings.carouselSettings.fade,
                speed: settings.carouselSettings.speed,
                autoplay: settings.carouselSettings.autoplay,
                autoplaySpeed: settings.carouselSettings.autoplaySpeed,
                adaptiveHeight: settings.carouselSettings.adaptiveHeight,
                swipe: settings.carouselSettings.swipe,
                pauseOnFocus: settings.carouselSettings.pauseOnFocus,
                pauseOnHover: settings.carouselSettings.pauseOnHover,
                focusOnSelect: settings.carouselSettings.focusOnSelect,
                mobileFirst: settings.carouselSettings.mobileFirst,
                prevArrow: $(element)
                    .parent()
                    .find(settings.carouselPrev),
                nextArrow: $(element)
                    .parent()
                    .find(settings.carouselNext),
                responsive: settings.carouselSettings.responsive,
                rows: 0
            });
        });
    };

    const destroyCarousel = () => {
        if ($carousel.hasClass(settings.classes.slickInitialized)) {
            $carousel.slick('unslick');
        }
    };

    const _setup = () => {
        _initSlick();
    };

    /**
     * Init module
     */
    const init = options => {
        // Setup settings.
        options = options || {};
        settings = $.extend(true, {}, defaults, options);

        if ($(settings.carousel).length > 0) {
            _setup();
        }
    };

    // Return public functions
    return {
        init, // Init this function
        destroyCarousel
    };
})();
