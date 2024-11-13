"use strict";

function _toConsumableArray(arr) { return _arrayWithoutHoles(arr) || _iterableToArray(arr) || _unsupportedIterableToArray(arr) || _nonIterableSpread(); }

function _nonIterableSpread() { throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }

function _iterableToArray(iter) { if (typeof Symbol !== "undefined" && Symbol.iterator in Object(iter)) return Array.from(iter); }

function _arrayWithoutHoles(arr) { if (Array.isArray(arr)) return _arrayLikeToArray(arr); }

var _updateMeta = Symbol("_updateMeta");

var _updateHeader = Symbol("_updateHeader");

var _updateNavigation = Symbol("_updateNavigation");

var _updateCampaignStyles = Symbol("_updateCampaignStyles");

var _updateBodyClasses = Symbol("_updateBodyClasses");

var _updateHtmlClasses = Symbol("_updateHtmlClasses");

var _disableExternalLinks = Symbol("_disableExternalLinks");

function _slicedToArray(arr, i) { return _arrayWithHoles(arr) || _iterableToArrayLimit(arr, i) || _unsupportedIterableToArray(arr, i) || _nonIterableRest(); }

function _nonIterableRest() { throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }

function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }

function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }

function _iterableToArrayLimit(arr, i) { if (typeof Symbol === "undefined" || !(Symbol.iterator in Object(arr))) return; var _arr = []; var _n = true; var _d = false; var _e = undefined; try { for (var _i = arr[Symbol.iterator](), _s; !(_n = (_s = _i.next()).done); _n = true) { _arr.push(_s.value); if (i && _arr.length === i) break; } } catch (err) { _d = true; _e = err; } finally { try { if (!_n && _i["return"] != null) _i["return"](); } finally { if (_d) throw _e; } } return _arr; }

function _arrayWithHoles(arr) { if (Array.isArray(arr)) return arr; }

function _typeof(obj) { "@babel/helpers - typeof"; if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof = function _typeof(obj) { return typeof obj; }; } else { _typeof = function _typeof(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof(obj); }

var _removeQuotes = Symbol("_removeQuotes");

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function"); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, writable: true, configurable: true } }); if (superClass) _setPrototypeOf(subClass, superClass); }

function _setPrototypeOf(o, p) { _setPrototypeOf = Object.setPrototypeOf || function _setPrototypeOf(o, p) { o.__proto__ = p; return o; }; return _setPrototypeOf(o, p); }

function _createSuper(Derived) { var hasNativeReflectConstruct = _isNativeReflectConstruct(); return function () { var Super = _getPrototypeOf(Derived), result; if (hasNativeReflectConstruct) { var NewTarget = _getPrototypeOf(this).constructor; result = Reflect.construct(Super, arguments, NewTarget); } else { result = Super.apply(this, arguments); } return _possibleConstructorReturn(this, result); }; }

function _possibleConstructorReturn(self, call) { if (call && (_typeof(call) === "object" || typeof call === "function")) { return call; } return _assertThisInitialized(self); }

function _assertThisInitialized(self) { if (self === void 0) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return self; }

function _isNativeReflectConstruct() { if (typeof Reflect === "undefined" || !Reflect.construct) return false; if (Reflect.construct.sham) return false; if (typeof Proxy === "function") return true; try { Date.prototype.toString.call(Reflect.construct(Date, [], function () {})); return true; } catch (e) { return false; } }

function _getPrototypeOf(o) { _getPrototypeOf = Object.setPrototypeOf ? Object.getPrototypeOf : function _getPrototypeOf(o) { return o.__proto__ || Object.getPrototypeOf(o); }; return _getPrototypeOf(o); }

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }

/*------------------------------------------------------------------------*/

/*  Renderers Class
/*------------------------------------------------------------------------*/
window.Renderers = function () {
  var Renderers = /*#__PURE__*/function () {
    function Renderers() {
      _classCallCheck(this, Renderers);

      this.renderers = {};
    }

    _createClass(Renderers, [{
      key: "exports",
      value: function exports(renderer) {
        this.renderers = Object.assign(this.renderers, renderer);
      }
    }, {
      key: "default",
      get: function get() {
        return this.renderers;
      }
    }]);

    return Renderers;
  }();

  var R = new Renderers();
  return R;
}();

(function () {
  var _highway = highway,
      Renderer = _highway.Renderer;

  var CustomRenderer = /*#__PURE__*/function (_Renderer) {
    _inherits(CustomRenderer, _Renderer);

    var _super = _createSuper(CustomRenderer);

    function CustomRenderer() {
      _classCallCheck(this, CustomRenderer);

      return _super.apply(this, arguments);
    }

    return CustomRenderer;
  }(Renderer);

  Renderers.exports({
    CustomRenderer: CustomRenderer
  });
})();
/*------------------------------------------------------------------------*/

/*  Transition Class
/*------------------------------------------------------------------------*/


window.Transitions = function () {
  var Transitions = /*#__PURE__*/function () {
    function Transitions() {
      _classCallCheck(this, Transitions);

      this.transitions = {};
    }

    _createClass(Transitions, [{
      key: "exports",
      value: function exports(transition) {
        this.transitions = Object.assign(this.transitions, transition);
      }
    }, {
      key: "animations",
      get: function get() {
        return this.transitions;
      }
    }]);

    return Transitions;
  }();

  var T = new Transitions();
  return T;
}();

(function () {
  var _highway2 = highway,
      Transition = _highway2.Transition;
  var loader = document.querySelector('.o-loader');

  var DefaultTransition = /*#__PURE__*/function (_Transition) {
    _inherits(DefaultTransition, _Transition);

    var _super2 = _createSuper(DefaultTransition);

    function DefaultTransition() {
      _classCallCheck(this, DefaultTransition);

      return _super2.apply(this, arguments);
    }

    _createClass(DefaultTransition, [{
      key: "out",
      value: function out(_ref) {
        //var done = _ref.done,
            //trigger = _ref.trigger;
        // Set loader default opacity and visibility
        //loader.style.opacity = 0;
        //loader.style.visibility = 'visible';
        /*anime({
          targets: loader,
          opacity: 1,
          duration: 400,
          easing: 'easeOutCubic',
          complete: function complete() {
          }
        });*/
            rodeskMenu.closeMenu();

            //if (trigger !== 'popstate') {
              //window.scrollTo(0, 0);
            //}

            //done();
            window.location.reload();
      }
    }, {
      key: "in",
      value: function _in(_ref2) {
        var from = _ref2.from,
            done = _ref2.done,
            to = _ref2.to;

        if (to.querySelector('.js-trigger-reload')) {
          window.location.reload();
        } // Remove old view


        from.remove();
        done(); // Set loader default opacity and visibility

        //loader.style.opacity = 1;
        //loader.style.visibility = 'visible';
        /*anime({
          targets: loader,
          opacity: 0,
          duration: 400,
          easing: 'easeOutCubic',
          complete: function complete() {

            //loader.style.visibility = 'hidden';
          }
        });*/
            rodeskInView.init(); // Init inview module
      }
    }]);

    return DefaultTransition;
  }(Transition);

  Transitions.exports({
    DefaultTransition: DefaultTransition
  });
})();

