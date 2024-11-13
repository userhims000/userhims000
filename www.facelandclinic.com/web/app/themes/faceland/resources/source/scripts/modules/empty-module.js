/*------------------------------------------------------------------------*/
/*  Rodesk empty module script
/*------------------------------------------------------------------------*/

window.emptyModule = (() => {
    let settings;

    const defaults = {};

    /**
     * Calc top position of carousel navigation
     *
     */
    const _defaultFunction = () => {};

    /**
     * Bind reveal events
     * Close the cookie bar on click of the close button
     *
     */
    const _bindEvents = () => {};

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
        init // Init this function
    };
})(jQuery); // Fully reference jQuery after this point.
