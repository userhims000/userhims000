function bindEvents() {
    // Sync custom variation selection markup with default WC variation selects
    $(document).on('change', '.js-select-shop, .js-radio ', event => {
        const $element = $(event.currentTarget);

        $(`.variations select[name="${$element.attr('name')}"]`)
            .val($element.val())
            .trigger('change');
    });

    // Update the single product price when selecting variation(s)
    $(document).on('found_variation', (event, variation) => {
        $('.c-panorama__prices').html(variation.price_html);
    });

    // Re-trigger lazyload when updating divs with AJAX
    $(document.body).on('updated_wc_div', () => {
        rodeskLazyLoad.init();
    });
}

const documentReady = () => {
    const matchHeightElements = [
        {
            target: '.js-match-height',
            options: {}
        }
    ];

    rodeskDefaults.init(); // Init all default functions
    rodeskSmoothScroll.init('.js-smooth-scroll'); // Init smoothscroll plugin
    rodeskLazyLoad.init(); // Init the lazyload module
    rodeskPopup.init(); // Init de popup module
    rodeskToggle.init(); // Init the toggle module
    rodeskInView.init(); //  Init inview module
    rodeskCounter.init(); //  Init counter module
    rodeskDefaults.matchHeight(matchHeightElements);
    $('[data-featherlight]').featherlight(); // Init featherLight
    $('.js-append-around').appendAround(); // Init appendAround plugin

    if (rodeskBreakpoints.isBreakpoint('large')) {
        rodeskSelect.init({
            selectBox: '.js-select-shop'
        }); // Init customselect
    }

    rodeskSlickCarousel.init({
        carousel: '.js-product-detail-carousel',

        carouselSettings: {
            arrows: true,
            autoplay: false,
            fade: false,
            slidesToScroll: 1,
            dots: true,
            focusOnSelect: false,
            infinite: true
        }
    });

    bindEvents();

    $('.js-select-shop, .js-radio ').trigger('change');
};

document.addEventListener('DOMContentLoaded', () => {
    FastClick.attach(document.body); // Init fastclick for touch
    rodeskMenu.init(); // Init menu

    documentReady();
});

// Dirty fix to overload WC JS functions on jQuery's document ready.
jQuery($ => {
    $.scroll_to_notices = () => null;
});
