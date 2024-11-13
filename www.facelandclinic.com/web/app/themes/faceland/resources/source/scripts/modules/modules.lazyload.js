/*------------------------------------------------------------------------*/
/*  Rodesk image slider functions
/*------------------------------------------------------------------------*/

window.rodeskLazyLoad = (() => {
    let settings, $lazyLoads, $lazyLoadsLoaded, $window, runEqualize;

    const defaults = {
        lazyLoad: '.js-lazy-load',
        lazyLoadLiquid: '.js-lazy-load-liquid',
        treshold: 300,
        retinaWidth: 1280,

        classes: {
            loading: 'is-lazy-loading',
            loaded: 'is-lazy-loaded',
            liquid: 'js-img-liquid'
        },

        dataAttr: {
            aspect: 'data-aspect',
            src: 'data-src',
            srcRetina: 'data-src-retina',
            triggerMatchHeight: 'data-trigger-matchheight'
        }
    };

    /**
     * Get filename from url
     *
     * @param string    url     String with the URL of the image
     *
     */

    const getFilename = url => {
        if (url) {
            const m = url.toString().match(/.*\/(.+?)\./);

            if (m && m.length > 1) {
                return m[1];
            }
        }

        return '';
    };

    /**
     * Calculate and define image ratio
     *
     * @param object  $element    jQuery object with lazy load element
     *
     */

    const _getImageRatio = $element => {
        // Check if an image is defined
        if ($element.length > 0) {
            const width = $element.width(),
                aspect = $element.attr(settings.dataAttr.aspect),
                height = width * aspect;

            // If padding is defined return it
            if (height > 0) {
                // Round the padding
                return Math.round(height);
            }
        }

        return false;
    };

    /**
     * Reset image settings
     *
     * @param object  $element    jQuery object with lazy load element
     *
     */

    const _resetImage = $element => {
        if ($element.length > 0) {
            // Remove the style attribute to reset the padding
            $element.removeAttr('style');

            // Remove loading class
            $element.removeClass(settings.classes.loading);

            // Add loaded class
            $element.addClass(settings.classes.loaded);
        }
    };

    /**
     * Check if image is loaded
     *
     * @param object    $element  Object with lazy load element
     *
     */

    const _isLoaded = $element => {
        if ($element.length > 0) {
            // Check if element has loaded class
            if ($element.hasClass(settings.classes.loaded)) {
                return true;
            }
        }

        return false;
    };

    /**
     * Set image settings
     *
     * @param object  $element    jQuery object with lazy load element
     *
     */

    const _setImage = $element => {
        if ($element.length > 0 && !_isLoaded($element)) {
            // Get the height for this image
            const imageHeight = _getImageRatio($element);

            // Fill the alt element if it's empty
            if ($element.attr('alt') === '' && $element.attr('data-src') !== '') {
                $element.attr('alt', getFilename($element.attr('data-src')));
            }

            // Set loading class
            $element.addClass(settings.classes.loading);

            // Add padding for ratio
            $element.css({ height: `${imageHeight}px` });
        }
    };

    /**
     * Loop all images for lazy loading and set there preferences
     *
     */

    const _setImages = () => {
        // Loop all the images to be lazyloaded
        $lazyLoads.each((index, element) => {
            // Set image preferences
            _setImage($(element));
        });
    };

    /**
     * Check if an element is in view
     *
     */

    const _inview = (index, element) => {
        // Define element
        const $element = $(element);

        // Return if element is not defined
        if (!$element) {
            return false;
        }

        // Return if element is hidden
        if ($element.is(':hidden')) {
            return false;
        }

        // Get screen and element mesurements
        const scrollTop = $window.scrollTop();
        const scrollBottom = scrollTop + $window.height();
        const elementTop = $element.offset().top;
        const elementBottom = elementTop + $element.outerHeight(true);

        // Check if the element is in the vieuwport
        if (elementBottom >= scrollTop - settings.treshold && elementTop <= scrollBottom + settings.treshold) {
            return $element;
        }

        return false;
    };

    /**
     * Prepare images for lazy loading
     *
     */

    const _lazyLoad = () => {
        // Define the elements that are in the viewport
        const $inview = $lazyLoads.filter(_inview);

        // Trigger load event on elements in the viewport
        $lazyLoadsLoaded = $inview.trigger('loadImage');

        // Remove loaded elements from the $lazyloads variable
        $lazyLoads = $lazyLoads.not($lazyLoadsLoaded);
    };

    /**
     * Load an image
     *
     * @param  object   event   The event object
     *
     */

    const _loadImage = event => {
        const $image = $(event.target);
        const retina = window.devicePixelRatio > 1 || window.innerWidth >= settings.retinaWidth;
        const attrib = retina ? settings.dataAttr.srcRetina : settings.dataAttr.src;
        let source = $image.attr(attrib) ? $image.attr(attrib) : $image.attr(settings.dataAttr.src);

        // Check if data attributes are defined correctly.
        if (typeof source === typeof undefined || source === false) {
            return;
        }

        // If retina is required but not defined use default
        source = source || $image.attr(settings.src);

        // If source is defined replace src attribute
        if (source) {
            // Replace source attribute
            $image.attr('src', source);

            // Run some actions when loading is done
            $image.on('load', () => {
                // Reset the image and remove all added styles
                _resetImage($image);

                // Check if matchheight needs to be triggered
                if ($image.attr(settings.dataAttr.triggerMatchHeight) === '1') {
                    if (!runEqualize) return;

                    runEqualize = false;

                    // Debounce equalize
                    setTimeout(() => {
                        $.fn.matchHeight._update();
                        runEqualize = true;
                    }, 500);
                }

                // Check if image needs image liquid
                if ($image.hasClass(settings.lazyLoadLiquid.replace('.', ''))) {
                    // Define image liquid parent
                    const liquidParent = $image.parent();

                    // Add image liquid class to parent
                    liquidParent.addClass(settings.classes.liquid);

                    // Init imgLiquid for this image
                    rodeskDefaults.imgLiquidCustom(liquidParent);
                }
            });
        }
    };

    /**
     * Trigger resize to init lazyload
     *
     */

    const trigger = () => {
        $window.trigger('resize');
    };

    /**
     * Bind events
     *
     */

    const _bindEvents = () => {
        // Bind set images event to resize
        $(window).on('resize', $.debounce(100, _setImages));

        // Bind lazyload on resize/scroll
        $(window).on('resize', _lazyLoad);
        $(window).on('scroll', _lazyLoad);

        // Bind load event to lazyload objects
        $lazyLoads.on('loadImage', _loadImage);
    };

    /**
     * Setup the lazy load module
     *
     */

    const _setup = () => {
        // Load lazy loads elements
        const images = Array.from(document.querySelectorAll(settings.lazyLoad));

        runEqualize = true;

        $lazyLoads = $(images.filter(image => image.getAttribute('data-src') !== ''));

        // Setup window element
        $window = $(window);

        // Bind events
        _bindEvents();

        // Set images
        _setImages();

        trigger();
    };

    /**
     * Init the lazy load module
     *
     * @param object    options     Object of passed options
     *
     */

    const init = options => {
        // Setup settings.
        options = options || {};
        settings = $.extend({}, defaults, options);

        // Setup.
        _setup();
    };

    return {
        init,
        trigger
    };
})();
