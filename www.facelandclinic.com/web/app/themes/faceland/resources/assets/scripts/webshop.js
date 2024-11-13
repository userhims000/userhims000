"use strict";

function _typeof(obj) { "@babel/helpers - typeof"; if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }

var _removeQuotes = Symbol("_removeQuotes");

/*------------------------------------------------------------------------*/

/*  Rodesk breakpoint functions
/*------------------------------------------------------------------------*/
window.rodeskBreakpoints = function () {
  /*
   * Use this JS module to define the actual SCSS breakpoint
   * This allowes to share SCSS breakpoints with JavaScript
   *
   * This function returns a string with the actual breakpoint
   * rodeskBreakpoints.getBreakpoint()
   *
   * This function checks if a passed string matches the actual breakpoint
   * Returns true/false
   * rodeskBreakpoints.isBreakpoint( breakpoint )
   *
   */
  var RodeskBreakpoints = /*#__PURE__*/function () {
    function RodeskBreakpoints() {
      _classCallCheck(this, RodeskBreakpoints);
    }

    _createClass(RodeskBreakpoints, [{
      key: _removeQuotes,

      /**
       * Remove the quotes from a string
       * @param  string   The string to be cleaned
       * @return string   The cleaned string wihtout quotes
       */
      value: function value(string) {
        this.string = string;

        if (typeof this.string === 'string' || this.string instanceof String) {
          var cleanString = this.string.replace(/[^a-zA-Z ]/g, '');
          return cleanString;
        }

        return false;
      }
      /**
       * Output the actual browser viewport breakpoint
       * @return  string  The actual breakpoint of the browser
       */

    }, {
      key: "getBreakpoint",
      value: function getBreakpoint() {
        var _this = this;

        var style = null;

        if (window.getComputedStyle && window.getComputedStyle(document.body, '::after')) {
          style = window.getComputedStyle(document.body, '::after');
          style = style.content;
        } else {
          window.getComputedStyle = function (el) {
            _this.el = el;

            _this.getPropertyValue = function (prop) {
              var re = /(-([a-z]){1})/g;

              if (re.test(prop)) {
                prop.replace(re, function () {
                  for (var _len = arguments.length, args = new Array(_len), _key = 0; _key < _len; _key++) {
                    args[_key] = arguments[_key];
                  }

                  return args[2].toUpperCase();
                });
              }

              return el.currentStyle[prop] ? el.currentStyle[prop] : null;
            };

            return _this;
          };

          style = window.getComputedStyle(document.getElementsByTagName('head')[0]);
          style = style.getPropertyValue('font-family');
        }

        return this[_removeQuotes](style);
      }
      /**
       * Check if a breakpoints matches the actual browser viewport breakpoint
       * @param  string  breakpoint The breakpoint name we are checking
       * @return Boolean            Check if breakpoints matches with actual browser breakpoint
       */

    }, {
      key: "isBreakpoint",
      value: function isBreakpoint(breakpoint) {
        // @TODO find a better method / more dynamic for this
        var breakpoints = {
          small: ['small', 'compact', 'medium', 'large', 'wide', 'huge', 'mega'],
          compact: ['compact', 'medium', 'large', 'wide', 'huge', 'mega'],
          medium: ['medium', 'large', 'wide', 'huge', 'mega'],
          large: ['large', 'wide', 'huge', 'mega'],
          wide: ['wide', 'huge', 'mega'],
          huge: ['huge', 'mega'],
          mega: ['mega']
        };
        var actualBreakpoint = this.getBreakpoint();

        if ($.inArray(actualBreakpoint, breakpoints[breakpoint]) !== -1) {
          return true;
        }

        return false;
      }
    }]);

    return RodeskBreakpoints;
  }();

  return new RodeskBreakpoints();
}();
/*------------------------------------------------------------------------*/

/*  Rodesk default JS functions
/*------------------------------------------------------------------------*/


