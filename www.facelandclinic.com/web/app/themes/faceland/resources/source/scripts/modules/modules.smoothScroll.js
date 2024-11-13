/*------------------------------------------------------------------------*/
/*  Rodesk smoothscroll JS functions
/*------------------------------------------------------------------------*/

window.rodeskSmoothScroll = (() => {
    /**
     * What to do at scroll click
     * @param {element} a string for the element identifier to pass to the plugin
     */
    const onScrollClick = element => {
        const elTarget = element.target;

        element.preventDefault();
        element.stopPropagation();

        const target = $(elTarget).attr('href');
        const scrollToPosition = $(target).offset().top;
        const headerHeight = $('.c-header').height();
        const scrollTo = scrollToPosition - headerHeight;

        $('html:not(:animated),body:not(:animated)').animate({ scrollTop: scrollTo }, 700, () => {
            // use code below to add hash to url after click
            // window.location.hash = "" + target;
            $('html,body').animate({ scrollTop: scrollTo }, 0); // reset the scroll position
        });

        return false;
    };

    // Return an object exposed to the public
    return {
        /**
         * Init the plugin
         * @param { element } a string for the element identifier to pass to the scroll event handler
         */
        init: element => {
            // Set scroller event handlers
            $(element).on('click', clickedElement => {
                onScrollClick(clickedElement);
            });
        }
    };
})(); // Fully reference jQuery after this point.
