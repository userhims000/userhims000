/*------------------------------------------------------------------------*/
/*  Rodesk update scroll
/*------------------------------------------------------------------------*/

window.rodeskCampaginScroll = (() => {
    let settings, defaultColor;

    const defaults = {
        backgroundColorElement: '.u-bg-campaign',
        target: '.js-campaign-card',
        panorama: '.js-campaign-panorama',
        data: {
            backgroundColor: 'data-background-color'
        }
    };

    const _updateBackgroundColor = entries => {
        entries.forEach(entry => {
            const { isIntersecting, target } = entry;

            if (isIntersecting) {
                const campaignColor = target.getAttribute(settings.data.backgroundColor);

                anime({
                    targets: settings.backgroundColorElement,
                    backgroundColor: campaignColor,
                    duration: 400,
                    easing: 'easeInOutCubic'
                });
            }
        });
    };

    const _setDefaultBackground = entries => {
        entries.forEach(entry => {
            const { isIntersecting } = entry;
            if (isIntersecting) {
                anime({
                    targets: settings.backgroundColorElement,
                    backgroundColor: defaultColor,
                    duration: 400,
                    easing: 'easeInOutCubic'
                });
            }
        });
    };

    /**
     * Bind intersection observer to campaign cards
     *
     */
    const _bindEvents = () => {
        const options = {
            threshold: 1
        };
        const observer = new IntersectionObserver(_updateBackgroundColor, options);
        const campaignCards = document.querySelectorAll(settings.target);

        [...campaignCards].map(card => observer.observe(card));

        const panoramaObserver = new IntersectionObserver(_setDefaultBackground, options);
        const panorama = document.querySelector(settings.panorama);

        panoramaObserver.observe(panorama);
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

        const panorama = document.querySelector(settings.panorama);
        const firstTarget = document.querySelector(settings.target);

        if (panorama && firstTarget) {
            defaultColor = firstTarget.getAttribute(settings.data.backgroundColor);
            panorama.style.backgroundColor = defaultColor;
            _setup();
        }
    };

    // Return public functions
    return {
        init // Init this function
    };
})(jQuery); // Fully reference jQuery after this point.
