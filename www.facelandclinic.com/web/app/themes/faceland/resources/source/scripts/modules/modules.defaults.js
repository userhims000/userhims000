/*------------------------------------------------------------------------*/
/*  Rodesk default JS functions
/*------------------------------------------------------------------------*/

window.rodeskDefaults = (() => {
    const _exportSvg = () => {
        $('.js-svg-export').each((index, element) => {
            const $img = $(element);
            const imgID = $img.attr('id');
            const imgClass = $img.attr('class');
            const imgURL = $img.attr('src');

            $.get(
                imgURL,
                data => {
                    // Get the SVG tag, ignore the rest
                    let $svg = $(data).find('svg');

                    // Add replaced image's ID to the new SVG
                    if (typeof imgID !== 'undefined') {
                        $svg = $svg.attr('id', imgID);
                    }
                    // Add replaced image's classes to the new SVG
                    if (typeof imgClass !== 'undefined') {
                        $svg = $svg.attr('class', `${imgClass} replaced-svg`);
                    }

                    // Remove any invalid XML tags as per http://validator.w3.org
                    $svg = $svg.removeAttr('xmlns:a');

                    // Replace image with new SVG
                    $img.replaceWith($svg);
                },
                'xml'
            );
        });
    };

    /*------------------------------------------------------------------------*/
    /*  Open link in popup window
    /*------------------------------------------------------------------------*/

    const _jsPopup = event => {
        const link = $(event.currentTarget).attr('href');

        window.open(link, '_blank', 'toolbar=yes,scrollbars=yes,resizable=yes,top=300,left=300,width=700,height=500');

        return false;
    };

    /*------------------------------------------------------------------------*/
    /*  Calculate offset (Same as jquery offset)
    /*------------------------------------------------------------------------*/

    const offset = elem => {
        // Get document-relative position by adding viewport scroll to viewport-relative gBCR
        const rect = elem.getBoundingClientRect();
        const win = elem.ownerDocument.defaultView;

        return {
            top: rect.top + win.pageYOffset,
            left: rect.left + win.pageXOffset
        };
    };

    /*------------------------------------------------------------------------*/
    /*  Open rel=external in new window
    /*------------------------------------------------------------------------*/

    const _relExternal = element => {
        window.open($(element.currentTarget).attr('href'));
        return false;
    };

    /*------------------------------------------------------------------------*/
    /*  Make link of whole element block
    /*------------------------------------------------------------------------*/

    const _jsBlock = event => {
        const link = $(event.currentTarget)
            .find('a')
            .not('.js-block-skip');
        const closestHref = link.attr('href');
        const rel = link.attr('rel');

        if (rel === 'external') {
            window.open(closestHref, '_blank');
        } else {
            if (typeof transitionManager !== 'undefined') {
                transitionManager.redirect(closestHref);
            } else {
                window.location = closestHref;
            }
        }

        return false;
    };

    /*------------------------------------------------------------------------*/
    /*  Make link with js-block-skip clickable
    /*------------------------------------------------------------------------*/
    const _jsBlockSkip = event => {
        event.stopPropagation();
    };

    /*------------------------------------------------------------------------*/
    /*  Init Image Liquid JS plugin
   /*------------------------------------------------------------------------*/

    const _imgLiquidCustom = element => {
        element.each(image => {
            // Decode the IMG url if all ready encoded
            // The imgLiquid plugin fucksup the encoded URL's
            // See https://github.com/karacas/imgLiquid/issues/25

            const imageElem = $(image).find('img');

            if (new RegExp(/%[0-9A-Z]{2}/g).test(imageElem.attr('src'))) {
                imageElem.attr('src', decodeURIComponent(imageElem.attr('src')));
            }

            element.imgLiquid();
        });
    };

    /*------------------------------------------------------------------------*/
    /*  Init matchHeight plugin
    /*------------------------------------------------------------------------*/

    const _matchHeight = matchHeightOptions => {
        Object.values(matchHeightOptions).forEach(value => {
            $(value.target).matchHeight(value.options);
        });
    };

    /*------------------------------------------------------------------------*/
    /*  Setup event listeners
    /*------------------------------------------------------------------------*/

    const _setupListeners = () => {
        // Init events for class=".js-block"
        $(document).on('click', '.js-block', _jsBlock);

        $(document).on('click', '.js-block-skip', _jsBlockSkip);

        // Init events for rel="external"
        $(document).on('click', "a[rel='external']", _relExternal);
        $(document).on('click', "a[rel='external nofollow']", _relExternal);

        // Init events for class=".js-popup"
        $(document).on('click', '.js-popup', _jsPopup);
    };

    // Return an object exposed to the public
    return {
        matchHeight: _matchHeight,
        imgLiquidCustom: _imgLiquidCustom,
        offset,

        /**
         * Global functions init
         */
        init: () => {
            // Init several default functions
            _exportSvg();
            _imgLiquidCustom($('.js-image-liquid')); // init imageLiquid plugin
            _setupListeners(); // Setup the event listeners
        }
    };
})(); // Fully reference jQuery after this point.
