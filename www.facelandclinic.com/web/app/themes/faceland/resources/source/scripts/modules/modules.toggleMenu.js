/*------------------------------------------------------------------------*/
/*  Rodesk menu functions
/*------------------------------------------------------------------------*/

window.rodeskMenu = (() => {
    let settings, menuItems;

    /**
     * Define default settings
     *
     */
    const defaults = {
        body: 'body',
        container: '.js-mainnav',
        toggleMenu: '.js-toggle-menu',
        menuItemWrapper: '.js-navigation-item-mobile',
        menuItem: '.c-nav-main__link',
        toggleSubNav: '.js-toggle-sub-nav',

        classes: {
            open: 'is-open',
            noScroll: 'no-scroll'
        }
    };

    /**
     * Disable body scrolling
     */
    const _disableScroll = () => {
        if ($(document).height() > $(window).height()) {
            // Set correct scroll position
            // Add no-scroll class
            const scrollTop = $('html').scrollTop() ? $('html').scrollTop() : $(document).scrollTop();

            $('html').attr('data-scrollpos', scrollTop);
            $('html').css('top', -scrollTop);

            // Wait till body animation is done.
            setTimeout(() => {
                $(settings.body).addClass(settings.classes.noScroll);
            }, 240);
        }
    };

    /**
     * Enable body scrolling
     */
    const _enableScroll = () => {
        // Set correct (old) scroll position
        // Remove no-scroll class from html
        const scrollTop = parseInt($('html').css('top'), 10);
        $(settings.body).removeClass(settings.classes.noScroll);

        // Check if scrollTop is not NaN
        // If scrollTop is not NaN change scrollTop.
        // Prefents the page scrolling up when resizing.
        if (!Number.isNaN(scrollTop)) {
            $('html, body').scrollTop(-scrollTop);
        }

        $('html').removeAttr('data-scrollpos');
        $('html').removeAttr('style');
    };

    /**
     * Return bool if menu is open
     */
    const menuOpen = () => {
        return $(settings.container).hasClass(settings.classes.open);
    };

    const _closeSubNav = () => {
        $(settings.menuItemWrapper).removeClass(settings.classes.open);
    };

    const _toggleSubNav = event => {
        event.stopPropagation();

        const $toggle = $(event.currentTarget);
        const $wrapper = $toggle.closest(settings.menuItemWrapper);

        $wrapper.toggleClass(settings.classes.open);
    };

    /**
     * Toggle the main menu
     *
     */
    const _toggleMenu = () => {
        // Check if menu has open class
        if (menuOpen()) {
            _enableScroll();

            // Add active class to mobile menu toggle
            $(settings.toggleMenu).removeClass(settings.classes.open);

            // Toggle the mobile menu
            $(settings.container).removeClass(settings.classes.open);
        } else {
            _disableScroll();
            // Add active class to mobile menu toggle
            $(settings.toggleMenu).addClass(settings.classes.open);

            // Toggle the mobile menu
            $(settings.container).addClass(settings.classes.open);
        }
    };

    /**
     * Close the main menu
     *
     */
    const closeMenu = () => {
        _closeSubNav();

        // Check if menu has open class
        if (menuOpen()) {
            _enableScroll();

            // Add active class to mobile menu toggle
            $(settings.toggleMenu).removeClass(settings.classes.open);

            // Toggle the mobile menu
            $(settings.container).removeClass(settings.classes.open);

            $(settings.container).css({
                overflowY: 'hidden'
            });
        }
    };

    const setActiveMenuItem = () => {
        menuItems.forEach(item => {
            item.classList.remove('is-active');

            // Active item
            if (item.href === window.location.href) {
                item.classList.add('is-active');
            }
        });
    };

    /**
     * Listen to the "Esc" keypress
     * Close the menu when Esc is pressed
     */
    const _keyPress = event => {
        // Only run if pressed key is "Escape" a.k.a "27"
        // Also check if menu is open
        if (event.which === 27 && menuOpen()) {
            _toggleMenu();
        }
    };

    /**
     * Bind events
     *
     */
    const _bindEvents = () => {
        $(document).on('click.rodeskMenuToggle', settings.toggleMenu, _toggleMenu);

        // Bind keydown event
        $(document).on('keydown', _keyPress);

        $(document).on('click', settings.toggleSubNav, _toggleSubNav);
    };

    /**
     * Init module
     */
    const init = options => {
        // Setup settings.
        options = options || {};
        settings = $.extend({}, defaults, options);

        // Get all menu links
        menuItems = Array.from(document.querySelectorAll(settings.menuItem));

        // Bind events
        _bindEvents();
    };

    // Return public functions
    return {
        init, // Init this function
        closeMenu,
        setActiveMenuItem
    };
})(); // Fully reference jQuery after this point.