(function () {
  var _highway3 = highway,
      Transition = _highway3.Transition;

  var FilterTransition = /*#__PURE__*/function (_Transition2) {
    _inherits(FilterTransition, _Transition2);

    var _super3 = _createSuper(FilterTransition);

    function FilterTransition() {
      _classCallCheck(this, FilterTransition);

      return _super3.apply(this, arguments);
    }

    _createClass(FilterTransition, [{
      key: "out",
      value: function out(_ref3) {
        var from = _ref3.from,
            done = _ref3.done,
            trigger = _ref3.trigger;
        trigger.classList.add('is-active');
        from.querySelector('.c-filter.is-active').classList.remove('is-active');
        var oldCardWrapper = from.querySelector('.js-filter-container');
        var oldCards = from.querySelector('.js-filter-items');
        oldCardWrapper.style.position = 'relative';
        /*anime({
          targets: oldCards,
          opacity: [1, 0],
          duration: 400,
          easing: 'easeOutCubic',
          complete: function complete() {
            oldCardWrapper.innerHTML += '<span class="c-loader c-loader--circle">DIT IS EEN LOADER</span>';
            done();
          }
        });*/
        window.location.reload();
      }
    }, {
      key: "in",
      value: function _in(_ref4) {
        var from = _ref4.from,
            to = _ref4.to,
            done = _ref4.done;
        var oldCards = from.querySelector('.js-filter-items');
        var newCards = to.querySelector('.js-filter-items');
        oldCards.style.opacity = 0;
        newCards.style.opacity = 0;
        to.querySelectorAll('.js-animation-element').forEach(function (element) {
          element.classList.add('a-inview');
        });
        from.remove();
        done();
        /*anime({
          targets: newCards,
          opacity: 1,
          duration: 400,
          delay: 200,
          easing: 'easeOutCubic',
          complete: function complete() {
          }
        });*/
            newCards.removeAttribute('style');
      }
    }]);

    return FilterTransition;
  }(Transition);

  Transitions.exports({
    FilterTransition: FilterTransition
  });
})();

window.transitionManager = function () {
  var _highway4 = highway,
      Core = _highway4.Core; // const { CustomRenderer } = Renderers.default;

  var _Transitions$animatio = Transitions.animations,
      DefaultTransition = _Transitions$animatio.DefaultTransition,
      FilterTransition = _Transitions$animatio.FilterTransition;
  var transitionManager = new Core({
    // renderers: {
    //     default: CustomRenderer
    // },
    transitions: {
      default: DefaultTransition,
      contextual: {
        filter: FilterTransition
      }
    }
  });
  return transitionManager;
}();
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

/*  Rodesk video module
/*------------------------------------------------------------------------*/


window.rodeskVideo = function () {
  var settings;
  var defaults = {
    videoWrapper: '.js-video-wrapper',
    videoPlay: '.js-video-play',
    autoplay: true
  };
  /**
   * Setup the module
   *
   */

  var _videoType = function _videoType(event) {
    var $target = $(event.target);
    var videoId = $target.attr('data-id');
    var videoType = $target.attr('data-type');
    var $videoWrapper = $target.closest(settings.videoWrapper);
    var videoHeight = Math.ceil($videoWrapper.outerHeight());
    var videoWidth = Math.ceil($videoWrapper.outerWidth());
    var autoplayVimeo = settings.autoplay ? '?autoplay=1&muted=1' : '';
    var autoplayYoutube = settings.autoplay && rodeskBreakpoints.isBreakpoint('large') ? '?autoplay=1&mute=1' : '';

    if (videoType === 'vimeo') {
      $.ajax({
        url: "https://vimeo.com/api/v2/video/".concat(videoId, ".json"),
        dataType: 'jsonp',
        type: 'GET',
        success: function success() {
          $videoWrapper.html("<iframe src=\"https://player.vimeo.com/video/".concat(videoId).concat(autoplayVimeo, "\" width=\"").concat(videoWidth, "\" height=\"").concat(videoHeight, "\" frameborder=\"0\" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>"));
          fitvids($videoWrapper);
        }
      });
    } else if (videoType === 'youtube') {
      $.ajax({
        url: "https://www.googleapis.com/youtube/v3/videos?part=id,snippet&id=".concat(videoId).concat(autoplayYoutube, "&key=AIzaSyAXBfQgG0HgqLQmJW97m0ru9AOUXaM5O0I'"),
        dataType: 'jsonp',
        type: 'GET',
        success: function success() {
          $videoWrapper.html("<iframe src=\"https://www.youtube.com/embed/".concat(videoId).concat(autoplayYoutube, "\" width=\"").concat(videoWidth, "\" height=\"").concat(videoHeight, "\" frameborder=\"0\" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>"));
          fitvids($videoWrapper);
        }
      });
    }

    return false;
  };
  /**
   * Bind reveal events
   * Close the cookie bar on click of the close button
   *
   */


  var _bindEvents = function _bindEvents() {
    $(settings.videoPlay).on('click', _videoType);
  };
  /**
   * Init module
   */


  var _init = function _init(options) {
    // Setup settings.
    options = options || {};
    settings = $.extend({}, defaults, options);

    _bindEvents();
  }; // Return public functions


  return {
    init: _init // Init this function

  };
}(); // Fully reference jQuery after this point.
// ======= popup========
window.rodeskVideo1 = function () {
  var settings;
  var defaults = {
    videoWrapper: '.js-video-wrapper',
    videoPlay: '.js-video-popup-plays',
    autoplay: true
  };
  /**
   * Setup the module
   *
   */

  var _videoType1 = function _videoType1(event) {
    var $target = $(event.target);
    var videoId = $target.attr('data-id');
    var videoType = $target.attr('data-type');
    var $videoWrapper = $target.closest(settings.videoWrapper);
    var videoHeight = Math.ceil($videoWrapper.outerHeight());
    var videoWidth = Math.ceil($videoWrapper.outerWidth());
    var autoplayVimeo = settings.autoplay ? '?autoplay=1&muted=1' : '';
    var autoplayYoutube = settings.autoplay && rodeskBreakpoints.isBreakpoint('large') ? '?autoplay=1&mute=1' : '';

    $('.video_image_carousel .c-icon--prev').css("display","none");
    $('.video_image_carousel .c-icon--next').css("display","none");

    if (videoType === 'vimeo') {
       $('#videoModal').css("display","block");
      $.ajax({
        url: "https://vimeo.com/api/v2/video/".concat(videoId, ".json"),
        dataType: 'jsonp',
        type: 'GET',
        success: function success() {
          // $videoWrapper.html("<iframe src=\"https://player.vimeo.com/video/".concat(videoId).concat(autoplayVimeo, "\" width=\"").concat(videoWidth, "\" height=\"").concat(videoHeight, "\" frameborder=\"0\" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>"));
           $('#iframe-play-video').html("<iframe src=\"https://player.vimeo.com/video/".concat(videoId).concat(autoplayVimeo, "\" width=\"").concat(videoWidth, "\" height=\"").concat(videoHeight, "\" frameborder=\"0\" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>"));

          // fitvids($videoWrapper);
        }
      });
    } else if (videoType === 'youtube') {
       $('#videoModal').css("display","block");
      $.ajax({
        url: "https://www.googleapis.com/youtube/v3/videos?part=id,snippet&id=".concat(videoId).concat(autoplayYoutube, "&key=AIzaSyAXBfQgG0HgqLQmJW97m0ru9AOUXaM5O0I'"),
        dataType: 'jsonp',
        type: 'GET',
        success: function success() {
      //     $videoWrapper.html("<iframe src=\"https://www.youtube.com/embed/".concat(videoId).concat(autoplayYoutube, "\" width=\"").concat(videoWidth, "\" height=\"").concat(videoHeight, "\" frameborder=\"0\" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>"));
          $('#iframe-play-video').html("<iframe src=\"https://www.youtube.com/embed/".concat(videoId).concat(autoplayYoutube, "\" width=\"").concat(videoWidth, "\" height=\"").concat(videoHeight, "\" frameborder=\"0\" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>"));
      //     fitvids($videoWrapper);
        }
      });
    }

    return false;
  };
  /**
   * Bind reveal events
   * Close the cookie bar on click of the close button
   *
   */


  var _bindEvents = function _bindEvents() {
    $(settings.videoPlay).on('click', _videoType1);
  };
  /**
   * Init module
   */


  var _init = function _init(options) {
    // Setup settings.
    options = options || {};
    settings = $.extend({}, defaults, options);

    _bindEvents();
  }; // Return public functions


  return {
    init: _init // Init this function

  };
}(); // Fully reference jQuery after this point.
// ====== popup=========

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

    jQuery(".is-active").removeClass("is-active");
    jQuery(elTarget).closest('a').addClass("is-active");
    var theClass = jQuery(elTarget).attr("class");
    jQuery('.' + theClass).parent('a').addClass('is-active');

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

  /*
  Table portrait js start
  */

  /*jQuery('.parent-menu').click(function(){
     jQuery(this).closest.slideToggle();
  });*/
  //jQuery(".parent-menu .above-open-icon.open").parent('.menu-item-has-children').next().show();  
  jQuery(".parent-menu").on('click', function(e) {
    e.preventDefault();
    jQuery(this).find('.above-open-icon').toggleClass('open');  
    jQuery(this).next().slideToggle();
    jQuery(this).next().next('.show-mobile').slideToggle();
    return false;
  });
  jQuery(".above-right-icon").on('click', function(e) {
    window.location.replace(jQuery(this).parent().find('a').attr('href'));
  });

  jQuery(".parent-menu .above-open-icon").on('click', function(e) {
    e.preventDefault();
    jQuery(this).toggleClass('open');  
    jQuery(this).parent().next().slideToggle();
    jQuery(this).parent().next().next('.allview').slideToggle();
    return false;
  }); 

  jQuery(".parent-menu-above-open-icon").on('click', function(e) {
    e.preventDefault();
    jQuery(this).toggleClass('open');  
    jQuery(this).next().slideToggle();
    //jQuery(this).next().find('.parent-menu.click-event-none').next().show();
    //jQuery(this).next().find('.parent-menu.click-event-none').find('.above-open-icon').addClass('open');
    /*jQuery(this).next().find(".sub-to-sub-child").next().slideToggle();
    jQuery(this).next().find(".sub-to-sub-child").find('.above-open-icon').addClass('open');
    jQuery(".sub-to-sub-child .above-open-icon").parent().next().next('.show-mobile').slideToggle();*/
    //jQuery(this).next().find('.parent-menu.sub-menu').next().slideDown();
    //jQuery(this).next().find('.parent-menu.sub-menu').find('.above-open-icon').addClass('open');
    return false;
  });

  jQuery(".parent-menu-item").on('click', function(e) {
    jQuery(this).find(".parent-menu-above-open-icon").trigger("click");
    //return false;
  });

  //jQuery(".sub-to-sub-child .above-open-icon").parent().next().next('.show-mobile').show();  
  //jQuery(".sub-to-sub-child .above-open-icon").parent().next().slideDown();
  jQuery(".sub-to-sub-child .above-open-icon").on('click', function(e) {
    e.preventDefault();  
    jQuery(this).toggleClass('open');
    jQuery(this).parent().next().slideToggle();
    jQuery(this).parent().next().next('.show-mobile').slideToggle();
    return false;
  });

  jQuery(".sub-to-sub-child").on('click', function(e) {
    e.preventDefault();  
    jQuery(this).find('.above-open-icon').toggleClass('open');
    jQuery(this).next().slideToggle();
    jQuery(this).next().next('.show-mobile').slideToggle();
    return false;
  });

   /*
  Table portrait js end
  */


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

    jQuery('.js-modal-show-site-direction').removeClass('be-popup-open');
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

