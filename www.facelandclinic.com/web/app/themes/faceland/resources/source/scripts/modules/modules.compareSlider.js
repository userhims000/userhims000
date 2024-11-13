/*------------------------------------------------------------------------*/
/*  Rodesk empty module script
/*------------------------------------------------------------------------*/

window.rodeskCompareSlider = (() => {
    let settings, supportClipPath;

    const defaults = {
        container: '.js-compare-container',
        mask: '.js-compare-mask',
        indicator: '.js-compare-indicator',

        classes: {
            drag: 'js-compare-drag',
            resize: 'js-compare-resize'
        }
    };

    const testClipPath = () => {
        const base = 'clipPath';
        const prefixes = ['webkit'];
        const properties = [base];
        const testElement = document.createElement('testelement');
        const attribute = 'inset(0 0 0 50%)';

        // Push the prefixed properties into the array of properties.
        for (let i = 0, l = prefixes.length; i < l; i += 1) {
            const prefixedProperty = prefixes[i] + base.charAt(0).toUpperCase() + base.slice(1); // remember to capitalize!
            properties.push(prefixedProperty);
        }

        // Interate over the properties and see if they pass two tests.
        for (let i = 0, l = properties.length; i < l; i += 1) {
            const property = properties[i];

            // First, they need to even support clip-path (IE <= 11 does not)...
            if (testElement.style[property] === '') {
                // Second, we need to see what happens when we try to create a CSS shape...
                testElement.style[property] = attribute;

                if (testElement.style[property] === 'none') {
                    return false;
                }

                if (testElement.style[property] !== '') {
                    return true;
                }
            }
        }

        return false;
    };

    function drags(dragElement, resizeElement, container) {
        dragElement
            .on('mousedown vmousedown touchstart', e => {
                dragElement.addClass(settings.classes.drag);
                resizeElement.addClass(settings.classes.resize);

                let firstTouch;
                if (e.originalEvent.touches) {
                    [firstTouch] = e.originalEvent.touches;
                }

                const firstPageX = firstTouch ? firstTouch.pageX : e.pageX;

                const dragWidth = dragElement.outerWidth();
                const xPosition = dragElement.offset().left + dragWidth - firstPageX;
                const containerOffset = container.offset().left;
                const containerWidth = container.outerWidth();
                const minLeft = containerOffset + 10;
                const maxLeft = containerOffset + containerWidth - dragWidth - 10;

                dragElement
                    .parents()
                    .on('mousemove vmousemove touchmove', event => {
                        let touch;
                        if (event.originalEvent.touches) {
                            [touch] = event.originalEvent.touches;
                        }

                        const pageX = touch ? touch.pageX : event.pageX;
                        let leftValue = pageX + xPosition - dragWidth;

                        if (leftValue < minLeft) {
                            leftValue = minLeft;
                        } else if (leftValue > maxLeft) {
                            leftValue = maxLeft;
                        }

                        const widthValue = `${((leftValue + dragWidth / 2 - containerOffset) * 100) / containerWidth}%`;
                        const widthValuePX = `${leftValue + dragWidth / 2 - containerOffset}px`;
                        const heightValuePX = `${container.outerHeight()}px`;

                        if (supportClipPath) {
                            $(`.${settings.classes.resize}`).css({
                                clipPath: `inset(0 0 0 ${widthValue})`,
                                '-webkit-clip-path': `inset(0 0 0 ${widthValue})`
                            });
                        } else {
                            $(`.${settings.classes.resize}`).css('clip', () => {
                                return `rect(0, ${widthValuePX}, ${heightValuePX}, 0)`;
                            });
                        }

                        $(`.${settings.classes.resize}`).on('mouseup vmouseup touchend', () => {
                            dragElement.removeClass(settings.classes.drag);
                            resizeElement.removeClass(settings.classes.resize);
                        });

                        $(`.${settings.classes.drag}`).css('left', widthValue);
                    })
                    .on('mouseup vmouseup touchend', () => {
                        dragElement.removeClass(settings.classes.drag);
                        resizeElement.removeClass(settings.classes.resize);
                    });
                e.preventDefault();
            })
            .on('mouseup vmouseup touchend', () => {
                dragElement.removeClass(settings.classes.drag);
                resizeElement.removeClass(settings.classes.resize);
            });
    }

    /**
     * Bind mouse and touch events
     *
     */
    const _bindEvents = () => {
        const $compareIndicator = $(settings.container);

        $compareIndicator.each((i, item) => {
            const actual = $(item);

            drags(actual.find(settings.indicator), actual.find(settings.mask), actual);
        });
    };

    const _setDefault = () => {
        $(settings.container).each((index, element) => {
            if (supportClipPath) {
                const $lastImage = $(element)
                    .find('.c-compare__image')
                    .last();
                $lastImage.addClass('js-compare-mask');
                const $container = $(settings.mask);
                $container.css({
                    clipPath: `inset(0 0 0 50%)`,
                    '-webkit-clip-path': `inset(0 0 0 50%)`
                });
            } else {
                const $firstImage = $(element)
                    .find('.c-compare__image')
                    .first();
                $firstImage.addClass('js-compare-mask');
                const $container = $(settings.mask);
                const widthValue = $container.outerWidth() / 2;
                const heightValue = $container.outerHeight();
                $container.css('clip', () => {
                    return `rect(0, ${widthValue}px, ${heightValue}px, 0)` /* <-- Removed semicolon */;
                });
            }
        });
    };

    /**
     * Setup compare slider
     * Check if clip path is supported, add default mask and bindevents
     */
    const _setup = () => {
        supportClipPath = testClipPath();
        _setDefault();
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
