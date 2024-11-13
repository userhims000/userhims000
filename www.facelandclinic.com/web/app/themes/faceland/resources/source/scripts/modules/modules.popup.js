/*------------------------------------------------------------------------*/
/*  Rodesk empty module script
/*------------------------------------------------------------------------*/

window.rodeskPopup = (() => {
    let settings;

    const defaults = {
        popup: '.js-modal-newsletter',
        popupContent: '.js-modal-content-newsletter',
        openTrigger: '.js-modal-newsletter-trigger',
        closeTrigger: '.js-modal-close',
        openHash: '#open-newsletter',
        closeHash: '#close-newsletter',

        classes: {
            open: 'is-open'
        }
    };

    /**
     * Close popup function
     *
     */
    const _closePopup = () => {
        $(settings.popup).removeClass('is-open');

        $('body').off('click.closePopup').css('position', '');

        if (window.location.hash === settings.openHash) {
            window.location.hash = settings.closeHash;
        }
    };

    /**
     * Open popup function
     *
     */
    const _openPopup = () => {
        const $popup = $(settings.popup);

        $('body').css('position', 'fixed');
        $('.js-modal-content-newsletter').css('min-height', '').css('overflow', 'scroll');

        if (!$popup.hasClass(settings.classes.open)) {
            $popup.addClass(settings.classes.open);
        }

        setTimeout(() => {
            $('body').on('click.closePopup', () => {
                _closePopup();
            });

            $(settings.popupContent).click(event => {
                event.stopPropagation();
            });
        }, 240);

        return false;
    };

    /**
     * Listen to the "Esc" keypress
     * Close the menu when Esc is pressed
     */
    const _keyPress = event => {
        // Only run if pressed key is "Escape" a.k.a "27"
        // Also check if menu is open
        if (event.which === 27) {
            _closePopup();
        }
    };

    /**
     * Check if an hash is defined
     * if true open popup
     */
    const checkHash = () => {
        const { hash } = window.location;

        if (hash && hash === settings.openHash) {
            _openPopup();
        }
    };

    /**
     * Bind reveal events
     * Close the cookie bar on click of the close button
     *
     */
    const _bindEvents = () => {
        $(settings.openTrigger).on('click', _openPopup);
        $(settings.closeTrigger).on('click', _closePopup);

        $(document).on('keydown', _keyPress);

        window.addEventListener('hashchange', checkHash);
    };

    const _setup = () => {
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
        init, // Init this function
        checkHash
    };
})(jQuery); // Fully reference jQuery after this point.