/*  Rodesk empty module script
/*------------------------------------------------------------------------*/


window.rodeskCompareSlider = function () {
  var settings, supportClipPath;
  var defaults = {
    container: '.js-compare-container',
    mask: '.js-compare-mask',
    indicator: '.js-compare-indicator',
    classes: {
      drag: 'js-compare-drag',
      resize: 'js-compare-resize'
    }
  };

  var testClipPath = function testClipPath() {
    var base = 'clipPath';
    var prefixes = ['webkit'];
    var properties = [base];
    var testElement = document.createElement('testelement');
    var attribute = 'inset(0 0 0 50%)'; // Push the prefixed properties into the array of properties.

    for (var i = 0, l = prefixes.length; i < l; i += 1) {
      var prefixedProperty = prefixes[i] + base.charAt(0).toUpperCase() + base.slice(1); // remember to capitalize!

      properties.push(prefixedProperty);
    } // Interate over the properties and see if they pass two tests.


    for (var _i = 0, _l = properties.length; _i < _l; _i += 1) {
      var property = properties[_i]; // First, they need to even support clip-path (IE <= 11 does not)...

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
    dragElement.on('mousedown vmousedown touchstart', function (e) {
      dragElement.addClass(settings.classes.drag);
      resizeElement.addClass(settings.classes.resize);
      var firstTouch;

      if (e.originalEvent.touches) {
        var _e$originalEvent$touc = _slicedToArray(e.originalEvent.touches, 1);

        firstTouch = _e$originalEvent$touc[0];
      }

      var firstPageX = firstTouch ? firstTouch.pageX : e.pageX;
      var dragWidth = dragElement.outerWidth();
      var xPosition = dragElement.offset().left + dragWidth - firstPageX;
      var containerOffset = container.offset().left;
      var containerWidth = container.outerWidth();
      var minLeft = containerOffset + 10;
      var maxLeft = containerOffset + containerWidth - dragWidth - 10;
      dragElement.parents().on('mousemove vmousemove touchmove', function (event) {
        var touch;

        if (event.originalEvent.touches) {
          var _event$originalEvent$ = _slicedToArray(event.originalEvent.touches, 1);

          touch = _event$originalEvent$[0];
        }

        var pageX = touch ? touch.pageX : event.pageX;
        var leftValue = pageX + xPosition - dragWidth;

        if (leftValue < minLeft) {
          leftValue = minLeft;
        } else if (leftValue > maxLeft) {
          leftValue = maxLeft;
        }

        var widthValue = "".concat((leftValue + dragWidth / 2 - containerOffset) * 100 / containerWidth, "%");
        var widthValuePX = "".concat(leftValue + dragWidth / 2 - containerOffset, "px");
        var heightValuePX = "".concat(container.outerHeight(), "px");

        if (supportClipPath) {
          $(".".concat(settings.classes.resize)).css({
            clipPath: "inset(0 0 0 ".concat(widthValue, ")"),
            '-webkit-clip-path': "inset(0 0 0 ".concat(widthValue, ")")
          });
        } else {
          $(".".concat(settings.classes.resize)).css('clip', function () {
            return "rect(0, ".concat(widthValuePX, ", ").concat(heightValuePX, ", 0)");
          });
        }

        $(".".concat(settings.classes.resize)).on('mouseup vmouseup touchend', function () {
          dragElement.removeClass(settings.classes.drag);
          resizeElement.removeClass(settings.classes.resize);
        });
        $(".".concat(settings.classes.drag)).css('left', widthValue);
      }).on('mouseup vmouseup touchend', function () {
        dragElement.removeClass(settings.classes.drag);
        resizeElement.removeClass(settings.classes.resize);
      });
      e.preventDefault();
    }).on('mouseup vmouseup touchend', function () {
      dragElement.removeClass(settings.classes.drag);
      resizeElement.removeClass(settings.classes.resize);
    });
  }
  /**
   * Bind mouse and touch events
   *
   */


  var _bindEvents = function _bindEvents() {
    var $compareIndicator = $(settings.container);
    $compareIndicator.each(function (i, item) {
      var actual = $(item);
      drags(actual.find(settings.indicator), actual.find(settings.mask), actual);
    });
  };

  var _setDefault = function _setDefault() {
    $(settings.container).each(function (index, element) {
      if (supportClipPath) {
        var $lastImage = $(element).find('.c-compare__image').last();
        $lastImage.addClass('js-compare-mask');
        var $container = $(settings.mask);
        $container.css({
          clipPath: "inset(0 0 0 50%)",
          '-webkit-clip-path': "inset(0 0 0 50%)"
        });
      } else {
        var $firstImage = $(element).find('.c-compare__image').first();
        $firstImage.addClass('js-compare-mask');

        var _$container = $(settings.mask);

        var widthValue = _$container.outerWidth() / 2;

        var heightValue = _$container.outerHeight();

        _$container.css('clip', function () {
          return "rect(0, ".concat(widthValue, "px, ").concat(heightValue, "px, 0)")
          /* <-- Removed semicolon */
          ;
        });
      }
    });
  };
  /**
   * Setup compare slider
   * Check if clip path is supported, add default mask and bindevents
   */


  var _setup = function _setup() {
    supportClipPath = testClipPath();

    _setDefault();

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
    init: init // Init this function

  };
}(jQuery); // Fully reference jQuery after this point.

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

/*  Rodesk Validate function
/*------------------------------------------------------------------------*/


window.rodeskValidate = function () {
  var settings;
  /**
   * Default settings
   */

  var defaults = {
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
    var $inputs = $formNode.find('input');
    var $button = $formNode.find(settings.button);
    var formurl = $formNode.attr('action');
    var $thanksMessage = $formParent.find(settings.responseMessage);
    var $errorMessage = $formParent.find(settings.errorMessage);
    var $itemsToHide = $formParent.find(settings.itemsToHide);
    var data = $formNode.serialize();
    var buttonText = $button.val(); // Add loading class to form

    $formNode.addClass(settings.classes.loading); // Disbale all input while sending AJAX request

    $inputs.attr('disabled', true);
    $button.attr('disabled', true); // Add disbaled class to the input and button fields

    $inputs.addClass(settings.classes.disabled);
    $button.addClass(settings.classes.disabled); // Use data attirbute for alternative loading text

    $button.val($formNode.attr(settings.dataAttr.loadText)); // AJAX login method

    $.ajax({
      type: 'POST',
      url: formurl,
      data: data,
      success: function success(response) {
        // Remove old error messages
        $errorMessage.remove(); // Add loading class to form

        $formNode.removeClass(settings.classes.loading); // Remove disbaled class to the input fields

        $inputs.removeClass(settings.classes.disabled);
        $button.removeClass(settings.classes.disabled); // Reset button text

        $button.val(buttonText); // Enable all input while sending AJAX request

        $inputs.attr('disabled', false);
        $button.attr('disabled', false); // Check if the response is failed

        if (response.data.messages && !response.success) {
          // Show new error messages
          response.data.messages.map(function (message) {
            return $formNode.prepend(message);
          });
        } else {
          // Hide the form if response is success
          $itemsToHide.hide(); // Show the succes message if response is success

          $thanksMessage.css({
            display: 'block'
          });
        }
      },
      error: function error(_error) {
        throw _error('Error sending data', _error);
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
      $form.on('submit', function (event) {
        event.preventDefault(); // Submit the form

        _sendForm($form, $formParent);
      }); // Run when a field validates with an error

      window.Parsley.on('field:error', function (fieldInstance) {
        var $errorContainer = $formParent.find('.js-error-message');
        var messages = fieldInstance.getErrorsMessages(); // Check if the are any message
        // If true show the error container

        if (messages) {
          $errorContainer.css({
            display: 'block'
          });
        }
      }); // Run when a field validates with success

      window.Parsley.on('field:success', function () {
        var $errorContainer = $formParent.find('.js-error-message');
        var $formFieldErrors = $form.find("".concat(settings.formItem, ".").concat(settings.classes.error)); // Check if there are no errors

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


  var _setup = function _setup() {
    var $formElements = $(settings.form);

    if ($formElements.length > 0) {
      $formElements.each(function (index, form) {
        var $form = $(form);
        var $formParent = $form.closest(settings.formParent); // Init Parsleyjs

        $form.parsley({
          errorClass: settings.classes.error,
          successClass: settings.classes.valid,
          errorsContainer: function errorsContainer() {
            return $('<div></div>').css('display', 'none');
          },
          classHandler: function classHandler(el) {
            return el.$element.closest(settings.formItem);
          }
        }); // Validate the form

        _bindEvents($form, $formParent);
      });
    }
  };
  /**
   * Init the module
   */


  var init = function init(options) {
    // Setup settings.
    options = options || {};
    settings = $.extend({}, defaults, options); // Setup the module

    _setup();
  };
  /**
   * Return an object exposed to the public
   */


  return {
    init: init
  };
}();
/*------------------------------------------------------------------------*/

/*  Rodesk head module
/*------------------------------------------------------------------------*/


window.rodeskUpdate = function () {
  /*
   * Use this class to update head on
   *
   *
   */
  var RodeskUpdate = /*#__PURE__*/function () {
    function RodeskUpdate() {
      _classCallCheck(this, RodeskUpdate);
    }

    _createClass(RodeskUpdate, [{
      key: _disableExternalLinks,
      value: function value() {
        var externalLinks = document.querySelectorAll('[rel="external"], [rel="external nofollow"], .disable-highyway a');
        externalLinks.forEach(function (link) {
          link.removeEventListener('click', transitionManager._navigate);
        });
      }
    }, {
      key: _updateHtmlClasses,
      value: function value(to) {
        document.documentElement.classList = to.page.documentElement.classList;
        document.documentElement.setAttribute('lang', to.page.documentElement.getAttribute('lang'));
      }
    }, {
      key: _updateBodyClasses,
      value: function value(to) {
        document.body.classList = to.page.body.classList;
      }
    }, {
      key: _updateCampaignStyles,
      value: function value(to) {
        var campaignStyle = document.querySelector('#rokit-campaign-styles');
        var newCampaignStyle = to.page.head.querySelector('#rokit-campaign-styles');

        if (document.body.classList.contains('body--single--campaign')) {
          if (transitionManager.cache.has(transitionManager.location.href)) {
            transitionManager.cache.delete(transitionManager.location.href);
          }

          if (campaignStyle) {
            campaignStyle.replaceWith(newCampaignStyle);
          } else {
            document.head.appendChild(newCampaignStyle);
          }
        } else {
          if (campaignStyle) {
            campaignStyle.remove();
          }
        }
      }
    }, {
      key: _updateNavigation,
      value: function value(to) {
        var headerTop = document.querySelector('.js-header-top');
        var newHeaderTop = to.page.body.querySelector('.js-header-top').cloneNode(true);
        headerTop.replaceWith(newHeaderTop);
        var headerBottom = document.querySelector('.js-header-bottom');
        var newHeaderBottom = to.page.body.querySelector('.js-header-bottom').cloneNode(true);
        headerBottom.replaceWith(newHeaderBottom);
        var footer = document.querySelector('.js-footer');
        var newFooter = to.page.body.querySelector('.js-footer').cloneNode(true);
        footer.replaceWith(newFooter);
        var langSwitch = document.querySelector('.js-lang-switch');
        var newlangSwitch = to.page.body.querySelector('.js-lang-switch').cloneNode(true);
        langSwitch.replaceWith(newlangSwitch);
      }
    }, {
      key: _updateHeader,
      value: function value(to) {
        document.querySelector('.js-header-top').classList = to.page.body.querySelector('.js-header-top').classList;
      }
    }, {
      key: _updateMeta,
      value: function value(to) {
        [].forEach.call(to.page.head.childNodes, function (node) {
          switch (node.nodeName) {
            case 'META':
              {
                var contentElement = document.querySelector("meta[property=\"".concat(node.getAttribute('property'), "\"]"));
                var nameElement = document.querySelector("meta[name=\"".concat(node.getAttribute('name'), "\"]"));

                if (contentElement !== null && node.hasAttribute('property')) {
                  contentElement.setAttribute('content', node.content);
                }

                if (nameElement !== null && node.hasAttribute('name')) {
                  nameElement.setAttribute('content', node.content);
                }

                break;
              }

            case 'LINK':
              {
                var element = document.querySelector("link[rel=\"".concat(node.getAttribute('rel'), "\"]"));

                if (element !== null && node.hasAttribute('rel') && node.getAttribute('rel') === 'canonical') {
                  element.setAttribute('href', node.getAttribute('href'));
                } else if (element == null && node.hasAttribute('rel') && node.getAttribute('rel') === 'canonical') {
                  var link = document.createElement('link');
                  link.rel = 'canonical';
                  link.href = transitionManager.location.href;
                  document.head.appendChild(link);
                }

                break;
              }

            default:
              break;
          }
        });
      }
      /**
       *
       *
       *
       */

    }, {
      key: "init",
      value: function init(to) {
        this[_updateNavigation](to);

        this[_updateHtmlClasses](to);

        this[_updateBodyClasses](to);

        this[_updateCampaignStyles](to);

        this[_updateHeader](to);

        this[_updateMeta](to);
      }
    }, {
      key: "disable",
      value: function disable() {
        this[_disableExternalLinks]();
      }
    }]);

    return RodeskUpdate;
  }();

  return new RodeskUpdate();
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

/*  Rodesk filter on taxonomy module script
/*------------------------------------------------------------------------*/


window.rodeskFilterTax = function () {
  var settings, $selectBox, wrapper, cards;
  var defaults = {
    select: '.js-filter-bodypart',
    wrapper: '.js-filter-wrapper',
    card: '.js-filter-card',
    attr: {
      filter: 'data-bodyparts'
    }
  };
  /**
   * Get filtered, active and inactive
   * @param {string} filter filtered data attribute
   */

  var _getFilteredCards = function _getFilteredCards(filter) {
    var active = _toConsumableArray(cards).filter(function (card) {
      return card.getAttribute(settings.attr.filter).includes(filter);
    });

    var inactive = _toConsumableArray(cards).filter(function (card) {
      return !card.getAttribute(settings.attr.filter).includes(filter);
    });

    return {
      active: active,
      inactive: inactive
    };
  };
  /**
   * animate filtered cards in and out with animejs.
   *
   */


  var _getFilterValue = function _getFilterValue(event) {
    var filterValue = event.target.value;

    var filteredCards = _getFilteredCards(filterValue);

    anime({
      targets: wrapper,
      translateY: 30,
      opacity: 0,
      duration: 300,
      easing: 'easeInOutQuad',
      complete: function complete() {
        setTimeout(function () {
          cards.forEach(function (element) {
            $(element.parentNode).remove();
          });
          filteredCards.active.forEach(function (element) {
            element.style.display = 'none';
            wrapper.appendChild(element.parentNode);
            element.style.display = 'block';
          });
          rodeskInView.init(); //  Init inview module

          rodeskLazyLoad.init(); // Init the lazyload module

          $(window).trigger('scroll');
          anime({
            targets: wrapper,
            translateY: 0,
            opacity: 1,
            duration: 300,
            easing: 'easeInOutQuad',
            complete: function complete() {
              // Trigger filter done event (used in cardHover.js)
              $(window).trigger('filter.rodeskDone');
            }
          });
        }, 200);
      }
    });
  };
  /**
   * Get filterable objects
   *
   */


  var _getFilterableObjects = function _getFilterableObjects() {
    wrapper = document.querySelector(settings.wrapper);
    cards = wrapper.querySelectorAll(settings.card);
  };
  /**
   * Bind selectbox change event
   *
   */


  var _bindEvents = function _bindEvents() {
    $selectBox.on('change', _getFilterValue);
  };

  var _setup = function _setup() {
    $selectBox = $(settings.select);

    _getFilterableObjects();

    _bindEvents();
  };
  /**
   * Init module
   */


  var init = function init(options) {
    // Setup settings.
    options = options || {};
    settings = $.extend({}, defaults, options);

    if ($(settings.wrapper).length > 0 && $(settings.card).length) {
      _setup();
    }
  }; // Return public functions


  return {
    init: init // Init this function

  };
}(jQuery); // Fully reference jQuery after this point.

/*------------------------------------------------------------------------*/

/*  Rodesk empty module script
/*------------------------------------------------------------------------*/


window.rodeskCardHover = function () {
  var settings;
  var defaults = {
    element: '.c-card--simple'
  };
  /**
   * Animate card function.
   *
   */

  var animateCard = function animateCard(element, scale, duration) {
    anime({
      targets: element,
      easing: 'easeOutCubic',
      scale: scale,
      duration: duration
    });
  };

  var enterCard = function enterCard(event) {
    animateCard(event.currentTarget, 1.03, 300);
  };

  var leaveCard = function leaveCard(event) {
    animateCard(event.currentTarget, 1.0, 300);
  };
  /**
   * Bind hover events
   *
   */


  var _bindEvents = function _bindEvents() {
    $(settings.element).on('mouseover', enterCard);
    $(settings.element).on('mouseleave', leaveCard);
  };

  var _setup = function _setup() {
    $(window).on('filter.rodeskDone', _bindEvents);

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
    init: init // Init this function

  };
}(); // Fully reference jQuery after this point.

/*------------------------------------------------------------------------*/

/*  Rodesk update scroll
/*------------------------------------------------------------------------*/


window.rodeskCampaginScroll = function () {
  var settings, defaultColor;
  var defaults = {
    backgroundColorElement: '.u-bg-campaign',
    target: '.js-campaign-card',
    panorama: '.js-campaign-panorama',
    data: {
      backgroundColor: 'data-background-color'
    }
  };

  var _updateBackgroundColor = function _updateBackgroundColor(entries) {
    entries.forEach(function (entry) {
      var isIntersecting = entry.isIntersecting,
          target = entry.target;

      if (isIntersecting) {
        var campaignColor = target.getAttribute(settings.data.backgroundColor);
        anime({
          targets: settings.backgroundColorElement,
          backgroundColor: campaignColor,
          duration: 400,
          easing: 'easeInOutCubic'
        });
      }
    });
  };

  var _setDefaultBackground = function _setDefaultBackground(entries) {
    entries.forEach(function (entry) {
      var isIntersecting = entry.isIntersecting;

      if (isIntersecting) {
        anime({
          targets: settings.backgroundColorElement,
          backgroundColor: defaultColor,
          duration: 400,
          easing: 'easeInOutCubic'
        });
      }
    });
  };
  /**
   * Bind intersection observer to campaign cards
   *
   */


  var _bindEvents = function _bindEvents() {
    var options = {
      threshold: 1
    };
    var observer = new IntersectionObserver(_updateBackgroundColor, options);
    var campaignCards = document.querySelectorAll(settings.target);

    _toConsumableArray(campaignCards).map(function (card) {
      return observer.observe(card);
    });

    var panoramaObserver = new IntersectionObserver(_setDefaultBackground, options);
    var panorama = document.querySelector(settings.panorama);
    panoramaObserver.observe(panorama);
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
    var panorama = document.querySelector(settings.panorama);
    var firstTarget = document.querySelector(settings.target);

    if (panorama && firstTarget) {
      defaultColor = firstTarget.getAttribute(settings.data.backgroundColor);
      panorama.style.backgroundColor = defaultColor;

      _setup();
    }
  }; // Return public functions


  return {
    init: init // Init this function

  };
}(jQuery); // Fully reference jQuery after this point.

/*------------------------------------------------------------------------*/

/*  Rodesk empty module script
/*------------------------------------------------------------------------*/


window.rodeskSwitch = function () {

  var settings;
  var defaults = {
    switch: '.js-switch',
    content: '.js-toggle-content',
    classes: {
      active: 'active'
    },
    dataAttr: {
      id: 'data-id'
    }
  };
  /**
   * Toggle switch function
   *
   */

  var _toggle = function _toggle(event) {
    var $switch = $(event.currentTarget);
    var type = $switch.attr(settings.dataAttr.id);
    $(settings.switch).removeClass(settings.classes.active);
    $switch.addClass(settings.classes.active);
    $(settings.content).removeClass(settings.classes.active);
    $("".concat(settings.content, "[").concat(settings.dataAttr.id, "=\"").concat(type, "\"]")).addClass(settings.classes.active);
  };
  /**
   * Bind click events
   *
   */


  var _bindEvents = function _bindEvents() {
    $(settings.switch).click(_toggle);
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

    if ($(settings.switch).length > 0) {
      _setup();
    }
    jQuery("#toggleswitch").change(function() {
      if(this.checked) {
       jQuery(".c-prices__button-switch .button-js-toggle-2").trigger( "click" );   
      }else{
       jQuery(".c-prices__button-switch .button-js-toggle-1").trigger( "click" );    
      }
    });

  }; // Return public functions



  return {
    init: init // Init this function

  };
}(jQuery); // Fully reference jQuery after this point.

/*------------------------------------------------------------------------*/

/* Focus search field when #search-focused is in url
/*------------------------------------------------------------------------*/


var focusSearchField = function focusSearchField(force) {
  if (!document.body.classList.contains('body--search')) {
    return;
  }

  var searchInput = document.querySelector('.js-search-input');
  var focussed = searchInput.getAttribute('data-focussed');

  if (force) {
    searchInput.focus();
  } else if (focussed) {
    setTimeout(function () {
      searchInput.focus();
    }, 100);
  }
};
/*------------------------------------------------------------------------*/

/* Only show clean button when search input is empty
/*------------------------------------------------------------------------*/


var _checkSearchCleanButton = function _checkSearchCleanButton() {
  var $searchInput = $('.js-search-input');
  var $cleanButton = $('.js-clean-search');

  if ($searchInput.length > 0 && $cleanButton.length > 0) {
    if ($searchInput.val().length === 0) {
      $cleanButton.css({
        opacity: 0
      });
    }

    $searchInput.on('keydown', function (event) {
      if (event.currentTarget.value.length > 0) {
        $cleanButton.css({
          opacity: 1
        });
      } else {
        $cleanButton.css({
          opacity: 0
        });
      }
    });
  }
};

window.addEventListener('load', function () {
  if (window.location.hash) {
    setTimeout(function() {
        $('html, body').scrollTop(0).show();
        $('html, body').animate({
            scrollTop: $(window.location.hash).offset().top - 100
            }, 1000)
    }, 0);
}
})

var documentReady = function documentReady() {
  window.addEventListener("scroll", scrollAnimate);
  window.addEventListener('scroll', handleVideoScroll);
  var html = document.documentElement;
  var matchHeightElements = [{
    target: '.js-match-height',
    options: {}
  }, {
    target: '.js-match-min-height',
    options: {
      property: 'min-height'
    }
  }];
  html.classList.remove('wf-loading', 'no-js');
  rodeskDefaults.init(); // Init all default functions
  
  rodeskSmoothScroll.init('.js-smooth-scroll'); // Init smoothscroll plugin
  rodeskSmoothScroll.init('.treatment-filters a'); // Init smoothscroll plugin
  rodeskSmoothScroll.init("a[href^='#']");
  rodeskLazyLoad.init(); // Init the lazyload module

  rodeskVideo.init(); // Init video module

  rodeskVideo1.init(); // Init video popup modules module

  rodeskPopup.init();
  rodeskDefaults.matchHeight(matchHeightElements);
  rodeskCompareSlider.init();
  rodeskToggle.init();
  rodeskInView.init(); //  Init inview module

  rodeskFilterTax.init();
  rodeskCampaginScroll.init();
  rodeskSwitch.init();
  $('[data-featherlight]').featherlight(); // Init featherLight

  focusSearchField();
  $('.js-append-around').appendAround(); // Init appendAround plugin

  rodeskUpdate.disable();
  rodeskValidate.init(); // Init validate module

  rodeskSlickCarousel.init({
    carousel: '.js-video-carousel',
    carouselSettings: {
      arrows: true,
      autoplay: false,
      slidesToShow: 1,
      slidesToScroll: 1,
      fade: false,
      dots: false,
      focusOnSelect: false,
      mobileFirst: true,
      responsive: [{
        breakpoint: 767,
        settings: {
          slidesToShow: 2
        }
      }, {
        breakpoint: 1699,
        settings: {
          slidesToShow: 3
        }
      }]
    }
  });
  
  rodeskSlickCarousel.init({
    carousel: '.js-card-carousel',
    carouselSettings: {
      arrows: true,
      autoplay: false,
      draggable: true,
      slidesToShow: 1,
      slidesToScroll: 1,
      fade: false,
      dots: false,
      focusOnSelect: false,
      centerMode: true,
      centerPadding: 20,
      infinite: true,
      mobileFirst: true,
      responsive: [{
        breakpoint: 1023,
        settings: {
          slidesToShow: 2,
          initialSlide: 1
        }
      }, {
        breakpoint: 1239,
        settings: {
          centerPadding: 80,
          slidesToShow: 3,
          initialSlide: 1
        }
      }, {
        breakpoint: 1920,
        settings: {
          slidesToShow: 4,
          initialSlide: 2
        }
      }]
    }
  });
  rodeskSlickCarousel.init({
    carousel: '.js-default-carousel',
    carouselSettings: {
      arrows: true,
      autoplay: false,
      slidesToScroll: 1,
      fade: false,
      dots: false,
      focusOnSelect: false
    }
  });
  rodeskSlickCarousel.init({
    carousel: '.js-panorama-carousel',
    carouselSettings: {
      arrows: true,
      autoplay: true,
      slidesToScroll: 1,
      fade: false,
      dots: false,
      focusOnSelect: false
    }
  });
  rodeskSlickCarousel.init({
    carousel: '.specialisten-slider',
    carouselSettings: {
      arrows: true,
      autoplay: true,
      slidesToShow: 4,
      fade: false,
      dots: false,
      focusOnSelect: false,
      responsive: [
    {
      breakpoint: 1024,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 2,
        infinite: false,
        dots: false
      }
    },
    {
      breakpoint: 600,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 2
      }
    },
    {
      breakpoint: 480,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1
      }
    }
  ]
    }
  });
  rodeskSlickCarousel.init({
    carousel: '.recent-blog-slider',
    carouselSettings: {
      arrows: true,
      autoplay: false,
      slidesToShow: 4,
      fade: false,
      dots: false,
      focusOnSelect: false,
      responsive: [
    {
      breakpoint: 1024,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 2,
        infinite: false,
        dots: false
      }
    },
    {
      breakpoint: 600,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 2
      }
    },
    {
      breakpoint: 480,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1
      }
    }
  ]
    }
  });

  rodeskSlickCarousel.init({
    carousel: '.deals-slider',
    carouselSettings: {
      arrows: true,
      autoplay: false,
      slidesToShow: 3,
      fade: false,
      dots: false,
      focusOnSelect: false,
      responsive: [
    {
      breakpoint: 1024,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 2,
        infinite: false,
        dots: false
      }
    },
    {
      breakpoint: 600,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 2
      }
    },
    {
      breakpoint: 480,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1
      }
    }
  ]
    }
  });

  rodeskSlickCarousel.init({
    carousel: '.reviews-slide',
    carouselSettings: {
      arrows: true,
      autoplay: true,
      slidesToShow: 2,
      fade: false,
      dots: false,
      focusOnSelect: false,
      responsive: [
    {
      breakpoint: 1024,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 2,
        infinite: false,
        dots: false
      }
    },
    {
      breakpoint: 600,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 2
      }
    },
    {
      breakpoint: 480,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1
      }
    }
  ]
    }
  });

  rodeskSlickCarousel.init({
    carousel: '.js-review-carousel',
    carouselSettings: {
      arrows: true,
      autoplay: true,
      slidesToShow: 2,
      fade: false,
      dots: false,
      focusOnSelect: false,
      responsive: [
    {
      breakpoint: 1024,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 2,
        infinite: false,
        dots: false
      }
    },
    {
      breakpoint: 600,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 2
      }
    },
    {
      breakpoint: 480,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1
      }
    }
  ]
    }
  });

  rodeskSlickCarousel.init({
    carousel: '.js-video-image-carousel',
    carouselSettings: {
      arrows: true,
      autoplay: true,
      slidesToShow: 4,
      fade: false,
      dots: false,
      focusOnSelect: false,
      responsive: [
    {
      breakpoint: 1024,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 2,
        infinite: false,
        dots: false
      }
    },
    {
      breakpoint: 600,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 2
      }
    },
    {
      breakpoint: 480,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1
      }
    }
  ]
    }
  });

  rodeskSlickCarousel.init({
    carousel: '.js-clinic-specialisten-list-carousel',
    carouselSettings: {
      arrows: true,
      autoplay: true,
      slidesToShow: 4,
      fade: false,
      dots: false,
      focusOnSelect: false,
      responsive: [
    {
      breakpoint: 1024,
      settings: {
        slidesToShow: 4,
        slidesToScroll: 4,
        infinite: false,
        dots: false
      }
    },
    {
      breakpoint: 600,
      settings: {
        slidesToShow: 4,
        slidesToScroll: 4
      }
    },
    {
      breakpoint: 480,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1
      }
    }
  ]
    }
  });
  rodeskSlickCarousel.init({
    carousel: '.js-video-image-slider',
    carouselSettings: {
      arrows: true,
      autoplay: false,
      slidesToShow: 2,
      fade: false,
      dots: false,
      focusOnSelect: false,
      responsive: [
    {
      breakpoint: 1024,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 2,
        infinite: false,
        dots: false
      }
    },
    {
      breakpoint: 768,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1
      }
    },
    {
      breakpoint: 480,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1
      }
    }
  ]
    }
  });
  $('.js-clean-search').on('click', function (event) {
    event.preventDefault();
    var $searchParent = $(event.currentTarget).closest('.js-search-form');
    var $searchInput = $searchParent.find('.js-search-input');
    $(event.currentTarget).css({
      opacity: 0
    });
    $searchInput.val('');
    focusSearchField(true);
  });
  $('.js-open-chat').on('click', function (event) {
    event.preventDefault();
    var iframe = $('.obiChatLauncher');
    var button = iframe.contents().find('button');
    button.trigger('click');
  });

  _checkSearchCleanButton();

  if (typeof documentReadyMain === 'function') {
    documentReadyMain();
  }

  if (window.location.href.indexOf("/nl") > -1 || window.location.href.indexOf("/ch") > -1) {
  }else{
    if ($.cookie('whenToShowDialog') == null) {
          // Create expiring cookie, 30 days from now:
          var date = new Date();
          date.setTime(date.getTime() + (180 * 1000));
          $.cookie('whenToShowDialog', 'yes', { expires: 30, path: '/' });  // expires after 30 days

          // Show popup
          jQuery('.js-modal-show-site-direction').addClass('be-popup-open'); 
      }
  }

  /* Video section slider - new design on home page and news cateory section */
  var video_slider = $('.custom_video_slider').slick({
      arrows : false,
      autoplay: false,
      swipeToSlide: true,
      autoplaySpeed: 3000, // Set the autoplay speed (in milliseconds)
      vertical: true, // Enable vertical sliding
      verticalSwiping: true, // Enable vertical swiping
      slidesToShow: 1, // Number of slides to show at a time
      slidesToScroll: 1, // Number of slides to scroll,
      dots: true,
      infinite: false
  });

  if ($('.custom_video_slider').find('.container__wrap__below').length > 0) {
    $('.custom_video_slider .slick-dots').addClass('video_first');
  }
  video_slider.on('beforeChange', function(event, slick, currentSlide, nextSlide) {
    if( $('.custom_video_slider').find('.container__wrap__below').length > 0 ) {
      if (nextSlide === 0 ) {
        $('.slick-dots').addClass('video_first');
      } else {
        $('.slick-dots').removeClass('video_first');
      }
    }
  });

  video_slider.on('wheel', (function(e) {
    e.preventDefault();
    if (e.originalEvent.deltaY > 0) {
      jQuery(this).slick('slickNext');
    } else {
      jQuery(this).slick('slickPrev');
    }
  }));

  video_slider.on('afterChange', function(event, slick, currentSlide) {
    // Remove active class from all a tags
    $('.slick-bottom-nav__wrap a').removeClass('sbn-item-active');
    // Add active class to the corresponding a tag
    $('.slick-bottom-nav__wrap a[data-slide="' + currentSlide + '"]').addClass('sbn-item-active');

    if (currentSlide === slick.slideCount - 1) {
      // Add class to the navigation dot element of the last slide
      $('.slick-dots', this).addClass('lastSlickDots');
    } else {
      // Remove the class from other navigation dots
      $('.slick-dots', this).removeClass('lastSlickDots');
    }

  });


  /* News design - slider implementation */
  $('.news-listing-wrap .news_desktop_wrap').each(function(index, element) {
    // Function to perform on each item
    $(element).slick({
      arrows : true,
      infinite: true,
      autoplay: true,
      autoplaySpeed: 3000, // Set the autoplay speed (in milliseconds)
      slidesToShow: 3, // Number of slides to show at a time
      slidesToScroll: 1, // Number of slides to scroll
      prevArrow: '<button type="button" class="slick-prev slick-arrow c-icon c-icon--round c-icon--lg c-icon--arrow c-icon--prev js-carousel-prev"><i class="arrow left"></i></button>',
      nextArrow: '<button type="button" class="slick-next slick-arrow c-icon c-icon--round c-icon--lg c-icon--arrow c-icon--next js-carousel-next"><i class="arrow right"></i></button>'
   });
  });

  $(document).ready(function() {
    jQuery('.taggbox').parents('.review-shortcode').addClass('taggboxContent');
    jQuery('.blog-left-content-part .blog-fullwidth-start').nextAll().remove();
    jQuery('.blog-full-width-content .blog-fullwidth-start').prevAll().remove();
    // Handle navigation link click
    $('.slick-bottom-nav__wrap a:first-child').addClass('sbn-item-active');
    $('.slick-bottom-nav__wrap  a').click(function(e) {
      e.preventDefault();
      // Get the target slide index from the data-slide attribute
      var targetSlide = $(this).data('slide');
      // Change the active slide to the target slide
      video_slider.slick('slickGoTo', targetSlide);
    });

    const video = document.getElementById("vid");
    const playPauseButton = document.querySelector(".play");

     playPauseButton.addEventListener("click", function () {
        if (video.paused) {
           video.play();
           playPauseButton.classList.remove("play");
           playPauseButton.classList.add("pause");
        } else {
           video.pause();
           playPauseButton.classList.remove("pause");
           playPauseButton.classList.add("play");
        }
     });
    // Pause the video initially
    video.pause();
  });



  jQuery('.js-modal-show-site-direction .js-modal-close').click(function(){
    jQuery('.js-modal-show-site-direction').removeClass('be-popup-open');
  });

  jQuery('body').click(function(e){
    if (!$(e.target).closest('.js-form-wrapper').length){
      jQuery('.js-modal-show-site-direction').removeClass('be-popup-open');
    }
  });
};

