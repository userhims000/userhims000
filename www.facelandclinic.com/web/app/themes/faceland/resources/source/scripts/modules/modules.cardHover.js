/*------------------------------------------------------------------------*/
/*  Rodesk empty module script
/*------------------------------------------------------------------------*/

window.rodeskCardHover = (() => {
    let settings;

    const defaults = {
        element: '.c-card--simple'
    };

    /**
     * Animate card function.
     *
     */

    const animateCard = (element, scale, duration) => {
        anime({
            targets: element,
            easing: 'easeOutCubic',
            scale,
            duration
        });
    };

    const enterCard = event => {
        animateCard(event.currentTarget, 1.03, 300);
    };

    const leaveCard = event => {
        animateCard(event.currentTarget, 1.0, 300);
    };

    /**
     * Bind hover events
     *
     */
    const _bindEvents = () => {
        $(settings.element).on('mouseover', enterCard);
        $(settings.element).on('mouseleave', leaveCard);
    };

    const _setup = () => {
        $(window).on('filter.rodeskDone', _bindEvents);

        _bindEvents();
    };

    /**
     * Init module
     */
    const init = options => {
        // Setup settings.
        options = options || {};
        settings = $.extend({}, defaults, options);

        _setup();
    };

    // Return public functions
    return {
        init // Init this function
    };
})(); // Fully reference jQuery after this point.
