/*------------------------------------------------------------------------*/
/*  Rodesk empty module script
/*------------------------------------------------------------------------*/

window.rodeskSwitch = (() => {
    let settings;

    const defaults = {
        switch: '.js-switch',
        content: '.js-toggle-content',

        classes: {
            active: 'active'
        },

        dataAttr: {
            id: 'data-id'
        }
    };

    /**
     * Toggle switch function
     *
     */
    const _toggle = event => {
        const $switch = $(event.currentTarget);
        const type = $switch.attr(settings.dataAttr.id);

        $(settings.switch).removeClass(settings.classes.active);
        $switch.addClass(settings.classes.active);

        $(settings.content).removeClass(settings.classes.active);
        $(`${settings.content}[${settings.dataAttr.id}="${type}"]`).addClass(settings.classes.active);
    };

    /**
     * Bind click events
     *
     */
    const _bindEvents = () => {
        $(settings.switch).click(_toggle);
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

        if ($(settings.switch).length > 0) {
            _setup();
        }
    };

    // Return public functions
    return {
        init // Init this function
    };
})(jQuery); // Fully reference jQuery after this point.