/*function removePageTransitions() {
  $('.o-loader').hide();
  var allLinks = document.querySelectorAll('a'); // Remove Listener at Runtime

  [].forEach.call(allLinks, function (link) {
    // do whatever
    link.removeEventListener('click', transitionManager._navigate);
  });
}*/

document.addEventListener('DOMContentLoaded', function () {
  FastClick.attach(document.body); // Init fastclick for touch

  rodeskMenu.init(); // Init menu

  setTimeout(function () {
    document.getElementById("defaultOpenTwo").click();
    document.getElementById("defaultOpen").click();
  }, 100);

  /*if (typeof window.fetch === 'undefined') {
    removePageTransitions();
  }*/

  documentReady();
  rodeskPopup.checkHash();

  const video = document.getElementById("vid");
  const playPauseButton = document.querySelector(".play");

   playPauseButton.addEventListener("click", function () {
      if (video.paused) {
         video.play();
         playPauseButton.classList.remove("play");
         playPauseButton.classList.add("pause");
      } else {
         video.pause();
         playPauseButton.classList.remove("pause");
         playPauseButton.classList.add("play");
      }
   });
  // Pause the video initially
  video.pause();
  jQuery('.blog-left-content-part .blog-fullwidth-start').nextAll().remove();
  jQuery('.blog-full-width-content .blog-fullwidth-start').prevAll().remove();
}); // transitionManager.on('NAVIGATE_OUT', () => {});

