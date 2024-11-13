/*------------------------------------------------------------------------*/
/*  Rodesk toggle module script
/*------------------------------------------------------------------------*/

window.rodeskToggle = (() => {
    let settings;

    const defaults = {
        trigger: '.js-toggle-trigger',
        wrapper: '.js-toggle-wrapper',
        parent: '.js-toggle-parent',
        button: '.js-slideopen',
        toggleContent: '.js-toggle-content',
        toggleDefault: '.js-toggle-default',

        classes: {
            open: 'is-open',
            active: 'is-active'
        },

        data: {
            animationType: 'data-animation-type',
            parentId: 'data-parent-id',
            multiple: 'data-multiple',
            closeParent: 'data-close',
            disableMatchheight: 'data-disable-trigger-match-height'
        }
    };

    /**
     * Toggle function for opening and clossing a specific element via
     * click event on an button or link.
     *
     */
    const _toggle = event => {
        const $this = $(event.currentTarget);
        const $parent = $(`#${$this.attr(settings.data.parentId)}`);
        const $wrapper = $this.closest(settings.wrapper);

        if ($this.attr(settings.data.animationType) === 'jquery') {
            const $parentContent = $parent.find(settings.toggleContent);

            if ($parent.hasClass(settings.classes.open) && $this.attr(settings.data.closeParent) !== 'false') {
                $parentContent.slideUp();
                $parent.removeClass(settings.classes.open);
            } else {
                if ($wrapper.attr(settings.data.multiple) !== 'true') {
                    $wrapper.find(settings.toggleContent).slideUp();
                    $wrapper.find(settings.parent).removeClass(settings.classes.open);
                }

                $parentContent.slideDown();
                $parent.addClass(settings.classes.open);
            }
        } else {
            if ($parent.hasClass(settings.classes.open) && $this.attr(settings.data.closeParent) !== 'false') {
                $parent.removeClass(settings.classes.open);
            } else {
                if ($wrapper.attr(settings.data.multiple) !== 'true') {
                    $wrapper.find(settings.parent).removeClass(settings.classes.open);
                    $wrapper.find(settings.trigger).removeClass(settings.classes.active);
                }

                $parent.addClass(settings.classes.open);
                $this.addClass(settings.classes.active);
            }
        }

        if ($this.attr(settings.data.disableMatchheight) !== 'true') {
            $.fn.matchHeight._update();
        }
    };

    /**
     * Function for triggering a default toggle.
     *
     */
    const _triggerDefault = () => {
        const $elementToOpen = $(settings.toggleDefault);

        if ($elementToOpen.length > 0) {
            $elementToOpen.trigger('click');
        }
    };

    /**
     * Bind click events on toggle trigger
     *
     */
    const _bindEvents = () => {
        $(settings.trigger).on('click', _toggle);
    };

    const _setup = () => {
        _bindEvents();
        _triggerDefault();
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
        init // Reveal init function
    };
})(); // Fully reference jQuery after this point.
