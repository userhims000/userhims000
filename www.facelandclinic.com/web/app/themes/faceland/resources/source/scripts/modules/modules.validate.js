/*------------------------------------------------------------------------*/
/*  Rodesk Validate function
/*------------------------------------------------------------------------*/

window.rodeskValidate = (() => {
    let settings;

    /**
     * Default settings
     */

    const defaults = {
        form: '.js-validate',
        formParent: '.js-form-wrapper',
        formItem: '.js-form-item',
        button: '.c-btn',
        itemsToHide: '.js-to-hide',
        responseMessage: '.js-succes-message',
        errorMessage: '.js-error-message',

        classes: {
            succes: 'is-succes',
            error: 'is-error',
            valid: 'is-valid',
            loading: 'is-loading',
            disabled: 'is-disabled',
            validate: 'c-form-validate'
        },

        dataAttr: {
            loadText: 'data-loading-text'
        }
    };

    /*------------------------------------------------------------------------*/
    /*  Send the form with AJAX
    /*------------------------------------------------------------------------*/

    function _sendForm($formNode, $formParent) {
        const $inputs = $formNode.find('input');
        const $button = $formNode.find(settings.button);
        const formurl = $formNode.attr('action');
        const $thanksMessage = $formParent.find(settings.responseMessage);
        const $errorMessage = $formParent.find(settings.errorMessage);
        const $itemsToHide = $formParent.find(settings.itemsToHide);
        const data = $formNode.serialize();
        const buttonText = $button.val();

        // Add loading class to form
        $formNode.addClass(settings.classes.loading);

        // Disbale all input while sending AJAX request
        $inputs.attr('disabled', true);
        $button.attr('disabled', true);

        // Add disbaled class to the input and button fields
        $inputs.addClass(settings.classes.disabled);
        $button.addClass(settings.classes.disabled);

        // Use data attirbute for alternative loading text
        $button.val($formNode.attr(settings.dataAttr.loadText));

        // AJAX login method
        $.ajax({
            type: 'POST',
            url: formurl,
            data,
            success: response => {
                // Remove old error messages
                $errorMessage.remove();

                // Add loading class to form
                $formNode.removeClass(settings.classes.loading);

                // Remove disbaled class to the input fields
                $inputs.removeClass(settings.classes.disabled);
                $button.removeClass(settings.classes.disabled);

                // Reset button text
                $button.val(buttonText);

                // Enable all input while sending AJAX request
                $inputs.attr('disabled', false);
                $button.attr('disabled', false);

                // Check if the response is failed
                if (response.data.messages && !response.success) {
                    // Show new error messages
                    response.data.messages.map(message => $formNode.prepend(message));
                } else {
                    // Hide the form if response is success
                    $itemsToHide.hide();

                    // Show the succes message if response is success
                    $thanksMessage.css({ display: 'block' });
                }
            },
            error: error => {
                throw error('Error sending data', error);
            }
        });

        return false;
    }

    /*------------------------------------------------------------------------*/
    /*  Bind Parsley validate events
    /*------------------------------------------------------------------------*/

    function _bindEvents($form, $formParent) {
        // First check if element excists before initing Parsley
        // Parsely alsways needs an excisting element
        if ($form.length > 0) {
            // Prevent default form submission
            $form.on('submit', event => {
                event.preventDefault();

                // Submit the form
                _sendForm($form, $formParent);
            });

            // Run when a field validates with an error
            window.Parsley.on('field:error', fieldInstance => {
                const $errorContainer = $formParent.find('.js-error-message');
                const messages = fieldInstance.getErrorsMessages();

                // Check if the are any message
                // If true show the error container
                if (messages) {
                    $errorContainer.css({ display: 'block' });
                }
            });

            // Run when a field validates with success
            window.Parsley.on('field:success', () => {
                const $errorContainer = $formParent.find('.js-error-message');
                const $formFieldErrors = $form.find(`${settings.formItem}.${settings.classes.error}`);

                // Check if there are no errors
                if ($formFieldErrors.length === 0) {
                    $errorContainer.hide();
                }
            });
        }
    }

    /**
     * Setup the module
     * Set the window heigt, animation elements
     * Use a timeout the set the initial check in view
     */

    const _setup = () => {
        const $formElements = $(settings.form);

        if ($formElements.length > 0) {
            $formElements.each((index, form) => {
                const $form = $(form);
                const $formParent = $form.closest(settings.formParent);

                // Init Parsleyjs
                $form.parsley({
                    errorClass: settings.classes.error,
                    successClass: settings.classes.valid,
                    errorsContainer: () => {
                        return $('<div></div>').css('display', 'none');
                    },
                    classHandler: el => {
                        return el.$element.closest(settings.formItem);
                    }
                });

                // Validate the form
                _bindEvents($form, $formParent);
            });
        }
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
    };

    /**
     * Return an object exposed to the public
     */
    return {
        init
    };
})();