transitionManager.on('NAVIGATE_END', function () {
  documentReady();

  if ($('.js-masonry').length > 0 && $('.js-masonry .o-grid__cell').length === 0) {
    var masonryGrid = document.querySelector('.js-masonry');
    salvattore.registerGrid(masonryGrid);
  }

  if (typeof acalltracker !== 'undefined' && siteInfo.environment === 'production') {
    acalltracker.dynamicPageload();
  }
});
transitionManager.on('NAVIGATE_IN', function (_ref5) {
  var to = _ref5.to;
  rodeskMenu.setActiveMenuItem();
  rodeskUpdate.init(to);
});

window.documentReadyMain = function () {
  // const matchHeightElements = [];
  // rodeskDefaults.matchHeight(matchHeightElements);
  rodeskSelect.init(); // Init customselect

  rodeskCardHover.init();
  objectFitPolyfill();

  var towrap = ".worldwide-carousel-component";
  $(towrap).each(function(){
      $(this).not(towrap + "+" + towrap).each(function(){
          $(this).nextUntil(":not(" + towrap + ")").addBack().wrapAll('<div class="w-merge-component">');
      });
  })
  var imageUrl = jQuery('.worldwide-carousel-component').attr('bg-image-url');
  jQuery('.w-merge-component').css('background-image', 'url(' + imageUrl + ')');
};


