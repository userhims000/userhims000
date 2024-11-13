/*------------------------------------------------------------------------*/
/* Focus search field when #search-focused is in url
/*------------------------------------------------------------------------*/

const focusSearchField = force => {
    if (!document.body.classList.contains('body--search')) {
        return;
    }

    const searchInput = document.querySelector('.js-search-input');
    const focussed = searchInput.getAttribute('data-focussed');

    if (force) {
        searchInput.focus();
    } else if (focussed) {
        setTimeout(() => {
            searchInput.focus();
        }, 100);
    }
};

/*------------------------------------------------------------------------*/
/* Only show clean button when search input is empty
/*------------------------------------------------------------------------*/
const _checkSearchCleanButton = () => {
    const $searchInput = $('.js-search-input');
    const $cleanButton = $('.js-clean-search');

    if ($searchInput.length > 0 && $cleanButton.length > 0) {
        if ($searchInput.val().length === 0) {
            $cleanButton.css({
                opacity: 0
            });
        }

        $searchInput.on('keydown', event => {
            if (event.currentTarget.value.length > 0) {
                $cleanButton.css({
                    opacity: 1
                });
            } else {
                $cleanButton.css({
                    opacity: 0
                });
            }
        });
    }
};

const documentReady = () => {
    const html = document.documentElement;
    const matchHeightElements = [
        {
            target: '.js-match-height',
            options: {}
        },
        {
            target: '.js-match-min-height',
            options: {
                property: 'min-height'
            }
        }
    ];

    html.classList.remove('wf-loading', 'no-js');

    rodeskDefaults.init(); // Init all default functions
    rodeskSmoothScroll.init('.js-smooth-scroll'); // Init smoothscroll plugin
    rodeskLazyLoad.init(); // Init the lazyload module
    rodeskVideo.init(); // Init video module
    rodeskPopup.init();
    rodeskDefaults.matchHeight(matchHeightElements);
    rodeskCompareSlider.init();
    rodeskToggle.init();
    rodeskInView.init(); //  Init inview module
    rodeskFilterTax.init();
    rodeskCampaginScroll.init();
    rodeskSwitch.init();

    $('[data-featherlight]').featherlight(); // Init featherLight
    focusSearchField();
    $('.js-append-around').appendAround(); // Init appendAround plugin
    rodeskUpdate.disable();

    rodeskValidate.init(); // Init validate module

    rodeskSlickCarousel.init({
        carousel: '.js-video-carousel',

        carouselSettings: {
            arrows: true,
            autoplay: false,
            slidesToShow: 1,
            slidesToScroll: 1,
            fade: false,
            dots: false,
            focusOnSelect: false,
            mobileFirst: true,
            responsive: [
                {
                    breakpoint: 767,
                    settings: {
                        slidesToShow: 2
                    }
                },
                {
                    breakpoint: 1699,
                    settings: {
                        slidesToShow: 3
                    }
                }
            ]
        }
    });

    rodeskSlickCarousel.init({
        carousel: '.js-card-carousel',

        carouselSettings: {
            arrows: true,
            autoplay: false,
            draggable: true,
            slidesToShow: 1,
            slidesToScroll: 1,
            fade: false,
            dots: false,
            focusOnSelect: false,
            centerMode: true,
            centerPadding: 20,
            infinite: true,

            mobileFirst: true,
            responsive: [
                {
                    breakpoint: 1023,
                    settings: {
                        slidesToShow: 2,
                        initialSlide: 1
                    }
                },
                {
                    breakpoint: 1239,
                    settings: {
                        centerPadding: 80,
                        slidesToShow: 3,
                        initialSlide: 1
                    }
                },
                {
                    breakpoint: 1920,
                    settings: {
                        slidesToShow: 4,
                        initialSlide: 2
                    }
                }
            ]
        }
    });

    rodeskSlickCarousel.init({
        carousel: '.js-default-carousel',

        carouselSettings: {
            arrows: true,
            autoplay: false,
            slidesToScroll: 1,
            fade: false,
            dots: false,
            focusOnSelect: false
        }
    });

    rodeskSlickCarousel.init({
        carousel: '.js-panorama-carousel',

        carouselSettings: {
            arrows: true,
            autoplay: true,
            slidesToScroll: 1,
            fade: false,
            dots: false,
            focusOnSelect: false
        }
    });

    $('.js-clean-search').on('click', event => {
        event.preventDefault();

        const $searchParent = $(event.currentTarget).closest('.js-search-form');
        const $searchInput = $searchParent.find('.js-search-input');

        $(event.currentTarget).css({
            opacity: 0
        });

        $searchInput.val('');
        focusSearchField(true);
    });

    $('.js-open-chat').on('click', event => {
        event.preventDefault();

        const iframe = $('.obiChatLauncher');
        const button = iframe.contents().find('button');
        button.trigger('click');
    });

    _checkSearchCleanButton();

    if (typeof documentReadyMain === 'function') {
        documentReadyMain();
    }
};

/*function removePageTransitions() {
    $('.o-loader').hide();

    const allLinks = document.querySelectorAll('a');
    // Remove Listener at Runtime
    [].forEach.call(allLinks, link => {
        // do whatever
        link.removeEventListener('click', transitionManager._navigate);
    });
}*/

document.addEventListener('DOMContentLoaded', () => {
    FastClick.attach(document.body); // Init fastclick for touch
    rodeskMenu.init(); // Init menu

 /*   if (typeof window.fetch === 'undefined') {
        removePageTransitions();
    }*/

    documentReady();
    rodeskPopup.checkHash();
});

// transitionManager.on('NAVIGATE_OUT', () => {});

transitionManager.on('NAVIGATE_END', () => {
    documentReady();

    if ($('.js-masonry').length > 0 && $('.js-masonry .o-grid__cell').length === 0) {
        const masonryGrid = document.querySelector('.js-masonry');
        salvattore.registerGrid(masonryGrid);
    }

    if (typeof acalltracker !== 'undefined' && siteInfo.environment === 'production') {
        acalltracker.dynamicPageload();
    }
});

transitionManager.on('NAVIGATE_IN', ({ to }) => {
    rodeskMenu.setActiveMenuItem();
    rodeskUpdate.init(to);
});
