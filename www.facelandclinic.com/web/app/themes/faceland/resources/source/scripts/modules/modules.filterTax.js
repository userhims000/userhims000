/*------------------------------------------------------------------------*/
/*  Rodesk filter on taxonomy module script
/*------------------------------------------------------------------------*/

window.rodeskFilterTax = (() => {
    let settings, $selectBox, wrapper, cards;

    const defaults = {
        select: '.js-filter-bodypart',
        wrapper: '.js-filter-wrapper',
        card: '.js-filter-card',

        attr: {
            filter: 'data-bodyparts'
        }
    };

    /**
     * Get filtered, active and inactive
     * @param {string} filter filtered data attribute
     */
    const _getFilteredCards = filter => {
        const active = [...cards].filter(card => card.getAttribute(settings.attr.filter).includes(filter));
        const inactive = [...cards].filter(card => !card.getAttribute(settings.attr.filter).includes(filter));

        return { active, inactive };
    };

    /**
     * animate filtered cards in and out with animejs.
     *
     */
    const _getFilterValue = event => {
        const filterValue = event.target.value;
        const filteredCards = _getFilteredCards(filterValue);

        anime({
            targets: wrapper,
            translateY: 30,
            opacity: 0,
            duration: 300,
            easing: 'easeInOutQuad',

            complete() {
                setTimeout(() => {
                    cards.forEach(element => {
                        $(element.parentNode).remove();
                    });

                    filteredCards.active.forEach(element => {
                        element.style.display = 'none';
                        wrapper.appendChild(element.parentNode);
                        element.style.display = 'block';
                    });

                    rodeskInView.init(); //  Init inview module
                    rodeskLazyLoad.init(); // Init the lazyload module
                    $(window).trigger('scroll');

                    anime({
                        targets: wrapper,
                        translateY: 0,
                        opacity: 1,
                        duration: 300,
                        easing: 'easeInOutQuad',
                        complete() {
                            // Trigger filter done event (used in cardHover.js)
                            $(window).trigger('filter.rodeskDone');
                        }
                    });
                }, 200);
            }
        });
    };

    /**
     * Get filterable objects
     *
     */
    const _getFilterableObjects = () => {
        wrapper = document.querySelector(settings.wrapper);
        cards = wrapper.querySelectorAll(settings.card);
    };

    /**
     * Bind selectbox change event
     *
     */
    const _bindEvents = () => {
        $selectBox.on('change', _getFilterValue);
    };

    const _setup = () => {
        $selectBox = $(settings.select);
        _getFilterableObjects();
        _bindEvents();
    };

    /**
     * Init module
     */
    const init = options => {
        // Setup settings.
        options = options || {};
        settings = $.extend({}, defaults, options);

        if ($(settings.wrapper).length > 0 && $(settings.card).length) {
            _setup();
        }
    };

    // Return public functions
    return {
        init // Init this function
    };
})(jQuery); // Fully reference jQuery after this point.