jQuery(".tab").click(function(event) {
  jQuery(".tab").removeClass("active"); 
  jQuery(this).addClass("active");  
});

jQuery(".first-deal-btn").click(function(event) {
  jQuery("#eerste .c-accordion div:nth-child(1)").addClass("show");
});
jQuery("#eerste .c-accordion__heading").click(function(event) {
  jQuery("#eerste .c-accordion div:nth-child(1)").removeClass("show"); 
});
jQuery(".second-deal-btn").click(function(event) {
  jQuery("#tweede .c-accordion div:nth-child(1)").addClass("show");
});
jQuery("#tweede .c-accordion__heading").click(function(event) {
  jQuery("#tweede .c-accordion div:nth-child(1)").removeClass("show"); 
});
jQuery(".third-deal-btn").click(function(event) {
  jQuery("#derde .c-accordion div:nth-child(1)").addClass("show");
});
jQuery("#derde .c-accordion__heading").click(function(event) {
  jQuery("#derde .c-accordion div:nth-child(1)").removeClass("show"); 
});
jQuery(".fourth-deal-btn").click(function(event) {
  jQuery("#vierde .c-accordion div:nth-child(1)").addClass("show");
});
jQuery("#vierde .c-accordion__heading").click(function(event) {
  jQuery("#vierde .c-accordion div:nth-child(1)").removeClass("show"); 
});
jQuery("#toggleswitch").change(function() {
    if(this.checked) {
     jQuery(".c-prices__button-switch .button-js-toggle-2").trigger( "click" );
    }else{
     jQuery(".c-prices__button-switch .button-js-toggle-1").trigger( "click" );    
    }
    if(jQuery('.column-price-1').hasClass('active')){
        jQuery('.column-price-2').hide();
        jQuery('.column-price-1').show();
    } 
    else if(jQuery('.column-price-2').hasClass('active')){
        jQuery('.column-price-1').hide();
        jQuery('.column-price-2').show();
    }
});
if(jQuery('.column-price-1').hasClass('active')){
    jQuery('.column-price-2').hide();
    jQuery('.column-price-1').show();
} 
else if(jQuery('.column-price-2').hasClass('active')){
    jQuery('.column-price-1').hide();
    jQuery('.column-price-2').show();
}

