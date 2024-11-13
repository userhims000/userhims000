/*------------------------------------------------------------------------*/
/*  Rodesk counter module script
/*------------------------------------------------------------------------*/

window.rodeskCounter = (() => {
    let settings;

    const defaults = {
        wrapper: '.js-counter-wrapper',
        decreaseButton: '.js-counter-dec',
        increaseButton: '.js-counter-inc',
        input: '.js-counter-input',

        classes: {
            maxValue: 'has-max-value',
            disabled: 'is-disabled'
        },

        attr: {
            maxAmount: 'max',
            minAmount: 'min'
        }
    };

    const _disableButton = button => {
        if (!button.classList.contains(settings.classes.disabled)) {
            button.disabled = true;
            button.classList.add(settings.classes.disabled);
        }
    };

    const _enableButton = button => {
        if (button.classList.contains(settings.classes.disabled)) {
            button.disabled = false;
            button.classList.remove(settings.classes.disabled);
        }
    };

    const _inputObserver = input => {
        const amount = input.value;

        if (input.hasAttribute(settings.attr.maxAmount)) {
            const maxAmount = input.getAttribute(settings.attr.maxAmount);
            const wrapper = input.parentNode.parentNode;
            const increaseButton = wrapper.querySelector(settings.increaseButton);

            if (amount >= maxAmount) {
                _disableButton(increaseButton);
            } else {
                _enableButton(increaseButton);
            }
        }

        if (input.hasAttribute(settings.attr.minAmount)) {
            const minAmount = input.getAttribute(settings.attr.minAmount);
            const wrapper = input.parentNode.parentNode;
            const decreaseButton = wrapper.querySelector(settings.decreaseButton);

            if (amount < minAmount) {
                _disableButton(decreaseButton);
            } else {
                _enableButton(decreaseButton);
            }
        }
    };

    /**
     * Decrease the value of the counter
     *
     */
    const _decreaseCounter = event => {
        const button = event.currentTarget;
        const wrapper = button.parentNode;
        const input = wrapper.querySelector(settings.input);
        const changeWith = input.getAttribute('step') || 1;

        input.value = +input.value - +changeWith;
        $(input).trigger('change');

        _inputObserver(input);

        return false;
    };

    /**
     * Increase the value of the counter
     *
     */
    const _increaseCounter = event => {
        const button = event.currentTarget;
        const wrapper = button.parentNode;
        const input = wrapper.querySelector(settings.input);
        const changeWith = input.getAttribute('step') || 1;

        input.value = +input.value + +changeWith;
        $(input).trigger('change');

        _inputObserver(input);

        return false;
    };

    /**
     * Bind click events
     *
     *
     */
    const _bindEvents = () => {
        $(document).on('click', settings.increaseButton, _increaseCounter);
        $(document).on('click', settings.decreaseButton, _decreaseCounter);
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

        if (document.querySelector(settings.wrapper)) {
            _setup();
        }
    };

    // Return public functions
    return {
        init // Init this function
    };
})(jQuery); // Fully reference jQuery after this point.