window.rodeskDefaults = function () {
  var _exportSvg = function _exportSvg() {
    $('.js-svg-export').each(function (index, element) {
      var $img = $(element);
      var imgID = $img.attr('id');
      var imgClass = $img.attr('class');
      var imgURL = $img.attr('src');
      $.get(imgURL, function (data) {
        // Get the SVG tag, ignore the rest
        var $svg = $(data).find('svg'); // Add replaced image's ID to the new SVG

        if (typeof imgID !== 'undefined') {
          $svg = $svg.attr('id', imgID);
        } // Add replaced image's classes to the new SVG


        if (typeof imgClass !== 'undefined') {
          $svg = $svg.attr('class', "".concat(imgClass, " replaced-svg"));
        } // Remove any invalid XML tags as per http://validator.w3.org


        $svg = $svg.removeAttr('xmlns:a'); // Replace image with new SVG

        $img.replaceWith($svg);
      }, 'xml');
    });
  };
  /*------------------------------------------------------------------------*/

  /*  Open link in popup window
  /*------------------------------------------------------------------------*/


  var _jsPopup = function _jsPopup(event) {
    var link = $(event.currentTarget).attr('href');
    window.open(link, '_blank', 'toolbar=yes,scrollbars=yes,resizable=yes,top=300,left=300,width=700,height=500');
    return false;
  };
  /*------------------------------------------------------------------------*/

  /*  Calculate offset (Same as jquery offset)
  /*------------------------------------------------------------------------*/


  var offset = function offset(elem) {
    // Get document-relative position by adding viewport scroll to viewport-relative gBCR
    var rect = elem.getBoundingClientRect();
    var win = elem.ownerDocument.defaultView;
    return {
      top: rect.top + win.pageYOffset,
      left: rect.left + win.pageXOffset
    };
  };
  /*------------------------------------------------------------------------*/

  /*  Open rel=external in new window
  /*------------------------------------------------------------------------*/


  var _relExternal = function _relExternal(element) {
    window.open($(element.currentTarget).attr('href'));
    return false;
  };
  /*------------------------------------------------------------------------*/

  /*  Make link of whole element block
  /*------------------------------------------------------------------------*/


  var _jsBlock = function _jsBlock(event) {
    var link = $(event.currentTarget).find('a').not('.js-block-skip');
    var closestHref = link.attr('href');
    var rel = link.attr('rel');

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


  var _jsBlockSkip = function _jsBlockSkip(event) {
    event.stopPropagation();
  };
  /*------------------------------------------------------------------------*/

  /*  Init Image Liquid JS plugin
  /*------------------------------------------------------------------------*/


  var _imgLiquidCustom = function _imgLiquidCustom(element) {
    element.each(function (image) {
      // Decode the IMG url if all ready encoded
      // The imgLiquid plugin fucksup the encoded URL's
      // See https://github.com/karacas/imgLiquid/issues/25
      var imageElem = $(image).find('img');

      if (new RegExp(/%[0-9A-Z]{2}/g).test(imageElem.attr('src'))) {
        imageElem.attr('src', decodeURIComponent(imageElem.attr('src')));
      }

      element.imgLiquid();
    });
  };
  /*------------------------------------------------------------------------*/

  /*  Init matchHeight plugin
  /*------------------------------------------------------------------------*/


  var _matchHeight = function _matchHeight(matchHeightOptions) {
    Object.values(matchHeightOptions).forEach(function (value) {
      $(value.target).matchHeight(value.options);
    });
  };
  /*------------------------------------------------------------------------*/

  /*  Setup event listeners
  /*------------------------------------------------------------------------*/


  var _setupListeners = function _setupListeners() {
    // Init events for class=".js-block"
    $(document).on('click', '.js-block', _jsBlock);
    $(document).on('click', '.js-block-skip', _jsBlockSkip); // Init events for rel="external"

    $(document).on('click', "a[rel='external']", _relExternal);
    $(document).on('click', "a[rel='external nofollow']", _relExternal); // Init events for class=".js-popup"

    $(document).on('click', '.js-popup', _jsPopup);
  }; // Return an object exposed to the public


  return {
    matchHeight: _matchHeight,
    imgLiquidCustom: _imgLiquidCustom,
    offset: offset,

    /**
     * Global functions init
     */
    init: function init() {
      // Init several default functions
      _exportSvg();

      _imgLiquidCustom($('.js-image-liquid')); // init imageLiquid plugin


      _setupListeners(); // Setup the event listeners

    }
  };
}(); // Fully reference jQuery after this point.

/*------------------------------------------------------------------------*/

/*  Rodesk smoothscroll JS functions
/*------------------------------------------------------------------------*/


window.rodeskSmoothScroll = function () {
  /**
   * What to do at scroll click
   * @param {element} a string for the element identifier to pass to the plugin
   */
  var onScrollClick = function onScrollClick(element) {
    var elTarget = element.target;
    element.preventDefault();
    element.stopPropagation();
    var target = $(elTarget).attr('href');
    var scrollToPosition = $(target).offset().top;
    var headerHeight = $('.c-header').height();
    var scrollTo = scrollToPosition - headerHeight;
    $('html:not(:animated),body:not(:animated)').animate({
      scrollTop: scrollTo
    }, 700, function () {
      // use code below to add hash to url after click
      // window.location.hash = "" + target;
      $('html,body').animate({
        scrollTop: scrollTo
      }, 0); // reset the scroll position
    });
    return false;
  }; // Return an object exposed to the public


  return {
    /**
     * Init the plugin
     * @param { element } a string for the element identifier to pass to the scroll event handler
     */
    init: function init(element) {
      // Set scroller event handlers
      $(element).on('click', function (clickedElement) {
        onScrollClick(clickedElement);
      });
    }
  };
}(); // Fully reference jQuery after this point.

/*------------------------------------------------------------------------*/

/*  Rodesk menu functions
/*------------------------------------------------------------------------*/


window.rodeskMenu = function () {
  var settings, menuItems;
  /**
   * Define default settings
   *
   */

  var defaults = {
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

  var _disableScroll = function _disableScroll() {
    if ($(document).height() > $(window).height()) {
      // Set correct scroll position
      // Add no-scroll class
      var scrollTop = $('html').scrollTop() ? $('html').scrollTop() : $(document).scrollTop();
      $('html').attr('data-scrollpos', scrollTop);
      $('html').css('top', -scrollTop); // Wait till body animation is done.

      setTimeout(function () {
        $(settings.body).addClass(settings.classes.noScroll);
      }, 240);
    }
  };
  /**
   * Enable body scrolling
   */


  var _enableScroll = function _enableScroll() {
    // Set correct (old) scroll position
    // Remove no-scroll class from html
    var scrollTop = parseInt($('html').css('top'), 10);
    $(settings.body).removeClass(settings.classes.noScroll); // Check if scrollTop is not NaN
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


  var menuOpen = function menuOpen() {
    return $(settings.container).hasClass(settings.classes.open);
  };

  var _closeSubNav = function _closeSubNav() {
    $(settings.menuItemWrapper).removeClass(settings.classes.open);
  };

  var _toggleSubNav = function _toggleSubNav(event) {
    event.stopPropagation();
    var $toggle = $(event.currentTarget);
    var $wrapper = $toggle.closest(settings.menuItemWrapper);
    $wrapper.toggleClass(settings.classes.open);
  };
  /**
   * Toggle the main menu
   *
   */


  var _toggleMenu = function _toggleMenu() {
    // Check if menu has open class
    if (menuOpen()) {
      _enableScroll(); // Add active class to mobile menu toggle


      $(settings.toggleMenu).removeClass(settings.classes.open); // Toggle the mobile menu

      $(settings.container).removeClass(settings.classes.open);
    } else {
      _disableScroll(); // Add active class to mobile menu toggle


      $(settings.toggleMenu).addClass(settings.classes.open); // Toggle the mobile menu

      $(settings.container).addClass(settings.classes.open);
    }
  };
  /**
   * Close the main menu
   *
   */


  var closeMenu = function closeMenu() {
    _closeSubNav(); // Check if menu has open class


    if (menuOpen()) {
      _enableScroll(); // Add active class to mobile menu toggle


      $(settings.toggleMenu).removeClass(settings.classes.open); // Toggle the mobile menu

      $(settings.container).removeClass(settings.classes.open);
      $(settings.container).css({
        overflowY: 'hidden'
      });
    }
  };

  var setActiveMenuItem = function setActiveMenuItem() {
    menuItems.forEach(function (item) {
      item.classList.remove('is-active'); // Active item

      if (item.href === window.location.href) {
        item.classList.add('is-active');
      }
    });
  };
  /**
   * Listen to the "Esc" keypress
   * Close the menu when Esc is pressed
   */


  var _keyPress = function _keyPress(event) {
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


  var _bindEvents = function _bindEvents() {
    $(document).on('click.rodeskMenuToggle', settings.toggleMenu, _toggleMenu); // Bind keydown event

    $(document).on('keydown', _keyPress);
    $(document).on('click', settings.toggleSubNav, _toggleSubNav);
  };
  /**
   * Init module
   */


  var init = function init(options) {
    // Setup settings.
    options = options || {};
    settings = $.extend({}, defaults, options); // Get all menu links

    menuItems = Array.from(document.querySelectorAll(settings.menuItem)); // Bind events

    _bindEvents();
  }; // Return public functions


  return {
    init: init,
    // Init this function
    closeMenu: closeMenu,
    setActiveMenuItem: setActiveMenuItem
  };
}(); // Fully reference jQuery after this point.

/*------------------------------------------------------------------------*/

/*  Rodesk select functions
/*------------------------------------------------------------------------*/


window.rodeskSelect = function () {
  var settings;
  var defaults = {
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

  var _setCustomSelect = function _setCustomSelect(element) {
    // Init the customized selectbox
    var $select = element.selectize({
      copyClassesToDropdown: false,
      onDropdownOpen: function onDropdownOpen(dropdown) {
        dropdown.parents(settings.container).addClass(settings.openClass);
      },
      onDropdownClose: function onDropdownClose(dropdown) {
        dropdown.parents(settings.container).removeClass(settings.openClass);
      },
      // On init we want to add all original data attributes to the selctize options
      // By default selectize will remove all data atrributes when parsing options
      onInitialize: function onInitialize() {
        var selectBox = this;
        var $selectBox = $(this); // Loop all children of this select

        selectBox.revertSettings.$children.each(function () {
          // Check if this is an opt group
          var optgroup = $selectBox.is('optgroup'); // If optgroup we want to pase all children of the optgroup

          if (optgroup) {
            // Find all children of the optgroup
            var children = $selectBox.find('option'); // Loop all children of the optgroup

            children.each(function () {
              // Add original data atrributes to the selctize object
              $.extend(selectBox.options[selectBox.value], $selectBox.data());
            }); // If this is not an optgroup just parse all children
          } else {
            // Add original data atrributes to the selctize object
            $.extend(selectBox.options[selectBox.value], $selectBox.data());
          }
        });
      },
      onChange: function onChange(value) {
        if (this.$input.hasClass(settings.classes.selectUrl)) {
          transitionManager.redirect(value);
        }
      }
    });
    return $select;
  };

  var init = function init(options) {
    // Setup settings.
    options = options || {};
    settings = $.extend({}, defaults, options);
    $(settings.selectBox).each(function (index, element) {
      // Initiate simple custom selectbox
      _setCustomSelect($(element));
    });
  }; // Return an object exposed to the public


  return {
    init: init
  };
}(); // Fully reference jQuery after this point.

/*------------------------------------------------------------------------*/

/*  Rodesk image slider functions
/*------------------------------------------------------------------------*/


window.rodeskLazyLoad = function () {
  var settings, $lazyLoads, $lazyLoadsLoaded, $window, runEqualize;
  var defaults = {
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

  var getFilename = function getFilename(url) {
    if (url) {
      var m = url.toString().match(/.*\/(.+?)\./);

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


  var _getImageRatio = function _getImageRatio($element) {
    // Check if an image is defined
    if ($element.length > 0) {
      var width = $element.width(),
          aspect = $element.attr(settings.dataAttr.aspect),
          height = width * aspect; // If padding is defined return it

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


  var _resetImage = function _resetImage($element) {
    if ($element.length > 0) {
      // Remove the style attribute to reset the padding
      $element.removeAttr('style'); // Remove loading class

      $element.removeClass(settings.classes.loading); // Add loaded class

      $element.addClass(settings.classes.loaded);
    }
  };
  /**
   * Check if image is loaded
   *
   * @param object    $element  Object with lazy load element
   *
   */


  var _isLoaded = function _isLoaded($element) {
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


  var _setImage = function _setImage($element) {
    if ($element.length > 0 && !_isLoaded($element)) {
      // Get the height for this image
      var imageHeight = _getImageRatio($element); // Fill the alt element if it's empty


      if ($element.attr('alt') === '' && $element.attr('data-src') !== '') {
        $element.attr('alt', getFilename($element.attr('data-src')));
      } // Set loading class


      $element.addClass(settings.classes.loading); // Add padding for ratio

      $element.css({
        height: "".concat(imageHeight, "px")
      });
    }
  };
  /**
   * Loop all images for lazy loading and set there preferences
   *
   */


  var _setImages = function _setImages() {
    // Loop all the images to be lazyloaded
    $lazyLoads.each(function (index, element) {
      // Set image preferences
      _setImage($(element));
    });
  };
  /**
   * Check if an element is in view
   *
   */


  var _inview = function _inview(index, element) {
    // Define element
    var $element = $(element); // Return if element is not defined

    if (!$element) {
      return false;
    } // Return if element is hidden


    if ($element.is(':hidden')) {
      return false;
    } // Get screen and element mesurements


    var scrollTop = $window.scrollTop();
    var scrollBottom = scrollTop + $window.height();
    var elementTop = $element.offset().top;
    var elementBottom = elementTop + $element.outerHeight(true); // Check if the element is in the vieuwport

    if (elementBottom >= scrollTop - settings.treshold && elementTop <= scrollBottom + settings.treshold) {
      return $element;
    }

    return false;
  };
  /**
   * Prepare images for lazy loading
   *
   */


  var _lazyLoad = function _lazyLoad() {
    // Define the elements that are in the viewport
    var $inview = $lazyLoads.filter(_inview); // Trigger load event on elements in the viewport

    $lazyLoadsLoaded = $inview.trigger('loadImage'); // Remove loaded elements from the $lazyloads variable

    $lazyLoads = $lazyLoads.not($lazyLoadsLoaded);
  };
  /**
   * Load an image
   *
   * @param  object   event   The event object
   *
   */


  var _loadImage = function _loadImage(event) {
    var $image = $(event.target);
    var retina = window.devicePixelRatio > 1 || window.innerWidth >= settings.retinaWidth;
    var attrib = retina ? settings.dataAttr.srcRetina : settings.dataAttr.src;
    var source = $image.attr(attrib) ? $image.attr(attrib) : $image.attr(settings.dataAttr.src); // Check if data attributes are defined correctly.

    if (_typeof(source) === (typeof undefined === "undefined" ? "undefined" : _typeof(undefined)) || source === false) {
      return;
    } // If retina is required but not defined use default


    source = source || $image.attr(settings.src); // If source is defined replace src attribute

    if (source) {
      // Replace source attribute
      $image.attr('src', source); // Run some actions when loading is done

      $image.on('load', function () {
        // Reset the image and remove all added styles
        _resetImage($image); // Check if matchheight needs to be triggered


        if ($image.attr(settings.dataAttr.triggerMatchHeight) === '1') {
          if (!runEqualize) return;
          runEqualize = false; // Debounce equalize

          setTimeout(function () {
            $.fn.matchHeight._update();

            runEqualize = true;
          }, 500);
        } // Check if image needs image liquid


        if ($image.hasClass(settings.lazyLoadLiquid.replace('.', ''))) {
          // Define image liquid parent
          var liquidParent = $image.parent(); // Add image liquid class to parent

          liquidParent.addClass(settings.classes.liquid); // Init imgLiquid for this image

          rodeskDefaults.imgLiquidCustom(liquidParent);
        }
      });
    }
  };
  /**
   * Trigger resize to init lazyload
   *
   */


  var trigger = function trigger() {
    $window.trigger('resize');
  };
  /**
   * Bind events
   *
   */


  var _bindEvents = function _bindEvents() {
    // Bind set images event to resize
    $(window).on('resize', $.debounce(100, _setImages)); // Bind lazyload on resize/scroll

    $(window).on('resize', _lazyLoad);
    $(window).on('scroll', _lazyLoad); // Bind load event to lazyload objects

    $lazyLoads.on('loadImage', _loadImage);
  };
  /**
   * Setup the lazy load module
   *
   */


  var _setup = function _setup() {
    // Load lazy loads elements
    var images = Array.from(document.querySelectorAll(settings.lazyLoad));
    runEqualize = true;
    $lazyLoads = $(images.filter(function (image) {
      return image.getAttribute('data-src') !== '';
    })); // Setup window element

    $window = $(window); // Bind events

    _bindEvents(); // Set images


    _setImages();

    trigger();
  };
  /**
   * Init the lazy load module
   *
   * @param object    options     Object of passed options
   *
   */


  var init = function init(options) {
    // Setup settings.
    options = options || {};
    settings = $.extend({}, defaults, options); // Setup.

    _setup();
  };

  return {
    init: init,
    trigger: trigger
  };
}();
/*------------------------------------------------------------------------*/

/*  Rodesk inview functions
/*------------------------------------------------------------------------*/


window.rodeskInView = function () {
  var settings, windowHeight, $animationElements;
  /**
   * Default settings
   */

  var defaults = {
    elements: '.js-animation-element',
    treshold: 0.25,
    timeout: 200,
    classes: {
      inView: 'a-inview'
    }
  };
  /**
   * Check is element is in view
   * If element is in view add a class to it
   */

  var _checkInView = function _checkInView() {
    var windowTopPos = $(window).scrollTop(),
        windowBottomPos = windowTopPos + windowHeight; // Loop all elements to be animated

    $.each($animationElements, function (index, element) {
      var $elem = $(element),
          elemHeight = $elem.outerHeight() * settings.treshold,
          elemTopPos = $elem.offset().top,
          elemBotPos = elemTopPos + elemHeight; // Check if bottom position of element is bigger/equal to window top position
      // Also check if element top position is smaller/equal to window bottom position minus element height

      if (elemBotPos >= windowTopPos && elemTopPos <= windowBottomPos - elemHeight && !$elem.hasClass(settings.classes.inView)) {
        $elem.addClass(settings.classes.inView);
      }
    });
  };
  /**
   * Bind all events
   */


  var _bindEvents = function _bindEvents() {
    // Bind event to window resize
    $(window).on('resize', $.debounce(100, _checkInView)); // Bind event to window scroll

    $(window).on('scroll', $.throttle(100, _checkInView));
  };
  /**
   * Setup the module
   * Set the window heigt, animation elements
   * Use a timeout the set the initial check in view
   */


  var _setup = function _setup() {
    // Define window height
    windowHeight = $(window).height(); // Define the animation element to listed to

    $animationElements = $(settings.elements);
    setTimeout(function () {
      // Check if elements are in view
      _checkInView();
    }, settings.timeout);
  };
  /**
   * Init the module
   */


  var init = function init(options) {
    // Setup settings.
    options = options || {};
    settings = $.extend({}, defaults, options); // Setup the module

    _setup(); // Bind module events


    _bindEvents();
  };
  /**
   * Return an object exposed to the public
   */


  return {
    init: init
  };
}(); // Fully reference jQuery after this point.

/*------------------------------------------------------------------------*/

/*  Rodesk toggle module script
/*------------------------------------------------------------------------*/


window.rodeskToggle = function () {
  var settings;
  var defaults = {
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

  var _toggle = function _toggle(event) {
    var $this = $(event.currentTarget);
    var $parent = $("#".concat($this.attr(settings.data.parentId)));
    var $wrapper = $this.closest(settings.wrapper);

    if ($this.attr(settings.data.animationType) === 'jquery') {
      var $parentContent = $parent.find(settings.toggleContent);

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


  var _triggerDefault = function _triggerDefault() {
    var $elementToOpen = $(settings.toggleDefault);

    if ($elementToOpen.length > 0) {
      $elementToOpen.trigger('click');
    }
  };
  /**
   * Bind click events on toggle trigger
   *
   */


  var _bindEvents = function _bindEvents() {
    $(settings.trigger).on('click', _toggle);
  };

  var _setup = function _setup() {
    _bindEvents();

    _triggerDefault();
  };
  /**
   * Init module
   */


  var init = function init(options) {
    // Setup settings.
    options = options || {};
    settings = $.extend({}, defaults, options);

    _setup();
  }; // Return public functions


  return {
    init: init // Reveal init function

  };
}(); // Fully reference jQuery after this point.

/*------------------------------------------------------------------------*/

/*  Rodesk slick carousel module script
/*------------------------------------------------------------------------*/


window.rodeskSlickCarousel = function () {
  var settings, $carousel;
  var defaults = {
    carousel: '.js-carousel',
    carouselDots: '.slick-dots',
    carouselDotsContainer: '.c-carousel__dots',
    carouselPrev: '.js-carousel-prev',
    carouselNext: '.js-carousel-next',
    carouselSlide: '.slick-slide',
    carouselDelay: 0,
    carouselSettings: {
      arrows: false,
      accessibility: false,
      centerMode: false,
      centerPadding: 0,
      dots: true,
      draggable: false,
      slidesToShow: 1,
      lazyLoad: 'ondemand',
      useCSS: true,
      infinite: false,
      initialSlide: 0,
      fade: true,
      speed: 300,
      autoplay: true,
      autoplaySpeed: 5000,
      adaptiveHeight: true,
      swipe: true,
      pauseOnFocus: true,
      pauseOnHover: true,
      focusOnSelect: false,
      mobileFirst: false
    },
    callBacks: {
      init: function init() {
        setTimeout(function () {
          $.fn.matchHeight._update();
        }, 500);
      }
    }
  };
  /**
   * Init slick carousel
   *
   */

  var _initSlick = function _initSlick() {
    $carousel = $(settings.carousel);
    $carousel.on('init', settings.callBacks.init);
    $carousel.each(function (i, element) {
      $(element).slick({
        arrows: settings.carouselSettings.arrows,
        accessibility: settings.carouselSettings.accessibility,
        dots: settings.carouselSettings.dots,
        centerMode: settings.carouselSettings.centerMode,
        centerPadding: settings.carouselSettings.centerPadding,
        draggable: settings.carouselSettings.draggable,
        slidesToShow: settings.carouselSettings.slidesToShow,
        lazyLoad: settings.carouselSettings.lazyLoad,
        useCSS: settings.carouselSettings.useCSS,
        infinite: settings.carouselSettings.infinite,
        initialSlide: settings.carouselSettings.initialSlide,
        fade: settings.carouselSettings.fade,
        speed: settings.carouselSettings.speed,
        autoplay: settings.carouselSettings.autoplay,
        autoplaySpeed: settings.carouselSettings.autoplaySpeed,
        adaptiveHeight: settings.carouselSettings.adaptiveHeight,
        swipe: settings.carouselSettings.swipe,
        pauseOnFocus: settings.carouselSettings.pauseOnFocus,
        pauseOnHover: settings.carouselSettings.pauseOnHover,
        focusOnSelect: settings.carouselSettings.focusOnSelect,
        mobileFirst: settings.carouselSettings.mobileFirst,
        prevArrow: $(element).parent().find(settings.carouselPrev),
        nextArrow: $(element).parent().find(settings.carouselNext),
        responsive: settings.carouselSettings.responsive,
        rows: 0
      });
    });
  };

  var destroyCarousel = function destroyCarousel() {
    if ($carousel.hasClass(settings.classes.slickInitialized)) {
      $carousel.slick('unslick');
    }
  };

  var _setup = function _setup() {
    _initSlick();
  };
  /**
   * Init module
   */


  var init = function init(options) {
    // Setup settings.
    options = options || {};
    settings = $.extend(true, {}, defaults, options);

    if ($(settings.carousel).length > 0) {
      _setup();
    }
  }; // Return public functions


  return {
    init: init,
    // Init this function
    destroyCarousel: destroyCarousel
  };
}();
/*------------------------------------------------------------------------*/

/*  Rodesk empty module script
/*------------------------------------------------------------------------*/


window.rodeskPopup = function () {
  var settings;
  var defaults = {
    popup: '.js-modal-newsletter',
    popupContent: '.js-modal-content-newsletter',
    openTrigger: '.js-modal-newsletter-trigger',
    closeTrigger: '.js-modal-close',
    openHash: '#open-newsletter',
    closeHash: '#close-newsletter',
    classes: {
      open: 'is-open'
    }
  };
  /**
   * Close popup function
   *
   */

  var _closePopup = function _closePopup() {
    $(settings.popup).removeClass('is-open');
    $('body').off('click.closePopup').css('position', '');

    if (window.location.hash === settings.openHash) {
      window.location.hash = settings.closeHash;
    }
  };
  /**
   * Open popup function
   *
   */


  var _openPopup = function _openPopup() {
    var $popup = $(settings.popup);
    $('body').css('position', 'fixed');
    $('.js-modal-content-newsletter').css('min-height', '').css('overflow', 'scroll');

    if (!$popup.hasClass(settings.classes.open)) {
      $popup.addClass(settings.classes.open);
    }

    setTimeout(function () {
      $('body').on('click.closePopup', function () {
        _closePopup();
      });
      $(settings.popupContent).click(function (event) {
        event.stopPropagation();
      });
    }, 240);
    return false;
  };
  /**
   * Listen to the "Esc" keypress
   * Close the menu when Esc is pressed
   */


  var _keyPress = function _keyPress(event) {
    // Only run if pressed key is "Escape" a.k.a "27"
    // Also check if menu is open
    if (event.which === 27) {
      _closePopup();
    }
  };
  /**
   * Check if an hash is defined
   * if true open popup
   */


  var checkHash = function checkHash() {
    var hash = window.location.hash;

    if (hash && hash === settings.openHash) {
      _openPopup();
    }
  };
  /**
   * Bind reveal events
   * Close the cookie bar on click of the close button
   *
   */


  var _bindEvents = function _bindEvents() {
    $(settings.openTrigger).on('click', _openPopup);
    $(settings.closeTrigger).on('click', _closePopup);
    $(document).on('keydown', _keyPress);
    window.addEventListener('hashchange', checkHash);
  };

  var _setup = function _setup() {
    _bindEvents();
  };
  /**
   * Init module
   */


  var init = function init(options) {
    // Setup settings.
    options = options || {};
    settings = $.extend({}, defaults, options);

    _setup();
  }; // Return public functions


  return {
    init: init,
    // Init this function
    checkHash: checkHash
  };
}(jQuery); // Fully reference jQuery after this point.

/*------------------------------------------------------------------------*/

/*  Rodesk counter module script
/*------------------------------------------------------------------------*/


window.rodeskCounter = function () {
  var settings;
  var defaults = {
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

  var _disableButton = function _disableButton(button) {
    if (!button.classList.contains(settings.classes.disabled)) {
      button.disabled = true;
      button.classList.add(settings.classes.disabled);
    }
  };

  var _enableButton = function _enableButton(button) {
    if (button.classList.contains(settings.classes.disabled)) {
      button.disabled = false;
      button.classList.remove(settings.classes.disabled);
    }
  };

  var _inputObserver = function _inputObserver(input) {
    var amount = input.value;

    if (input.hasAttribute(settings.attr.maxAmount)) {
      var maxAmount = input.getAttribute(settings.attr.maxAmount);
      var wrapper = input.parentNode.parentNode;
      var increaseButton = wrapper.querySelector(settings.increaseButton);

      if (amount >= maxAmount) {
        _disableButton(increaseButton);
      } else {
        _enableButton(increaseButton);
      }
    }

    if (input.hasAttribute(settings.attr.minAmount)) {
      var minAmount = input.getAttribute(settings.attr.minAmount);
      var _wrapper = input.parentNode.parentNode;

      var decreaseButton = _wrapper.querySelector(settings.decreaseButton);

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


  var _decreaseCounter = function _decreaseCounter(event) {
    var button = event.currentTarget;
    var wrapper = button.parentNode;
    var input = wrapper.querySelector(settings.input);
    var changeWith = input.getAttribute('step') || 1;
    input.value = +input.value - +changeWith;
    $(input).trigger('change');

    _inputObserver(input);

    return false;
  };
  /**
   * Increase the value of the counter
   *
   */


  var _increaseCounter = function _increaseCounter(event) {
    var button = event.currentTarget;
    var wrapper = button.parentNode;
    var input = wrapper.querySelector(settings.input);
    var changeWith = input.getAttribute('step') || 1;
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


  var _bindEvents = function _bindEvents() {
    $(document).on('click', settings.increaseButton, _increaseCounter);
    $(document).on('click', settings.decreaseButton, _decreaseCounter);
  };

  var _setup = function _setup() {
    _bindEvents();
  };
  /**
   * Init module
   */


  var init = function init(options) {
    // Setup settings.
    options = options || {};
    settings = $.extend({}, defaults, options);

    if (document.querySelector(settings.wrapper)) {
      _setup();
    }
  }; // Return public functions


  return {
    init: init // Init this function

  };
}(jQuery); // Fully reference jQuery after this point.


function bindEvents() {
  // Sync custom variation selection markup with default WC variation selects
  $(document).on('change', '.js-select-shop, .js-radio ', function (event) {
    var $element = $(event.currentTarget);
    $(".variations select[name=\"".concat($element.attr('name'), "\"]")).val($element.val()).trigger('change');
  }); // Update the single product price when selecting variation(s)

  $(document).on('found_variation', function (event, variation) {
    $('.c-panorama__prices').html(variation.price_html);
  }); // Re-trigger lazyload when updating divs with AJAX

  $(document.body).on('updated_wc_div', function () {
    rodeskLazyLoad.init();
  });
}

var documentReady = function documentReady() {
  var matchHeightElements = [{
    target: '.js-match-height',
    options: {}
  }];
  rodeskDefaults.init(); // Init all default functions

  rodeskSmoothScroll.init('.js-smooth-scroll'); // Init smoothscroll plugin

  rodeskLazyLoad.init(); // Init the lazyload module

  rodeskPopup.init(); // Init de popup module

  rodeskToggle.init(); // Init the toggle module

  rodeskInView.init(); //  Init inview module

  rodeskCounter.init(); //  Init counter module

  rodeskDefaults.matchHeight(matchHeightElements);
  $('[data-featherlight]').featherlight(); // Init featherLight

  $('.js-append-around').appendAround(); // Init appendAround plugin

  if (rodeskBreakpoints.isBreakpoint('large')) {
    rodeskSelect.init({
      selectBox: '.js-select-shop'
    }); // Init customselect
  }

  rodeskSlickCarousel.init({
    carousel: '.js-product-detail-carousel',
    carouselSettings: {
      arrows: true,
      autoplay: false,
      fade: false,
      slidesToScroll: 1,
      dots: true,
      focusOnSelect: false,
      infinite: true
    }
  });
  bindEvents();
  $('.js-select-shop, .js-radio ').trigger('change');
};

document.addEventListener('DOMContentLoaded', function () {
  FastClick.attach(document.body); // Init fastclick for touch

  rodeskMenu.init(); // Init menu

  documentReady();
}); // Dirty fix to overload WC JS functions on jQuery's document ready.

jQuery(function ($) {
  $.scroll_to_notices = function () {
    return null;
  };
});
//# sourceMappingURL=webshop.js.map