jQuery(".make-an-appointment-modal").click(function(event) {
   if(jQuery(".show-appointment-modal").attr('data-featherlight') == "#appointment" ){
      jQuery(".show-appointment-modal").trigger('click');
   }
});

jQuery(".make-an-appointment-pages").click(function(event) {
     $('html,body').animate({
        scrollTop: $("#appointment-cards").offset().top},
     'slow');
});

jQuery(".click-btn").click(function(event) {
    jQuery(".c-contacts-btn").trigger('click');
});

if(jQuery('.component-slider .c-panorama--mask').hasClass('video-part')){
  jQuery('.component-slider').addClass('video-slide');
}else{
  jQuery('.component-slider').removeClass('video-slide');
}

window.onbeforeunload = function () {
  window.scrollTo(0, 0);
}

function openTab(evt, tabID) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("treatmentTabContent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(tabID).style.display = "block";
  evt.currentTarget.className += " active";
}

function openTab2(evt, tabID) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("treatmentTabTwoContent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tabTwolinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(tabID).style.display = "block";
  evt.currentTarget.className += " active";
}

function closePopup(){
  $("#videoModal").fadeOut();
  $('.video_image_carousel .c-icon--prev').css("display","block");
  $('.video_image_carousel .c-icon--next').css("display","block");
}

