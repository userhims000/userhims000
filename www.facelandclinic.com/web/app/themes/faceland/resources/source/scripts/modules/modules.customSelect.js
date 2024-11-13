/*------------------------------------------------------------------------*/
/*  Rodesk select functions
/*------------------------------------------------------------------------*/

window.rodeskSelect = (() => {
    let settings;

    const defaults = {
        container: '.c-select',
        openClass: 'c-select--open',
        selectBox: '.js-select',
        classes: {
            selectUrl: 'js-select-url'
        }
    };

    /**
     * Init the customized selectbox
     */
    const _setCustomSelect = element => {
        // Init the customized selectbox
        const $select = element.selectize({
            copyClassesToDropdown: false,

            onDropdownOpen: dropdown => {
                dropdown.parents(settings.container).addClass(settings.openClass);
            },

            onDropdownClose: dropdown => {
                dropdown.parents(settings.container).removeClass(settings.openClass);
            },
            // On init we want to add all original data attributes to the selctize options
            // By default selectize will remove all data atrributes when parsing options
            onInitialize() {
                const selectBox = this;
                const $selectBox = $(this);

                // Loop all children of this select
                selectBox.revertSettings.$children.each(() => {
                    // Check if this is an opt group
                    const optgroup = $selectBox.is('optgroup');

                    // If optgroup we want to pase all children of the optgroup
                    if (optgroup) {
                        // Find all children of the optgroup
                        const children = $selectBox.find('option');

                        // Loop all children of the optgroup
                        children.each(() => {
                            // Add original data atrributes to the selctize object
                            $.extend(selectBox.options[selectBox.value], $selectBox.data());
                        });

                        // If this is not an optgroup just parse all children
                    } else {
                        // Add original data atrributes to the selctize object
                        $.extend(selectBox.options[selectBox.value], $selectBox.data());
                    }
                });
            },
            onChange(value) {
                if (this.$input.hasClass(settings.classes.selectUrl)) {
                    transitionManager.redirect(value);
                }
            }
        });

        return $select;
    };

    const init = options => {
        // Setup settings.
        options = options || {};
        settings = $.extend({}, defaults, options);

        $(settings.selectBox).each((index, element) => {
            // Initiate simple custom selectbox
            _setCustomSelect($(element));
        });
    };

    // Return an object exposed to the public
    return {
        init
    };
})(); // Fully reference jQuery after this point.
