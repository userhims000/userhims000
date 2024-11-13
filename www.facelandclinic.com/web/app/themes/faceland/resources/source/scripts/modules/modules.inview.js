/*------------------------------------------------------------------------*/
/*  Rodesk inview functions
/*------------------------------------------------------------------------*/

window.rodeskInView = (() => {
    let settings, windowHeight, $animationElements;

    /**
     * Default settings
     */
    const defaults = {
        elements: '.js-animation-element',
        treshold: 0.25,
        timeout: 200,

        classes: {
            inView: 'a-inview'
        }
    };

    /**
     * Check is element is in view
     * If element is in view add a class to it
     */
    const _checkInView = () => {
        const windowTopPos = $(window).scrollTop(),
            windowBottomPos = windowTopPos + windowHeight;

        // Loop all elements to be animated
        $.each($animationElements, (index, element) => {
            const $elem = $(element),
                elemHeight = $elem.outerHeight() * settings.treshold,
                elemTopPos = $elem.offset().top,
                elemBotPos = elemTopPos + elemHeight;

            // Check if bottom position of element is bigger/equal to window top position
            // Also check if element top position is smaller/equal to window bottom position minus element height
            if (
                elemBotPos >= windowTopPos &&
                elemTopPos <= windowBottomPos - elemHeight &&
                !$elem.hasClass(settings.classes.inView)
            ) {
                $elem.addClass(settings.classes.inView);
            }
        });
    };

    /**
     * Bind all events
     */
    const _bindEvents = () => {
        // Bind event to window resize
        $(window).on('resize', $.debounce(100, _checkInView));

        // Bind event to window scroll
        $(window).on('scroll', $.throttle(100, _checkInView));
    };

    /**
     * Setup the module
     * Set the window heigt, animation elements
     * Use a timeout the set the initial check in view
     */
    const _setup = () => {
        // Define window height
        windowHeight = $(window).height();

        // Define the animation element to listed to
        $animationElements = $(settings.elements);

        setTimeout(() => {
            // Check if elements are in view
            _checkInView();
        }, settings.timeout);
    };

    /**
     * Init the module
     */
    const init = options => {
        // Setup settings.
        options = options || {};
        settings = $.extend({}, defaults, options);

        // Setup the module
        _setup();

        // Bind module events
        _bindEvents();
    };

    /**
     * Return an object exposed to the public
     */
    return {
        init
    };
})(); // Fully reference jQuery after this point.