jQuery(document).on("click",".open-down-arrow",function() {
    jQuery(this).find('.arrow').toggleClass("up");
    jQuery(this).parents('.c-heading--agenda').next('.u-flex').find('.o-list-plain').slideToggle();
});

jQuery(document).ready(function($) {

  var homeFlex = jQuery('.home-flexbox');
  if (homeFlex.children().length === 0) {
    homeFlex.addClass('home-empty');
  }

  jQuery('link').each(function() {
    // Check if the <link> element has a "rel" attribute value of "alternate" and a "hreflang" attribute value
    if (jQuery(this).attr('rel') === 'alternate' && jQuery(this).attr('hreflang')) {
      // Append the <link> element to the <head> element
      jQuery(this).appendTo('head');
    }
  });
  document.getElementById("defaultOpen").click();
  document.getElementById("defaultOpenTwo").click();
});

function scrollAnimate() {
  var reveals = document.querySelectorAll(".scroll-anim");
  for (var i = 0; i < reveals.length; i++) {
    var windowHeight = window.innerHeight;
    var elementTop = reveals[i].getBoundingClientRect().top;
    var elementVisible = 370;
    if(reveals){
      if (elementTop < windowHeight - elementVisible) {
        reveals[i].classList.add("active");
      } else {
        reveals[i].classList.remove("active");
      }
    }
  }
}

// Function to handle the scroll event
/* Custom js code to play current video on scroll */
const videos = document.querySelectorAll('.video-element .video');
// Store the current playing video
let currentVideo = null;
// Function to play the video and pause all others
function playCurrentVideo(video) {
    // Pause all videos except the current one
    videos.forEach((videoElement) => {
      if (videoElement !== video) {
        videoElement.pause();
      }
    });
    // Play the current video
    video.play();
    // Update the currentVideo variable
    currentVideo = video;
}

function handleVideoScroll() {
  // Find the video that is currently in the viewport
  const currentViewportVideo = Array.from(videos).find((video) => {
    const rect = video.getBoundingClientRect();
    return rect.top >= 0 && rect.bottom <= window.innerHeight;
  });

  // If a video is found, play it
  if (currentViewportVideo) {
    // Only play if it's a different video than the current one
    if (currentViewportVideo !== currentVideo) {
      playCurrentVideo(currentViewportVideo);
    }
  } else {
    // If no video is found, pause the current video
    if (currentVideo) {
      currentVideo.pause();
      currentVideo = null;
    }
  }
}
jQuery(".desktop-o-nav, .c-header").hover(
  function() { 
    jQuery('.desktop-hamburger span').toggleClass('rm-hover');
  }
);

// Blur image show
jQuery(".blur-image-view").on("click",function(){
  jQuery(this).parents().removeClass('show-blur-image');
  jQuery(this).parent().hide();
});

// Blur video show
jQuery(".c-panoaram-video .blur-image-view").on("click",function(){
  jQuery(this).parents().removeClass('show-blur-image');
  jQuery(this).parent().hide();
  jQuery(this).parents().find('.c-video .c-video__play').click();
});


//# sourceMappingURL=main.js.map