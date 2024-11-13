"use strict";

function _toConsumableArray(arr) {
    return _arrayWithoutHoles(arr) || _iterableToArray(arr) || _unsupportedIterableToArray(arr) || _nonIterableSpread()
}

function _nonIterableSpread() {
    throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")
}

function _iterableToArray(iter) {
    if (typeof Symbol !== "undefined" && Symbol.iterator in Object(iter)) return Array.from(iter);
}

function _arrayWithoutHoles(arr) {
    if (Array.isArray(arr)) return _arrayLikeToArray(arr);
}
var _updateMeta = Symbol("_updateMeta");
var _updateHeader = Symbol("_updateHeader");
var _updateNavigation = Symbol("_updateNavigation");
var _updateCampaignStyles = Symbol("_updateCampaignStyles");
var _updateBodyClasses = Symbol("_updateBodyClasses");
var _updateHtmlClasses = Symbol("_updateHtmlClasses");
var _disableExternalLinks = Symbol("_disableExternalLinks");

function _slicedToArray(arr, i) {
    return _arrayWithHoles(arr) || _iterableToArrayLimit(arr, i) || _unsupportedIterableToArray(arr, i) || _nonIterableRest()
}

function _nonIterableRest() {
    throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")
}

function _unsupportedIterableToArray(o, minLen) {
    if (!o) return;
    if (typeof o === "string") return _arrayLikeToArray(o, minLen);
    var n = Object.prototype.toString.call(o).slice(8, -1);
    if (n === "Object" && o.constructor) n = o.constructor.name;
    if (n === "Map" || n === "Set") return Array.from(o);
    if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen);
}

function _arrayLikeToArray(arr, len) {
    if (len == null || len > arr.length) len = arr.length;
    for (var i = 0, arr2 = new Array(len); i < len; i++) {
        arr2[i] = arr[i]
    }
    return arr2
}

function _iterableToArrayLimit(arr, i) {
    if (typeof Symbol === "undefined" || !(Symbol.iterator in Object(arr))) return;
    var _arr = [];
    var _n = !0;
    var _d = !1;
    var _e = undefined;
    try {
        for (var _i = arr[Symbol.iterator](), _s; !(_n = (_s = _i.next()).done); _n = !0) {
            _arr.push(_s.value);
            if (i && _arr.length === i) break
        }
    } catch (err) {
        _d = !0;
        _e = err
    } finally {
        try {
            if (!_n && _i["return"] != null) _i["return"]();
        } finally {
            if (_d) throw _e
        }
    }
    return _arr
}

function _arrayWithHoles(arr) {
    if (Array.isArray(arr)) return arr
}

function _typeof(obj) {
    "@babel/helpers - typeof";
    if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") {
        _typeof = function _typeof(obj) {
            return typeof obj
        }
    } else {
        _typeof = function _typeof(obj) {
            return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj
        }
    }
    return _typeof(obj)
}
var _removeQuotes = Symbol("_removeQuotes");

function _inherits(subClass, superClass) {
    if (typeof superClass !== "function" && superClass !== null) {
        throw new TypeError("Super expression must either be null or a function")
    }
    subClass.prototype = Object.create(superClass && superClass.prototype, {
        constructor: {
            value: subClass,
            writable: !0,
            configurable: !0
        }
    });
    if (superClass) _setPrototypeOf(subClass, superClass);
}

function _setPrototypeOf(o, p) {
    _setPrototypeOf = Object.setPrototypeOf || function _setPrototypeOf(o, p) {
        o.__proto__ = p;
        return o
    };
    return _setPrototypeOf(o, p)
}

function _createSuper(Derived) {
    var hasNativeReflectConstruct = _isNativeReflectConstruct();
    return function() {
        var Super = _getPrototypeOf(Derived),
            result;
        if (hasNativeReflectConstruct) {
            var NewTarget = _getPrototypeOf(this).constructor;
            result = Reflect.construct(Super, arguments, NewTarget)
        } else {
            result = Super.apply(this, arguments)
        }
        return _possibleConstructorReturn(this, result)
    }
}

function _possibleConstructorReturn(self, call) {
    if (call && (_typeof(call) === "object" || typeof call === "function")) {
        return call
    }
    return _assertThisInitialized(self)
}

function _assertThisInitialized(self) {
    if (self === void 0) {
        throw new ReferenceError("this hasn't been initialised - super() hasn't been called")
    }
    return self
}

function _isNativeReflectConstruct() {
    if (typeof Reflect === "undefined" || !Reflect.construct) return !1;
    if (Reflect.construct.sham) return !1;
    if (typeof Proxy === "function") return !0;
    try {
        Date.prototype.toString.call(Reflect.construct(Date, [], function() {}));
        return !0
    } catch (e) {
        return !1
    }
}

function _getPrototypeOf(o) {
    _getPrototypeOf = Object.setPrototypeOf ? Object.getPrototypeOf : function _getPrototypeOf(o) {
        return o.__proto__ || Object.getPrototypeOf(o)
    };
    return _getPrototypeOf(o)
}

function _classCallCheck(instance, Constructor) {
    if (!(instance instanceof Constructor)) {
        throw new TypeError("Cannot call a class as a function")
    }
}

function _defineProperties(target, props) {
    for (var i = 0; i < props.length; i++) {
        var descriptor = props[i];
        descriptor.enumerable = descriptor.enumerable || !1;
        descriptor.configurable = !0;
        if ("value" in descriptor) descriptor.writable = !0;
        Object.defineProperty(target, descriptor.key, descriptor)
    }
}

function _createClass(Constructor, protoProps, staticProps) {
    if (protoProps) _defineProperties(Constructor.prototype, protoProps);
    if (staticProps) _defineProperties(Constructor, staticProps);
    return Constructor
}
jQuery(document).ready(function($) {
    let isExpanded = !1;
    const readMoreContent = $(".location-info-section .read-more-content");
    const toggleButton1 = $(".location-info-section #toggleReadMoreButton");
    toggleButton1.on("click", function() {
        isExpanded = !isExpanded;
        const readMoreContent = jQuery(this).parents(".location-info-section").find(".read-more-content");
        if (isExpanded) {
            readMoreContent.show();
            readMoreContent.prev(".show-paragraph-content").hide();
            jQuery(this).parents(".location-info-section").find(".showLess").show();
            jQuery(this).parents(".location-info-section").find(".showMore").hide()
        } else {
            readMoreContent.hide();
            readMoreContent.prev(".show-paragraph-content").show();
            jQuery(this).parents(".location-info-section").find(".showMore").show();
            jQuery(this).parents(".location-info-section").find(".showLess").hide()
        }
    });
    const $toggleButton = $(".treatment-title-content #toggleReadMoreButton");
    let $isExpanded = !1;
    $toggleButton.on("click", function() {
        $isExpanded = !$isExpanded;
        const $readMoreContents = jQuery(this).parent(".treatment-title-content").find(".treatment-content-description .read-more-content");
        if ($isExpanded) {
            $readMoreContents.show();
            $readMoreContents.prev(".show-paragraph-content").hide();
            jQuery(this).parent(".treatment-title-content").find(".showLess").show();
            jQuery(this).parent(".treatment-title-content").find(".showMore").hide()
        } else {
            $readMoreContents.hide();
            $readMoreContents.prev(".show-paragraph-content").show();
            jQuery(this).parent(".treatment-title-content").find(".showMore").show();
            jQuery(this).parent(".treatment-title-content").find(".showLess").hide()
        }
    });
    const $toggleButton2 = $(".treatment-title-content.new-clinic-p #toggleReadMoreButton");
    let $isExpanded2 = !1;
    $toggleButton2.on("click", function() {
        $isExpanded2 = !$isExpanded2;
        const $readMoreContents1 = jQuery(this).parents(".treatment-two-col-content").find(".treatment-content-description .read-more-content");
        if ($isExpanded2) {
            $readMoreContents1.show();
            $readMoreContents1.prev(".show-paragraph-content").hide();
            $(this).addClass("active")
        } else {
            $readMoreContents1.hide();
            $readMoreContents1.prev(".show-paragraph-content").show();
            $(this).removeClass("active")
        }
    });
    const $toggleButton4 = $(".treatment-title-content.client-story-main-section #toggleReadMoreButton");
    let $isExpanded4 = !1;
    $toggleButton4.on("click", function() {
        $isExpanded4 = !$isExpanded4;
        const $readMoreContents4 = jQuery(this).parents(".client-story-main-section").find(".treatment-content-description .read-more-content");
        if ($isExpanded4) {
            $readMoreContents4.show();
            $readMoreContents4.prev(".show-paragraph-content").hide();
            $(this).addClass("active")
        } else {
            $readMoreContents4.hide();
            $readMoreContents4.prev(".show-paragraph-content").show();
            $(this).removeClass("active")
        }
    });
    $(".ml-content-section").each(function(index) {
        const $toggleButton3 = $('#current-data-' + index).find("#toggleReadMoreButton");
        let $isExpanded3 = !1;
        $toggleButton3.on("click", function() {
            $isExpanded3 = !$isExpanded3;
            const $readMoreContents3 = $(this).parents(".multiple-col-layout").find("#current-data-" + index).find(".treatment-content-description .read-more-content");
            if ($isExpanded3) {
                $readMoreContents3.show();
                $readMoreContents3.prev(".show-paragraph-content").hide();
                $(this).addClass("active")
            } else {
                $readMoreContents3.hide();
                $readMoreContents3.prev(".show-paragraph-content").show();
                $(this).removeClass("active")
            }
        })
    });
    var $list = $(".treatment-price-list .c-list li");
    var batchSize = 4;
    var currentIndex = batchSize;
    $list.slice(currentIndex).hide();
    $(".treatment-readmore-btn .read-more-button .showMore").on("click", function() {
        $list.slice(currentIndex, currentIndex + batchSize).show();
        currentIndex += batchSize;
        if (currentIndex >= $list.length) {
            $(".treatment-readmore-btn .read-more-button .showMore").hide();
            $(".treatment-readmore-btn .read-more-button .showLess").show()
        }
    });
    $(".treatment-readmore-btn .read-more-button .showLess").on("click", function() {
        $list.slice(currentIndex - batchSize, currentIndex).hide();
        currentIndex -= batchSize;
        if (currentIndex <= batchSize) {
            $(".treatment-readmore-btn .read-more-button .showMore").show();
            $(".treatment-readmore-btn .read-more-button .showLess").hide()
        }
    });
    jQuery(".blur-image-view").on("click", function() {
        jQuery(this).parents().removeClass("show-blur-image");
        jQuery(this).parent().hide()
    });
    jQuery(".c-panoaram-video .blur-image-view").on("click", function() {
        jQuery(this).parents().removeClass("show-blur-image");
        jQuery(this).parent().hide();
        jQuery(this).parents().find(".c-video .c-video__play").click()
    });
    jQuery('.password-required-form input[type="submit"]').val("Ga naar")
    $('#treatment_bodyparts_list .cta-button').on('click', function() {
        $('#treatment_bodyparts_list .cta-button').removeClass('active');
        $(this).addClass('active');
        var dataType = $(this).data('type');
        $('#treatment_bodyparts').val(dataType).change()
    });
    const $dynamicimgGallery = jQuery('#dynamic-mode-images');
    const dynamicimgEl = $('#masonry-dynamic-thumbnails').data('images');
    const dynamicimgGallery = window.lightGallery($dynamicimgGallery[0], {
        dynamic: !0,
        hash: !1,
        rotate: !1,
        escKey: !0,
        plugins: [lgThumbnail],
        dynamicEl: dynamicimgEl,
        mobileSettings: {
            controls: !1,
            showCloseIcon: !0,
            closable: !0
        }
    });
    $dynamicimgGallery.on('click', function() {
        dynamicimgGallery.openGallery(4)
    });
    $('#masonry-dynamic-thumbnails .masonry-item').on('click', function() {
        var index = $(this).index() - 1;
        if (index >= 0) {
            dynamicimgGallery.openGallery(index)
        }
    })
});
document.addEventListener('DOMContentLoaded', function() {
    const filterLinks = document.querySelectorAll('.new-deal-component-filter .c-filter');
    const sliderItems = document.querySelectorAll('.testimonial-slider-section .testimonial-slider-item');
    filterLinks.forEach(link => {
        link.addEventListener('click', function(event) {
            event.preventDefault();
            const hash = this.getAttribute('attr-id').replace('#', '');
            sliderItems.forEach(item => {
                if (hash === 'Alle') {
                    item.style.display = 'block'
                } else {
                    if (hash === item.getAttribute('id')) {
                        item.style.display = 'block'
                    } else {
                        item.style.display = 'none'
                    }
                }
            });
            filterLinks.forEach(otherLink => {
                if (otherLink === link) {
                    otherLink.classList.add('is-active')
                } else {
                    otherLink.classList.remove('is-active')
                }
            });
            const urlWithoutHash = window.location.href.split('#')[0];
            const newUrl = urlWithoutHash + '#' + hash
        })
    })
});
window.Renderers = (function() {
    var Renderers = (function() {
        function Renderers() {
            _classCallCheck(this, Renderers);
            this.renderers = {}
        }
        _createClass(Renderers, [{
            key: "exports",
            value: function exports(renderer) {
                this.renderers = Object.assign(this.renderers, renderer)
            },
        }, {
            key: "default",
            get: function get() {
                return this.renderers
            },
        }, ]);
        return Renderers
    })();
    var R = new Renderers();
    return R
})();
(function() {
    var _highway = highway,
        Renderer = _highway.Renderer;
    var CustomRenderer = (function(_Renderer) {
        _inherits(CustomRenderer, _Renderer);
        var _super = _createSuper(CustomRenderer);

        function CustomRenderer() {
            _classCallCheck(this, CustomRenderer);
            return _super.apply(this, arguments)
        }
        return CustomRenderer
    })(Renderer);
    Renderers.exports({
        CustomRenderer: CustomRenderer
    })
})();
window.Transitions = (function() {
    var Transitions = (function() {
        function Transitions() {
            _classCallCheck(this, Transitions);
            this.transitions = {}
        }
        _createClass(Transitions, [{
            key: "exports",
            value: function exports(transition) {
                this.transitions = Object.assign(this.transitions, transition)
            },
        }, {
            key: "animations",
            get: function get() {
                return this.transitions
            },
        }, ]);
        return Transitions
    })();
    var T = new Transitions();
    return T
})();
(function() {
    jQuery(document).on("click", ".open-down-arrow", function() {
        jQuery(this).find(".arrow").toggleClass("up");
        jQuery(this).parents(".c-heading--agenda").next(".u-flex").find(".o-list-plain").slideToggle()
    });
    if (!jQuery('.treatment-tab-section').hasClass('faq-new-section')) {
        jQuery(document).on("click", ".faceland-accordion", function(e) {
            if ($(this).hasClass("active")) {
                $(this).removeClass("active");
                $(this).next("div").slideUp();
                $(this).children(".accordian-arrow").removeClass("open")
            } else {
                $(".faceland-accordion").removeClass("active");
                $(".faceland-accordion").next("div").slideUp();
                $(".faceland-accordion").children(".accordian-arrow").removeClass("open");
                $(this).addClass("active");
                $(this).next("div").slideDown();
                $(this).children(".accordian-arrow").addClass("open")
            }
        })
    }
    jQuery(document).on("click", ".faq-new-section .faceland-accordion", function(e) {
        if ($(this).hasClass("active")) {
            $(this).removeClass("active");
            $(this).children(".faceland-accordion-panel").slideUp();
            $(this).children(".accordian-arrow").removeClass("open")
        } else {
            $(".faq-new-section .faceland-accordion").removeClass("active");
            $(".faq-new-section .faceland-accordion").children(".faq-new-section .faceland-accordion-panel").slideUp();
            $(".faq-new-section .faceland-accordion").children(".faq-new-section .accordian-arrow").removeClass("open");
            $(this).addClass("active");
            $(this).children(".faq-new-section .faceland-accordion-panel").slideDown();
            $(this).children(".faq-new-section .accordian-arrow").addClass("open")
        }
    });
    var _highway2 = highway,
        Transition = _highway2.Transition;
    var loader = document.querySelector(".o-loader");
    var DefaultTransition = (function(_Transition) {
        _inherits(DefaultTransition, _Transition);
        var _super2 = _createSuper(DefaultTransition);

        function DefaultTransition() {
            _classCallCheck(this, DefaultTransition);
            return _super2.apply(this, arguments)
        }
        _createClass(DefaultTransition, [{
            key: "out",
            value: function out(_ref) {
                window.location.reload()
            },
        }, {
            key: "in",
            value: function _in(_ref2) {
                var from = _ref2.from,
                    done = _ref2.done,
                    to = _ref2.to;
                if (to.querySelector(".js-trigger-reload")) {
                    window.location.reload()
                }
                from.remove();
                done();
                rodeskInView.init()
            },
        }, ]);
        return DefaultTransition
    })(Transition);
    Transitions.exports({
        DefaultTransition: DefaultTransition
    })
})();
(function() {
    var _highway3 = highway,
        Transition = _highway3.Transition;
    var FilterTransition = (function(_Transition2) {
        _inherits(FilterTransition, _Transition2);
        var _super3 = _createSuper(FilterTransition);

        function FilterTransition() {
            _classCallCheck(this, FilterTransition);
            return _super3.apply(this, arguments)
        }
        _createClass(FilterTransition, [{
            key: "out",
            value: function out(_ref3) {
                var from = _ref3.from,
                    done = _ref3.done,
                    trigger = _ref3.trigger;
                trigger.classList.add("is-active");
                from.querySelector(".c-filter.is-active").classList.remove("is-active");
                var oldCardWrapper = from.querySelector(".js-filter-container");
                var oldCards = from.querySelector(".js-filter-items");
                oldCardWrapper.style.position = "relative";
                window.location.reload()
            },
        }, {
            key: "in",
            value: function _in(_ref4) {
                var from = _ref4.from,
                    to = _ref4.to,
                    done = _ref4.done;
                var oldCards = from.querySelector(".js-filter-items");
                var newCards = to.querySelector(".js-filter-items");
                oldCards.style.opacity = 0;
                newCards.style.opacity = 0;
                to.querySelectorAll(".js-animation-element").forEach(function(element) {
                    element.classList.add("a-inview")
                });
                from.remove();
                done();
                newCards.removeAttribute("style")
            },
        }, ]);
        return FilterTransition
    })(Transition);
    Transitions.exports({
        FilterTransition: FilterTransition
    })
})();
window.transitionManager = (function() {
    var _highway4 = highway,
        Core = _highway4.Core;
    var _Transitions$animatio = Transitions.animations,
        DefaultTransition = _Transitions$animatio.DefaultTransition,
        FilterTransition = _Transitions$animatio.FilterTransition;
    var transitionManager = new Core({
        transitions: {
            default: DefaultTransition,
            contextual: {
                filter: FilterTransition
            }
        }
    });
    return transitionManager
})();
window.rodeskBreakpoints = (function() {
    var RodeskBreakpoints = (function() {
        function RodeskBreakpoints() {
            _classCallCheck(this, RodeskBreakpoints)
        }
        _createClass(RodeskBreakpoints, [{
            key: _removeQuotes,
            value: function value(string) {
                this.string = string;
                if (typeof this.string === "string" || this.string instanceof String) {
                    var cleanString = this.string.replace(/[^a-zA-Z ]/g, "");
                    return cleanString
                }
                return !1
            },
        }, {
            key: "getBreakpoint",
            value: function getBreakpoint() {
                var _this = this;
                var style = null;
                if (window.getComputedStyle && window.getComputedStyle(document.body, "::after")) {
                    style = window.getComputedStyle(document.body, "::after");
                    style = style.content
                } else {
                    window.getComputedStyle = function(el) {
                        _this.el = el;
                        _this.getPropertyValue = function(prop) {
                            var re = /(-([a-z]){1})/g;
                            if (re.test(prop)) {
                                prop.replace(re, function() {
                                    for (var _len = arguments.length, args = new Array(_len), _key = 0; _key < _len; _key++) {
                                        args[_key] = arguments[_key]
                                    }
                                    return args[2].toUpperCase()
                                })
                            }
                            return el.currentStyle[prop] ? el.currentStyle[prop] : null
                        };
                        return _this
                    };
                    style = window.getComputedStyle(document.getElementsByTagName("head")[0]);
                    style = style.getPropertyValue("font-family")
                }
                return this[_removeQuotes](style)
            },
        }, {
            key: "isBreakpoint",
            value: function isBreakpoint(breakpoint) {
                var breakpoints = {
                    small: ["small", "compact", "medium", "large", "wide", "huge", "mega"],
                    compact: ["compact", "medium", "large", "wide", "huge", "mega"],
                    medium: ["medium", "large", "wide", "huge", "mega"],
                    large: ["large", "wide", "huge", "mega"],
                    wide: ["wide", "huge", "mega"],
                    huge: ["huge", "mega"],
                    mega: ["mega"],
                };
                var actualBreakpoint = this.getBreakpoint();
                if ($.inArray(actualBreakpoint, breakpoints[breakpoint]) !== -1) {
                    return !0
                }
                return !1
            },
        }, ]);
        return RodeskBreakpoints
    })();
    return new RodeskBreakpoints()
})();
window.rodeskVideo = (function() {
    var settings;
    var defaults = {
        videoWrapper: ".js-video-wrapper",
        videoPlay: ".js-video-play",
        autoplay: !0
    };
    var _videoType = function _videoType(event) {
        var $target = $(event.target);
        var videoId = $target.attr("data-id");
        var videoType = $target.attr("data-type");
        var $videoWrapper = $target.closest(settings.videoWrapper);
        var videoHeight = Math.ceil($videoWrapper.outerHeight());
        var videoWidth = Math.ceil($videoWrapper.outerWidth());
        var autoplayVimeo = settings.autoplay ? "?autoplay=1&muted=1" : "";
        var autoplayYoutube = settings.autoplay && rodeskBreakpoints.isBreakpoint("large") ? "?autoplay=1&mute=1" : "";
        if (videoType === "vimeo") {
            $.ajax({
                url: "https://vimeo.com/api/v2/video/".concat(videoId, ".json"),
                dataType: "jsonp",
                type: "GET",
                success: function success() {
                    $videoWrapper.html('<iframe src="https://player.vimeo.com/video/'.concat(videoId).concat(autoplayVimeo, '" width="').concat(videoWidth, '" height="').concat(videoHeight, '" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>'));
                    fitvids($videoWrapper)
                },
            })
        } else if (videoType === "youtube") {
            $.ajax({
                url: "https://www.googleapis.com/youtube/v3/videos?part=id,snippet&id=".concat(videoId).concat(autoplayYoutube, "&key=AIzaSyAXBfQgG0HgqLQmJW97m0ru9AOUXaM5O0I'"),
                dataType: "jsonp",
                type: "GET",
                success: function success() {
                    $videoWrapper.html('<iframe src="https://www.youtube.com/embed/'.concat(videoId).concat(autoplayYoutube, '" width="').concat(videoWidth, '" height="').concat(videoHeight, '" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>'));
                    fitvids($videoWrapper)
                },
            })
        }
        return !1
    };
    var _bindEvents = function _bindEvents() {
        $(settings.videoPlay).on("click", _videoType)
    };
    var _init = function _init(options) {
        options = options || {};
        settings = $.extend({}, defaults, options);
        _bindEvents()
    };
    return {
        init: _init
    }
})();
window.rodeskDefaults = (function() {
    var _exportSvg = function _exportSvg() {
        $(".js-svg-export").each(function(index, element) {
            var $img = $(element);
            var imgID = $img.attr("id");
            var imgClass = $img.attr("class");
            var imgURL = $img.attr("src");
            $.get(imgURL, function(data) {
                var $svg = $(data).find("svg");
                if (typeof imgID !== "undefined") {
                    $svg = $svg.attr("id", imgID)
                }
                if (typeof imgClass !== "undefined") {
                    $svg = $svg.attr("class", "".concat(imgClass, " replaced-svg"))
                }
                $svg = $svg.removeAttr("xmlns:a");
                $img.replaceWith($svg)
            }, "xml")
        })
    };
    var _jsPopup = function _jsPopup(event) {
        var link = $(event.currentTarget).attr("href");
        window.open(link, "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=300,left=300,width=700,height=500");
        return !1
    };
    var offset = function offset(elem) {
        var rect = elem.getBoundingClientRect();
        var win = elem.ownerDocument.defaultView;
        return {
            top: rect.top + win.pageYOffset,
            left: rect.left + win.pageXOffset
        }
    };
    var _relExternal = function _relExternal(element) {
        window.open($(element.currentTarget).attr("href"));
        return !1
    };
    var _jsBlock = function _jsBlock(event) {
        var link = $(event.currentTarget).find("a").not(".js-block-skip");
        var closestHref = link.attr("href");
        var rel = link.attr("rel");
        if (rel === "external") {
            window.open(closestHref, "_blank")
        } else {
            if (typeof transitionManager !== "undefined") {
                transitionManager.redirect(closestHref)
            } else {
                window.location = closestHref
            }
        }
        return !1
    };
    var _jsBlockSkip = function _jsBlockSkip(event) {
        event.stopPropagation()
    };
    var _imgLiquidCustom = function _imgLiquidCustom(element) {
        element.each(function(image) {
            var imageElem = $(image).find("img");
            if (new RegExp(/%[0-9A-Z]{2}/g).test(imageElem.attr("src"))) {
                imageElem.attr("src", decodeURIComponent(imageElem.attr("src")))
            }
            element.imgLiquid()
        })
    };
    var _matchHeight = function _matchHeight(matchHeightOptions) {
        Object.values(matchHeightOptions).forEach(function(value) {
            $(value.target).matchHeight(value.options)
        })
    };
    var _setupListeners = function _setupListeners() {
        $(document).on("click", ".js-block", _jsBlock);
        $(document).on("click", ".js-block-skip", _jsBlockSkip);
        $(document).on("click", "a[rel='external']", _relExternal);
        $(document).on("click", "a[rel='external nofollow']", _relExternal);
        $(document).on("click", ".js-popup", _jsPopup)
    };
    return {
        matchHeight: _matchHeight,
        imgLiquidCustom: _imgLiquidCustom,
        offset: offset,
        init: function init() {
            _exportSvg();
            _imgLiquidCustom($(".js-image-liquid"));
            _setupListeners()
        },
    }
})();
window.rodeskSmoothScroll = (function() {
    var onScrollClick = function onScrollClick(element) {
        var elTarget = element.target;
        element.preventDefault();
        element.stopPropagation();
        jQuery(".is-active").removeClass("is-active");
        jQuery(elTarget).closest("a").addClass("is-active");
        var theClass = jQuery(elTarget).attr("class");
        jQuery("." + theClass).parent("a").addClass("is-active");
        var target = $(elTarget).attr("href");
        var scrollToPosition = $(target).offset().top;
        var headerHeight = $(".c-header").height();
        var scrollTo = scrollToPosition - headerHeight;
        $("html:not(:animated),body:not(:animated)").animate({
            scrollTop: scrollTo
        }, 700, function() {
            $("html,body").animate({
                scrollTop: scrollTo
            }, 0)
        });
        return !1
    };
    return {
        init: function init(element) {
            $(element).on("click", function(clickedElement) {
                onScrollClick(clickedElement)
            })
        },
    }
})();
window.rodeskMenu = (function() {
    var settings, menuItems;
    var defaults = {
        body: "body",
        container: ".js-mainnav",
        toggleMenu: ".js-toggle-menu",
        menuItemWrapper: ".js-navigation-item-mobile",
        menuItem: ".c-nav-main__link",
        toggleSubNav: ".js-toggle-sub-nav",
        classes: {
            open: "is-open",
            noScroll: "no-scroll"
        },
    };
    var _disableScroll = function _disableScroll() {
        if ($(document).height() > $(window).height()) {
            var scrollTop = $("html").scrollTop() ? $("html").scrollTop() : $(document).scrollTop();
            $("html").attr("data-scrollpos", scrollTop);
            $("html").css("top", -scrollTop);
            setTimeout(function() {
                $(settings.body).addClass(settings.classes.noScroll)
            }, 240)
        }
    };
    var _enableScroll = function _enableScroll() {
        var scrollTop = parseInt($("html").css("top"), 10);
        $(settings.body).removeClass(settings.classes.noScroll);
        if (!Number.isNaN(scrollTop)) {
            $("html, body").scrollTop(-scrollTop)
        }
        $("html").removeAttr("data-scrollpos");
        $("html").removeAttr("style")
    };
    var menuOpen = function menuOpen() {
        return $(settings.container).hasClass(settings.classes.open)
    };
    var _closeSubNav = function _closeSubNav() {
        $(settings.menuItemWrapper).removeClass(settings.classes.open)
    };
    var _toggleSubNav = function _toggleSubNav(event) {
        event.stopPropagation();
        var $toggle = $(event.currentTarget);
        var $wrapper = $toggle.closest(settings.menuItemWrapper);
        $wrapper.toggleClass(settings.classes.open)
    };
    if (jQuery(".top-level .parent-menu-item").hasClass("is-active")) {
        jQuery(".top-level .parent-menu-item.is-active").addClass("open");
        jQuery(".top-level .parent-menu-item.is-active").find(".sub-level").addClass("open")
    } else {
        jQuery(".top-level .parent-menu-item").first().find(".sub-level").addClass("open")
    }
    jQuery(".top-level .parent-menu-item").on("click", function(e) {
        e.preventDefault();
        jQuery(".sub-level").removeClass("open");
        jQuery(this).find(".sub-level").addClass("open");
        jQuery(".parent-menu-item").removeClass("open");
        jQuery(this).addClass("open");
        return !1
    });
    jQuery(".js-toggle-menu").on("click", function(e) {
        setTimeout(function() {
            jQuery(".obiChatLauncher").addClass("hidden")
        }, 5000)
    });
    jQuery(".parent-menu").on("click", function(e) {
        e.preventDefault();
        jQuery(this).find(".above-open-icon").toggleClass("open");
        jQuery(this).next().slideToggle();
        jQuery(this).next().next(".show-mobile").slideToggle();
        return !1
    });
    jQuery(".above-right-icon").on("click", function(e) {
        window.location.replace(jQuery(this).parent().find("a").attr("href"))
    });
    jQuery(".parent-menu .above-open-icon").on("click", function(e) {
        e.preventDefault();
        jQuery(this).toggleClass("open");
        jQuery(this).parent().next().slideToggle();
        jQuery(this).parent().next().next(".allview").slideToggle();
        return !1
    });
    jQuery(".parent-menu-above-open-icon").on("click", function(e) {
        e.preventDefault();
        jQuery(this).toggleClass("open");
        jQuery(this).next().slideToggle();
        return !1
    });
    jQuery(".parent-menu-item").on("click", function(e) {
        jQuery(this).find(".parent-menu-above-open-icon").trigger("click")
    });
    jQuery(".sub-to-sub-child .above-open-icon").on("click", function(e) {
        e.preventDefault();
        jQuery(this).toggleClass("open");
        jQuery(this).parent().next().slideToggle();
        jQuery(this).parent().next().next(".show-mobile").slideToggle();
        return !1
    });
    jQuery(".sub-to-sub-child").on("click", function(e) {
        e.preventDefault();
        jQuery(this).find(".above-open-icon").toggleClass("open");
        jQuery(this).next().slideToggle();
        jQuery(this).next().next(".show-mobile").slideToggle();
        return !1
    });
    var _toggleMenu = function _toggleMenu() {
        if (menuOpen()) {
            _enableScroll();
            $(settings.toggleMenu).removeClass(settings.classes.open);
            $(settings.container).removeClass(settings.classes.open)
        } else {
            _disableScroll();
            $(settings.toggleMenu).addClass(settings.classes.open);
            $(settings.container).addClass(settings.classes.open)
        }
    };
    var closeMenu = function closeMenu() {
        _closeSubNav();
        if (menuOpen()) {
            _enableScroll();
            $(settings.toggleMenu).removeClass(settings.classes.open);
            $(settings.container).removeClass(settings.classes.open);
            $(settings.container).css({
                overflowY: "hidden"
            })
        }
    };
    var setActiveMenuItem = function setActiveMenuItem() {
        menuItems.forEach(function(item) {
            item.classList.remove("is-active");
            if (item.href === window.location.href) {
                item.classList.add("is-active")
            }
        })
    };
    var _keyPress = function _keyPress(event) {
        if (event.which === 27 && menuOpen()) {
            _toggleMenu()
        }
        jQuery(".js-modal-show-site-direction").removeClass("be-popup-open")
    };
    var _bindEvents = function _bindEvents() {
        $(document).on("click.rodeskMenuToggle", settings.toggleMenu, _toggleMenu);
        $(document).on("keydown", _keyPress);
        $(document).on("click", settings.toggleSubNav, _toggleSubNav)
    };
    var init = function init(options) {
        options = options || {};
        settings = $.extend({}, defaults, options);
        menuItems = Array.from(document.querySelectorAll(settings.menuItem));
        _bindEvents()
    };
    return {
        init: init,
        closeMenu: closeMenu,
        setActiveMenuItem: setActiveMenuItem
    }
})();
window.rodeskLazyLoad = (function() {
    var settings, $lazyLoads, $lazyLoadsLoaded, $window, runEqualize;
    var defaults = {
        lazyLoad: ".js-lazy-load",
        lazyLoadLiquid: ".js-lazy-load-liquid",
        treshold: 300,
        retinaWidth: 1280,
        classes: {
            loading: "is-lazy-loading",
            loaded: "is-lazy-loaded",
            liquid: "js-img-liquid"
        },
        dataAttr: {
            aspect: "data-aspect",
            src: "data-src",
            srcRetina: "data-src-retina",
            triggerMatchHeight: "data-trigger-matchheight"
        },
    };
    var getFilename = function getFilename(url) {
        if (url) {
            var m = url.toString().match(/.*\/(.+?)\./);
            if (m && m.length > 1) {
                return m[1]
            }
        }
        return ""
    };
    var _getImageRatio = function _getImageRatio($element) {
        if ($element.length > 0) {
            var width = $element.width(),
                aspect = $element.attr(settings.dataAttr.aspect),
                height = width * aspect;
            if (height > 0) {
                return Math.round(height)
            }
        }
        return !1
    };
    var _resetImage = function _resetImage($element) {
        if ($element.length > 0) {
            $element.removeAttr("style");
            $element.removeClass(settings.classes.loading);
            $element.addClass(settings.classes.loaded)
        }
    };
    var _isLoaded = function _isLoaded($element) {
        if ($element.length > 0) {
            if ($element.hasClass(settings.classes.loaded)) {
                return !0
            }
        }
        return !1
    };
    var _setImage = function _setImage($element) {
        if ($element.length > 0 && !_isLoaded($element)) {
            var imageHeight = _getImageRatio($element);
            if ($element.attr("alt") === "" && $element.attr("data-src") !== "") {
                $element.attr("alt", getFilename($element.attr("data-src")))
            }
            $element.addClass(settings.classes.loading);
            $element.css({
                height: "".concat(imageHeight, "px")
            })
        }
    };
    var _setImages = function _setImages() {
        $lazyLoads.each(function(index, element) {
            _setImage($(element))
        })
    };
    var _inview = function _inview(index, element) {
        var $element = $(element);
        if (!$element) {
            return !1
        }
        if ($element.is(":hidden")) {
            return !1
        }
        var scrollTop = $window.scrollTop();
        var scrollBottom = scrollTop + $window.height();
        var elementTop = $element.offset().top;
        var elementBottom = elementTop + $element.outerHeight(!0);
        if (elementBottom >= scrollTop - settings.treshold && elementTop <= scrollBottom + settings.treshold) {
            return $element
        }
        return !1
    };
    var _lazyLoad = function _lazyLoad() {
        var $inview = $lazyLoads.filter(_inview);
        $lazyLoadsLoaded = $inview.trigger("loadImage");
        $lazyLoads = $lazyLoads.not($lazyLoadsLoaded)
    };
    var _loadImage = function _loadImage(event) {
        var $image = $(event.target);
        var retina = window.devicePixelRatio > 1 || window.innerWidth >= settings.retinaWidth;
        var attrib = retina ? settings.dataAttr.srcRetina : settings.dataAttr.src;
        var source = $image.attr(attrib) ? $image.attr(attrib) : $image.attr(settings.dataAttr.src);
        if (_typeof(source) === (typeof undefined === "undefined" ? "undefined" : _typeof(undefined)) || source === !1) {
            return
        }
        source = source || $image.attr(settings.src);
        if (source) {
            $image.attr("src", source);
            $image.on("load", function() {
                _resetImage($image);
                if ($image.attr(settings.dataAttr.triggerMatchHeight) === "1") {
                    if (!runEqualize) return;
                    runEqualize = !1;
                    setTimeout(function() {
                        $.fn.matchHeight._update();
                        runEqualize = !0
                    }, 500)
                }
                if ($image.hasClass(settings.lazyLoadLiquid.replace(".", ""))) {
                    var liquidParent = $image.parent();
                    liquidParent.addClass(settings.classes.liquid);
                    rodeskDefaults.imgLiquidCustom(liquidParent)
                }
            })
        }
    };
    var trigger = function trigger() {
        $window.trigger("resize")
    };
    var _bindEvents = function _bindEvents() {
        $(window).on("resize", $.debounce(100, _setImages));
        $(window).on("resize", _lazyLoad);
        $(window).on("scroll", _lazyLoad);
        $lazyLoads.on("loadImage", _loadImage)
    };
    var _setup = function _setup() {
        var images = Array.from(document.querySelectorAll(settings.lazyLoad));
        runEqualize = !0;
        $lazyLoads = $(images.filter(function(image) {
            return image.getAttribute("data-src") !== ""
        }));
        $window = $(window);
        _bindEvents();
        _setImages();
        trigger()
    };
    var init = function init(options) {
        options = options || {};
        settings = $.extend({}, defaults, options);
        _setup()
    };
    return {
        init: init,
        trigger: trigger
    }
})();
window.rodeskInView = (function() {
    var settings, windowHeight, $animationElements;
    var defaults = {
        elements: ".js-animation-element",
        treshold: 0.25,
        timeout: 200,
        classes: {
            inView: "a-inview"
        }
    };
    var _checkInView = function _checkInView() {
        var windowTopPos = $(window).scrollTop(),
            windowBottomPos = windowTopPos + windowHeight;
        $.each($animationElements, function(index, element) {
            var $elem = $(element),
                elemHeight = $elem.outerHeight() * settings.treshold,
                elemTopPos = $elem.offset().top,
                elemBotPos = elemTopPos + elemHeight;
            if (elemBotPos >= windowTopPos && elemTopPos <= windowBottomPos - elemHeight && !$elem.hasClass(settings.classes.inView)) {
                $elem.addClass(settings.classes.inView)
            }
        })
    };
    var _bindEvents = function _bindEvents() {
        $(window).on("resize", $.debounce(100, _checkInView));
        $(window).on("scroll", $.throttle(100, _checkInView))
    };
    var _setup = function _setup() {
        windowHeight = $(window).height();
        $animationElements = $(settings.elements);
        setTimeout(function() {
            _checkInView()
        }, settings.timeout)
    };
    var init = function init(options) {
        options = options || {};
        settings = $.extend({}, defaults, options);
        _setup();
        _bindEvents()
    };
    return {
        init: init
    }
})();
window.rodeskCompareSlider = (function() {
    var settings, supportClipPath;
    var defaults = {
        container: ".js-compare-container",
        mask: ".js-compare-mask",
        indicator: ".js-compare-indicator",
        classes: {
            drag: "js-compare-drag",
            resize: "js-compare-resize"
        }
    };
    var testClipPath = function testClipPath() {
        var base = "clipPath";
        var prefixes = ["webkit"];
        var properties = [base];
        var testElement = document.createElement("testelement");
        var attribute = "inset(0 0 0 50%)";
        for (var i = 0, l = prefixes.length; i < l; i += 1) {
            var prefixedProperty = prefixes[i] + base.charAt(0).toUpperCase() + base.slice(1);
            properties.push(prefixedProperty)
        }
        for (var _i = 0, _l = properties.length; _i < _l; _i += 1) {
            var property = properties[_i];
            if (testElement.style[property] === "") {
                testElement.style[property] = attribute;
                if (testElement.style[property] === "none") {
                    return !1
                }
                if (testElement.style[property] !== "") {
                    return !0
                }
            }
        }
        return !1
    };

    function drags(dragElement, resizeElement, container) {
        dragElement.on("mousedown vmousedown touchstart", function(e) {
            dragElement.addClass(settings.classes.drag);
            resizeElement.addClass(settings.classes.resize);
            var firstTouch;
            if (e.originalEvent.touches) {
                var _e$originalEvent$touc = _slicedToArray(e.originalEvent.touches, 1);
                firstTouch = _e$originalEvent$touc[0]
            }
            var firstPageX = firstTouch ? firstTouch.pageX : e.pageX;
            var dragWidth = dragElement.outerWidth();
            var xPosition = dragElement.offset().left + dragWidth - firstPageX;
            var containerOffset = container.offset().left;
            var containerWidth = container.outerWidth();
            var minLeft = containerOffset + 10;
            var maxLeft = containerOffset + containerWidth - dragWidth - 10;
            dragElement.parents().on("mousemove vmousemove touchmove", function(event) {
                var touch;
                if (event.originalEvent.touches) {
                    var _event$originalEvent$ = _slicedToArray(event.originalEvent.touches, 1);
                    touch = _event$originalEvent$[0]
                }
                var pageX = touch ? touch.pageX : event.pageX;
                var leftValue = pageX + xPosition - dragWidth;
                if (leftValue < minLeft) {
                    leftValue = minLeft
                } else if (leftValue > maxLeft) {
                    leftValue = maxLeft
                }
                var widthValue = "".concat(((leftValue + dragWidth / 2 - containerOffset) * 100) / containerWidth, "%");
                var widthValuePX = "".concat(leftValue + dragWidth / 2 - containerOffset, "px");
                var heightValuePX = "".concat(container.outerHeight(), "px");
                if (supportClipPath) {
                    $(".".concat(settings.classes.resize)).css({
                        clipPath: "inset(0 0 0 ".concat(widthValue, ")"),
                        "-webkit-clip-path": "inset(0 0 0 ".concat(widthValue, ")")
                    })
                } else {
                    $(".".concat(settings.classes.resize)).css("clip", function() {
                        return "rect(0, ".concat(widthValuePX, ", ").concat(heightValuePX, ", 0)")
                    })
                }
                $(".".concat(settings.classes.resize)).on("mouseup vmouseup touchend", function() {
                    dragElement.removeClass(settings.classes.drag);
                    resizeElement.removeClass(settings.classes.resize)
                });
                $(".".concat(settings.classes.drag)).css("left", widthValue)
            }).on("mouseup vmouseup touchend", function() {
                dragElement.removeClass(settings.classes.drag);
                resizeElement.removeClass(settings.classes.resize)
            });
            e.preventDefault()
        }).on("mouseup vmouseup touchend", function() {
            dragElement.removeClass(settings.classes.drag);
            resizeElement.removeClass(settings.classes.resize)
        })
    }
    var _bindEvents = function _bindEvents() {
        var $compareIndicator = $(settings.container);
        $compareIndicator.each(function(i, item) {
            var actual = $(item);
            drags(actual.find(settings.indicator), actual.find(settings.mask), actual)
        })
    };
    var _setDefault = function _setDefault() {
        $(settings.container).each(function(index, element) {
            if (supportClipPath) {
                var $lastImage = $(element).find(".c-compare__image").last();
                $lastImage.addClass("js-compare-mask");
                var $container = $(settings.mask);
                $container.css({
                    clipPath: "inset(0 0 0 50%)",
                    "-webkit-clip-path": "inset(0 0 0 50%)"
                })
            } else {
                var $firstImage = $(element).find(".c-compare__image").first();
                $firstImage.addClass("js-compare-mask");
                var _$container = $(settings.mask);
                var widthValue = _$container.outerWidth() / 2;
                var heightValue = _$container.outerHeight();
                _$container.css("clip", function() {
                    return "rect(0, ".concat(widthValue, "px, ").concat(heightValue, "px, 0)")
                })
            }
        })
    };
    var _setup = function _setup() {
        supportClipPath = testClipPath();
        _setDefault();
        _bindEvents()
    };
    var init = function init(options) {
        options = options || {};
        settings = $.extend({}, defaults, options);
        _setup()
    };
    return {
        init: init
    }
})(jQuery);
window.rodeskToggle = (function() {
    var settings;
    var defaults = {
        trigger: ".js-toggle-trigger",
        wrapper: ".js-toggle-wrapper",
        parent: ".js-toggle-parent",
        button: ".js-slideopen",
        toggleContent: ".js-toggle-content",
        toggleDefault: ".js-toggle-default",
        classes: {
            open: "is-open",
            active: "is-active"
        },
        data: {
            animationType: "data-animation-type",
            parentId: "data-parent-id",
            multiple: "data-multiple",
            closeParent: "data-close",
            disableMatchheight: "data-disable-trigger-match-height"
        },
    };
    var _toggle = function _toggle(event) {
        var $this = $(event.currentTarget);
        var $parent = $("#".concat($this.attr(settings.data.parentId)));
        var $wrapper = $this.closest(settings.wrapper);
        if ($this.attr(settings.data.animationType) === "jquery") {
            var $parentContent = $parent.find(settings.toggleContent);
            if ($parent.hasClass(settings.classes.open) && $this.attr(settings.data.closeParent) !== "false") {
                $parentContent.slideUp();
                $parent.removeClass(settings.classes.open)
            } else {
                if ($wrapper.attr(settings.data.multiple) !== "true") {
                    $wrapper.find(settings.toggleContent).slideUp();
                    $wrapper.find(settings.parent).removeClass(settings.classes.open)
                }
                $parentContent.slideDown();
                $parent.addClass(settings.classes.open)
            }
        } else {
            if ($parent.hasClass(settings.classes.open) && $this.attr(settings.data.closeParent) !== "false") {
                $parent.removeClass(settings.classes.open)
            } else {
                if ($wrapper.attr(settings.data.multiple) !== "true") {
                    $wrapper.find(settings.parent).removeClass(settings.classes.open);
                    $wrapper.find(settings.trigger).removeClass(settings.classes.active)
                }
                $parent.addClass(settings.classes.open);
                $this.addClass(settings.classes.active)
            }
        }
        if ($this.attr(settings.data.disableMatchheight) !== "true") {
            $.fn.matchHeight._update()
        }
    };
    var _triggerDefault = function _triggerDefault() {
        var $elementToOpen = $(settings.toggleDefault);
        if ($elementToOpen.length > 0) {
            $elementToOpen.trigger("click")
        }
    };
    var _bindEvents = function _bindEvents() {
        $(settings.trigger).on("click", _toggle)
    };
    var _setup = function _setup() {
        _bindEvents();
        _triggerDefault()
    };
    var init = function init(options) {
        options = options || {};
        settings = $.extend({}, defaults, options);
        _setup()
    };
    return {
        init: init
    }
})();
window.rodeskSlickCarousel = (function() {
    var settings, $carousel;
    var defaults = {
        carousel: ".js-carousel",
        carouselDots: ".slick-dots",
        carouselDotsContainer: ".c-carousel__dots",
        carouselPrev: ".js-carousel-prev",
        carouselNext: ".js-carousel-next",
        carouselSlide: ".slick-slide",
        carouselDelay: 0,
        carouselSettings: {
            arrows: !1,
            accessibility: !1,
            centerMode: !1,
            centerPadding: 0,
            dots: !0,
            draggable: !1,
            slidesToShow: 1,
            lazyLoad: "ondemand",
            useCSS: !0,
            infinite: !1,
            initialSlide: 0,
            fade: !0,
            speed: 300,
            autoplay: !0,
            autoplaySpeed: 5000,
            adaptiveHeight: !0,
            swipe: !0,
            pauseOnFocus: !0,
            pauseOnHover: !0,
            focusOnSelect: !1,
            mobileFirst: !1,
        },
        callBacks: {
            init: function init() {
                setTimeout(function() {
                    $.fn.matchHeight._update()
                }, 500)
            },
        },
    };
    var _initSlick = function _initSlick() {
        $carousel = $(settings.carousel);
        $carousel.on("init", settings.callBacks.init);
        $carousel.each(function(i, element) {
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
                rows: 0,
            })
        })
    };
    var destroyCarousel = function destroyCarousel() {
        if ($carousel.hasClass(settings.classes.slickInitialized)) {
            $carousel.slick("unslick")
        }
    };
    var _setup = function _setup() {
        _initSlick()
    };
    var init = function init(options) {
        options = options || {};
        settings = $.extend(!0, {}, defaults, options);
        if ($(settings.carousel).length > 0) {
            _setup()
        }
    };
    return {
        init: init,
        destroyCarousel: destroyCarousel
    }
})();
window.rodeskValidate = (function() {
    var settings;
    var defaults = {
        form: ".js-validate",
        formParent: ".js-form-wrapper",
        formItem: ".js-form-item",
        button: ".c-btn",
        itemsToHide: ".js-to-hide",
        responseMessage: ".js-succes-message",
        errorMessage: ".js-error-message",
        classes: {
            succes: "is-succes",
            error: "is-error",
            valid: "is-valid",
            loading: "is-loading",
            disabled: "is-disabled",
            validate: "c-form-validate"
        },
        dataAttr: {
            loadText: "data-loading-text"
        },
    };

    function _sendForm($formNode, $formParent) {
        var $inputs = $formNode.find("input");
        var $button = $formNode.find(settings.button);
        var formurl = $formNode.attr("action");
        var $thanksMessage = $formParent.find(settings.responseMessage);
        var $errorMessage = $formParent.find(settings.errorMessage);
        var $itemsToHide = $formParent.find(settings.itemsToHide);
        var data = $formNode.serialize();
        var buttonText = $button.val();
        $formNode.addClass(settings.classes.loading);
        $inputs.attr("disabled", !0);
        $button.attr("disabled", !0);
        $inputs.addClass(settings.classes.disabled);
        $button.addClass(settings.classes.disabled);
        $button.val($formNode.attr(settings.dataAttr.loadText));
        $.ajax({
            type: "POST",
            url: formurl,
            data: data,
            success: function success(response) {
                $errorMessage.remove();
                $formNode.removeClass(settings.classes.loading);
                $inputs.removeClass(settings.classes.disabled);
                $button.removeClass(settings.classes.disabled);
                $button.val(buttonText);
                $inputs.attr("disabled", !1);
                $button.attr("disabled", !1);
                if (response.data.messages && !response.success) {
                    response.data.messages.map(function(message) {
                        return $formNode.prepend(message)
                    })
                } else {
                    $itemsToHide.hide();
                    $thanksMessage.css({
                        display: "block"
                    })
                }
            },
            error: function error(_error) {
                throw _error("Error sending data", _error)
            },
        });
        return !1
    }

    function _bindEvents($form, $formParent) {
        if ($form.length > 0) {
            $form.on("submit", function(event) {
                event.preventDefault();
                _sendForm($form, $formParent)
            });
            window.Parsley.on("field:error", function(fieldInstance) {
                var $errorContainer = $formParent.find(".js-error-message");
                var messages = fieldInstance.getErrorsMessages();
                if (messages) {
                    $errorContainer.css({
                        display: "block"
                    })
                }
            });
            window.Parsley.on("field:success", function() {
                var $errorContainer = $formParent.find(".js-error-message");
                var $formFieldErrors = $form.find("".concat(settings.formItem, ".").concat(settings.classes.error));
                if ($formFieldErrors.length === 0) {
                    $errorContainer.hide()
                }
            })
        }
    }
    var _setup = function _setup() {
        var $formElements = $(settings.form);
        if ($formElements.length > 0) {
            $formElements.each(function(index, form) {
                var $form = $(form);
                var $formParent = $form.closest(settings.formParent);
                $form.parsley({
                    errorClass: settings.classes.error,
                    successClass: settings.classes.valid,
                    errorsContainer: function errorsContainer() {
                        return $("<div></div>").css("display", "none")
                    },
                    classHandler: function classHandler(el) {
                        return el.$element.closest(settings.formItem)
                    },
                });
                _bindEvents($form, $formParent)
            })
        }
    };
    var init = function init(options) {
        options = options || {};
        settings = $.extend({}, defaults, options);
        _setup()
    };
    return {
        init: init
    }
})();
window.rodeskUpdate = (function() {
    var RodeskUpdate = (function() {
        function RodeskUpdate() {
            _classCallCheck(this, RodeskUpdate)
        }
        _createClass(RodeskUpdate, [{
            key: _disableExternalLinks,
            value: function value() {
                var externalLinks = document.querySelectorAll('[rel="external"], [rel="external nofollow"], .disable-highyway a');
                externalLinks.forEach(function(link) {
                    link.removeEventListener("click", transitionManager._navigate)
                })
            },
        }, {
            key: _updateHtmlClasses,
            value: function value(to) {
                document.documentElement.classList = to.page.documentElement.classList;
                document.documentElement.setAttribute("lang", to.page.documentElement.getAttribute("lang"))
            },
        }, {
            key: _updateBodyClasses,
            value: function value(to) {
                document.body.classList = to.page.body.classList
            },
        }, {
            key: _updateCampaignStyles,
            value: function value(to) {
                var campaignStyle = document.querySelector("#rokit-campaign-styles");
                var newCampaignStyle = to.page.head.querySelector("#rokit-campaign-styles");
                if (document.body.classList.contains("body--single--campaign")) {
                    if (transitionManager.cache.has(transitionManager.location.href)) {
                        transitionManager.cache.delete(transitionManager.location.href)
                    }
                    if (campaignStyle) {
                        campaignStyle.replaceWith(newCampaignStyle)
                    } else {
                        document.head.appendChild(newCampaignStyle)
                    }
                } else {
                    if (campaignStyle) {
                        campaignStyle.remove()
                    }
                }
            },
        }, {
            key: _updateNavigation,
            value: function value(to) {
                var headerTop = document.querySelector(".js-header-top");
                var newHeaderTop = to.page.body.querySelector(".js-header-top").cloneNode(!0);
                headerTop.replaceWith(newHeaderTop);
                var headerBottom = document.querySelector(".js-header-bottom");
                var newHeaderBottom = to.page.body.querySelector(".js-header-bottom").cloneNode(!0);
                headerBottom.replaceWith(newHeaderBottom);
                var footer = document.querySelector(".js-footer");
                var newFooter = to.page.body.querySelector(".js-footer").cloneNode(!0);
                footer.replaceWith(newFooter);
                var langSwitch = document.querySelector(".js-lang-switch");
                var newlangSwitch = to.page.body.querySelector(".js-lang-switch").cloneNode(!0);
                langSwitch.replaceWith(newlangSwitch)
            },
        }, {
            key: _updateHeader,
            value: function value(to) {
                document.querySelector(".js-header-top").classList = to.page.body.querySelector(".js-header-top").classList
            },
        }, {
            key: _updateMeta,
            value: function value(to) {
                [].forEach.call(to.page.head.childNodes, function(node) {
                    switch (node.nodeName) {
                        case "META":
                            {
                                var contentElement = document.querySelector('meta[property="'.concat(node.getAttribute("property"), '"]'));
                                var nameElement = document.querySelector('meta[name="'.concat(node.getAttribute("name"), '"]'));
                                if (contentElement !== null && node.hasAttribute("property")) {
                                    contentElement.setAttribute("content", node.content)
                                }
                                if (nameElement !== null && node.hasAttribute("name")) {
                                    nameElement.setAttribute("content", node.content)
                                }
                                break
                            }
                        case "LINK":
                            {
                                var element = document.querySelector('link[rel="'.concat(node.getAttribute("rel"), '"]'));
                                if (element !== null && node.hasAttribute("rel") && node.getAttribute("rel") === "canonical") {
                                    element.setAttribute("href", node.getAttribute("href"))
                                } else if (element == null && node.hasAttribute("rel") && node.getAttribute("rel") === "canonical") {
                                    var link = document.createElement("link");
                                    link.rel = "canonical";
                                    link.href = transitionManager.location.href;
                                    document.head.appendChild(link)
                                }
                                break
                            }
                        default:
                            break
                    }
                })
            },
        }, {
            key: "init",
            value: function init(to) {
                this[_updateNavigation](to);
                this[_updateHtmlClasses](to);
                this[_updateBodyClasses](to);
                this[_updateCampaignStyles](to);
                this[_updateHeader](to);
                this[_updateMeta](to)
            },
        }, {
            key: "disable",
            value: function disable() {
                this[_disableExternalLinks]()
            },
        }, ]);
        return RodeskUpdate
    })();
    return new RodeskUpdate()
})();
window.rodeskPopup = (function() {
    var settings;
    var defaults = {
        popup: ".js-modal-newsletter",
        popupContent: ".js-modal-content-newsletter",
        openTrigger: ".js-modal-newsletter-trigger",
        closeTrigger: ".js-modal-close",
        openHash: "#open-newsletter",
        closeHash: "#close-newsletter",
        classes: {
            open: "is-open"
        },
    };
    var _closePopup = function _closePopup() {
        $(settings.popup).removeClass("is-open");
        $("body").off("click.closePopup").css("position", "");
        if (window.location.hash === settings.openHash) {
            window.location.hash = settings.closeHash
        }
    };
    var _openPopup = function _openPopup() {
        var $popup = $(settings.popup);
        $("body").css("position", "fixed");
        $(".js-modal-content-newsletter").css("min-height", "").css("overflow", "scroll");
        if (!$popup.hasClass(settings.classes.open)) {
            $popup.addClass(settings.classes.open)
        }
        setTimeout(function() {
            $("body").on("click.closePopup", function() {
                _closePopup()
            });
            $(settings.popupContent).click(function(event) {
                event.stopPropagation()
            })
        }, 240);
        return !1
    };
    var _keyPress = function _keyPress(event) {
        if (event.which === 27) {
            _closePopup()
        }
    };
    var checkHash = function checkHash() {
        var hash = window.location.hash;
        if (hash && hash === settings.openHash) {
            _openPopup()
        }
    };
    var _bindEvents = function _bindEvents() {
        $(settings.openTrigger).on("click", _openPopup);
        $(settings.closeTrigger).on("click", _closePopup);
        $(document).on("keydown", _keyPress);
        window.addEventListener("hashchange", checkHash)
    };
    var _setup = function _setup() {
        _bindEvents()
    };
    var init = function init(options) {
        options = options || {};
        settings = $.extend({}, defaults, options);
        _setup()
    };
    return {
        init: init,
        checkHash: checkHash
    }
})(jQuery);
window.rodeskFilterTax = (function() {
    var settings, $selectBox, wrapper, cards;
    var defaults = {
        select: ".js-filter-bodypart",
        wrapper: ".js-filter-wrapper",
        card: ".js-filter-card",
        attr: {
            filter: "data-bodyparts"
        }
    };
    var _getFilteredCards = function _getFilteredCards(filter) {
        var active = _toConsumableArray(cards).filter(function(card) {
            return card.getAttribute(settings.attr.filter).includes(filter)
        });
        var inactive = _toConsumableArray(cards).filter(function(card) {
            return !card.getAttribute(settings.attr.filter).includes(filter)
        });
        return {
            active: active,
            inactive: inactive
        }
    };
    var _getFilterValue = function _getFilterValue(event) {
        var filterValue = event.target.value;
        var filteredCards = _getFilteredCards(filterValue);
        anime({
            targets: wrapper,
            translateY: 30,
            opacity: 0,
            duration: 300,
            easing: "easeInOutQuad",
            complete: function complete() {
                setTimeout(function() {
                    cards.forEach(function(element) {
                        $(element.parentNode).remove()
                    });
                    filteredCards.active.forEach(function(element) {
                        element.style.display = "none";
                        wrapper.appendChild(element.parentNode);
                        element.style.display = "block"
                    });
                    rodeskInView.init();
                    rodeskLazyLoad.init();
                    $(window).trigger("scroll");
                    anime({
                        targets: wrapper,
                        translateY: 0,
                        opacity: 1,
                        duration: 300,
                        easing: "easeInOutQuad",
                        complete: function complete() {
                            $(window).trigger("filter.rodeskDone")
                        },
                    })
                }, 200)
            },
        })
    };
    var _getFilterableObjects = function _getFilterableObjects() {
        wrapper = document.querySelector(settings.wrapper);
        cards = wrapper.querySelectorAll(settings.card)
    };
    var _bindEvents = function _bindEvents() {
        $selectBox.on("change", _getFilterValue)
    };
    var _setup = function _setup() {
        $selectBox = $(settings.select);
        _getFilterableObjects();
        _bindEvents()
    };
    var init = function init(options) {
        options = options || {};
        settings = $.extend({}, defaults, options);
        if ($(settings.wrapper).length > 0 && $(settings.card).length) {
            _setup()
        }
    };
    return {
        init: init
    }
})(jQuery);
window.rodeskCampaginScroll = (function() {
    var settings, defaultColor;
    var defaults = {
        backgroundColorElement: ".u-bg-campaign",
        target: ".js-campaign-card",
        panorama: ".js-campaign-panorama",
        data: {
            backgroundColor: "data-background-color"
        }
    };
    var _updateBackgroundColor = function _updateBackgroundColor(entries) {
        entries.forEach(function(entry) {
            var isIntersecting = entry.isIntersecting,
                target = entry.target;
            if (isIntersecting) {
                var campaignColor = target.getAttribute(settings.data.backgroundColor);
                anime({
                    targets: settings.backgroundColorElement,
                    backgroundColor: campaignColor,
                    duration: 400,
                    easing: "easeInOutCubic"
                })
            }
        })
    };
    var _setDefaultBackground = function _setDefaultBackground(entries) {
        entries.forEach(function(entry) {
            var isIntersecting = entry.isIntersecting;
            if (isIntersecting) {
                anime({
                    targets: settings.backgroundColorElement,
                    backgroundColor: defaultColor,
                    duration: 400,
                    easing: "easeInOutCubic"
                })
            }
        })
    };
    var _bindEvents = function _bindEvents() {
        var options = {
            threshold: 1
        };
        var observer = new IntersectionObserver(_updateBackgroundColor, options);
        var campaignCards = document.querySelectorAll(settings.target);
        _toConsumableArray(campaignCards).map(function(card) {
            return observer.observe(card)
        });
        var panoramaObserver = new IntersectionObserver(_setDefaultBackground, options);
        var panorama = document.querySelector(settings.panorama);
        panoramaObserver.observe(panorama)
    };
    var _setup = function _setup() {
        _bindEvents()
    };
    var init = function init(options) {
        options = options || {};
        settings = $.extend({}, defaults, options);
        var panorama = document.querySelector(settings.panorama);
        var firstTarget = document.querySelector(settings.target);
        if (panorama && firstTarget) {
            defaultColor = firstTarget.getAttribute(settings.data.backgroundColor);
            panorama.style.backgroundColor = defaultColor;
            _setup()
        }
    };
    return {
        init: init
    }
})(jQuery);
window.rodeskSwitch = (function() {
    var settings;
    var defaults = {
        switch: ".js-switch",
        content: ".js-toggle-content",
        classes: {
            active: "active"
        },
        dataAttr: {
            id: "data-id"
        }
    };
    var _toggle = function _toggle(event) {
        var $switch = $(event.currentTarget);
        var type = $switch.attr(settings.dataAttr.id);
        $(settings.switch).removeClass(settings.classes.active);
        $switch.addClass(settings.classes.active);
        $(settings.content).removeClass(settings.classes.active);
        $("".concat(settings.content, "[").concat(settings.dataAttr.id, '="').concat(type, '"]')).addClass(settings.classes.active)
    };
    var _bindEvents = function _bindEvents() {
        $(settings.switch).click(_toggle)
    };
    var _setup = function _setup() {
        _bindEvents()
    };
    var init = function init(options) {
        options = options || {};
        settings = $.extend({}, defaults, options);
        if ($(settings.switch).length > 0) {
            _setup()
        }
        jQuery("#toggleswitch").change(function() {
            if (this.checked) {
                jQuery(".c-prices__button-switch .button-js-toggle-2").trigger("click");
                jQuery(".lower-main-price").hide()
            } else {
                jQuery(".c-prices__button-switch .button-js-toggle-1").trigger("click");
                jQuery(".lower-main-price").show()
            }
        })
    };
    return {
        init: init
    }
})(jQuery);
var focusSearchField = function focusSearchField(force) {
    if (!document.body.classList.contains("body--search")) {
        return
    }
    var searchInput = document.querySelector(".js-search-input");
    var focussed = searchInput.getAttribute("data-focussed");
    if (force) {
        searchInput.focus()
    } else if (focussed) {
        setTimeout(function() {
            searchInput.focus()
        }, 100)
    }
};
var _checkSearchCleanButton = function _checkSearchCleanButton() {
    var $searchInput = $(".js-search-input");
    var $cleanButton = $(".js-clean-search");
    if ($searchInput.length > 0 && $cleanButton.length > 0) {
        if ($searchInput.val().length === 0) {
            $cleanButton.css({
                opacity: 0
            })
        }
        $searchInput.on("keydown", function(event) {
            if (event.currentTarget.value.length > 0) {
                $cleanButton.css({
                    opacity: 1
                })
            } else {
                $cleanButton.css({
                    opacity: 0
                })
            }
        })
    }
};
var documentReady = function documentReady() {
    window.addEventListener("scroll", scrollAnimate);
    window.addEventListener("scroll", handleVideoScroll);
    var html = document.documentElement;
    var matchHeightElements = [{
        target: ".js-match-height",
        options: {}
    }, {
        target: ".js-match-min-height",
        options: {
            property: "min-height"
        }
    }, ];
    html.classList.remove("wf-loading", "no-js");
    rodeskDefaults.init();
    rodeskSmoothScroll.init(".js-smooth-scroll");
    rodeskSmoothScroll.init(".treatment-filters a");
    rodeskSmoothScroll.init("a[href^='#']");
    rodeskLazyLoad.init();
    rodeskVideo.init();
    rodeskPopup.init();
    rodeskDefaults.matchHeight(matchHeightElements);
    rodeskCompareSlider.init();
    rodeskToggle.init();
    rodeskInView.init();
    rodeskFilterTax.init();
    rodeskCampaginScroll.init();
    rodeskSwitch.init();
    $("[data-featherlight]").featherlight();
    focusSearchField();
    $(".js-append-around").appendAround();
    rodeskUpdate.disable();
    rodeskValidate.init();
    rodeskSlickCarousel.init({
        carousel: ".js-video-carousel",
        carouselSettings: {
            arrows: !0,
            autoplay: !1,
            slidesToShow: 1,
            slidesToScroll: 1,
            fade: !1,
            dots: !1,
            focusOnSelect: !1,
            mobileFirst: !0,
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
            }, ],
        },
    });
    rodeskSlickCarousel.init({
        carousel: ".js-card-carousel",
        carouselSettings: {
            arrows: !0,
            autoplay: !1,
            draggable: !0,
            slidesToShow: 1,
            slidesToScroll: 1,
            fade: !1,
            dots: !1,
            focusOnSelect: !1,
            centerMode: !0,
            centerPadding: 20,
            infinite: !0,
            mobileFirst: !0,
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
            }, ],
        },
    });
    rodeskSlickCarousel.init({
        carousel: ".js-default-carousel",
        carouselSettings: {
            arrows: !0,
            autoplay: !1,
            slidesToScroll: 1,
            fade: !1,
            dots: !1,
            focusOnSelect: !1
        }
    });
    rodeskSlickCarousel.init({
        carousel: ".js-panorama-carousel",
        carouselSettings: {
            arrows: !0,
            autoplay: !0,
            slidesToScroll: 1,
            fade: !1,
            dots: !1,
            focusOnSelect: !1
        }
    });
    rodeskSlickCarousel.init({
        carousel: ".js-panorama-carousel",
        carouselSettings: {
            arrows: !0,
            autoplay: !0,
            slidesToScroll: 1,
            fade: !1,
            dots: !1,
            focusOnSelect: !1
        }
    });
    rodeskSlickCarousel.init({
        carousel: ".specialisten-slider",
        carouselSettings: {
            arrows: !0,
            autoplay: !0,
            slidesToShow: 4,
            fade: !1,
            dots: !1,
            focusOnSelect: !1,
            responsive: [{
                breakpoint: 1024,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2,
                    infinite: !1,
                    dots: !1
                }
            }, {
                breakpoint: 600,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2
                }
            }, {
                breakpoint: 480,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2
                }
            }, ],
        },
    });
    rodeskSlickCarousel.init({
        carousel: ".recent-blog-slider",
        carouselSettings: {
            arrows: !0,
            autoplay: !1,
            slidesToShow: 4,
            fade: !1,
            dots: !1,
            focusOnSelect: !1,
            responsive: [{
                breakpoint: 1024,
                settings: {
                    slidesToShow: 2,
                    infinite: !1,
                    dots: !1
                }
            }, {
                breakpoint: 600,
                settings: {
                    slidesToShow: 2
                }
            }, {
                breakpoint: 480,
                settings: {
                    slidesToShow: 2
                }
            }, ],
        },
    });
    rodeskSlickCarousel.init({
        carousel: ".deals-slider",
        carouselSettings: {
            arrows: !0,
            autoplay: !0,
            slidesToShow: 4,
            fade: !1,
            dots: !1,
            focusOnSelect: !1,
            responsive: [{
                breakpoint: 1024,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2,
                    infinite: !1,
                    dots: !1
                }
            }, {
                breakpoint: 600,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2
                }
            }, {
                breakpoint: 480,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1
                }
            }, ],
        },
    });
    rodeskSlickCarousel.init({
        carousel: ".reviews-slide",
        carouselSettings: {
            arrows: !0,
            autoplay: !0,
            slidesToShow: 2,
            fade: !1,
            dots: !1,
            focusOnSelect: !1,
            responsive: [{
                breakpoint: 1024,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2,
                    infinite: !1,
                    dots: !1
                }
            }, {
                breakpoint: 600,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2
                }
            }, {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }, ],
        },
    });
    rodeskSlickCarousel.init({
        carousel: ".js-review-carousel",
        carouselSettings: {
            arrows: !0,
            autoplay: !0,
            slidesToShow: 2,
            fade: !1,
            dots: !1,
            focusOnSelect: !1,
            responsive: [{
                breakpoint: 1024,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2,
                    infinite: !1,
                    dots: !1
                }
            }, {
                breakpoint: 600,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2
                }
            }, {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }, ],
        },
    });
    rodeskSlickCarousel.init({
        carousel: ".blog-full-width-content .js-video-image-slider",
        carouselSettings: {
            arrows: !0,
            autoplay: !0,
            slidesToShow: 2,
            fade: !1,
            dots: !1,
            focusOnSelect: !1,
            responsive: [{
                breakpoint: 1024,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2,
                    infinite: !1,
                    dots: !1
                }
            }, {
                breakpoint: 768,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2
                }
            }, {
                breakpoint: 480,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2
                }
            }, ],
        },
    });
    rodeskSlickCarousel.init({
        carousel: ".image_video_slider.js-video-image-slider",
        carouselSettings: {
            arrows: !0,
            autoplay: !0,
            slidesToShow: 2,
            fade: !1,
            dots: !1,
            focusOnSelect: !1,
            responsive: [{
                breakpoint: 1024,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2,
                    infinite: !1,
                    dots: !1
                }
            }, {
                breakpoint: 768,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2
                }
            }, {
                breakpoint: 480,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2
                }
            }, ],
        },
    });
    rodeskSlickCarousel.init({
        carousel: ".js-video-image-slider",
        carouselSettings: {
            arrows: !0,
            autoplay: !0,
            slidesToShow: 2,
            fade: !1,
            dots: !1,
            focusOnSelect: !1,
            responsive: [{
                breakpoint: 1024,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2,
                    infinite: !1,
                    dots: !1
                }
            }, {
                breakpoint: 768,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }, {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }, ],
        },
    });
    rodeskSlickCarousel.init({
        carousel: ".js-video-image-carousel",
        carouselSettings: {
            arrows: !0,
            autoplay: !0,
            slidesToShow: 4,
            fade: !1,
            dots: !1,
            focusOnSelect: !1,
            responsive: [{
                breakpoint: 1024,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2,
                    infinite: !1,
                    dots: !1
                }
            }, {
                breakpoint: 600,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2
                }
            }, {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }, ],
        },
    });
    rodeskSlickCarousel.init({
        carousel: ".js-clinic-specialisten-list-carousel",
        carouselSettings: {
            arrows: !0,
            autoplay: !1,
            slidesToShow: 4,
            fade: !1,
            dots: !1,
            focusOnSelect: !1,
            responsive: [{
                breakpoint: 1024,
                settings: {
                    slidesToShow: 4,
                    slidesToScroll: 4,
                    infinite: !1,
                    dots: !1
                }
            }, {
                breakpoint: 600,
                settings: {
                    slidesToShow: 4,
                    slidesToScroll: 4
                }
            }, {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }, ],
        },
    });
    rodeskSlickCarousel.init({
        carousel: ".js-clinic-specialisten-list-carousel-mobile",
        carouselSettings: {
            arrows: !0,
            autoplay: !1,
            slidesToShow: 4,
            fade: !1,
            dots: !1,
            focusOnSelect: !1,
            responsive: [{
                breakpoint: 1024,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2,
                    infinite: !1,
                    dots: !1
                }
            }, {
                breakpoint: 600,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2
                }
            }, {
                breakpoint: 480,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2
                }
            }, ],
        },
    });
    rodeskSlickCarousel.init({
        carousel: ".js-clinic-specialisten-list-carousel-mobile-new",
        carouselSettings: {
            arrows: !0,
            autoplay: !1,
            slidesToShow: 4,
            fade: !1,
            dots: !1,
            focusOnSelect: !1,
            responsive: [{
                breakpoint: 1024,
                settings: {
                    slidesToShow: 4,
                    slidesToScroll: 2,
                    infinite: !1,
                    dots: !1
                }
            }, {
                breakpoint: 600,
                settings: {
                    slidesToShow: 4,
                    slidesToScroll: 2
                }
            }, {
                breakpoint: 480,
                settings: {
                    slidesToShow: 2.5,
                    slidesToScroll: 2
                }
            }, ],
        },
    });
    $(".js-clean-search").on("click", function(event) {
        event.preventDefault();
        var $searchParent = $(event.currentTarget).closest(".js-search-form");
        var $searchInput = $searchParent.find(".js-search-input");
        $(event.currentTarget).css({
            opacity: 0
        });
        $searchInput.val("");
        focusSearchField(!0)
    });
    $(".js-open-chat").on("click", function(event) {
        event.preventDefault();
        var iframe = $(".obiChatLauncher");
        var button = iframe.contents().find("button");
        button.trigger("click")
    });
    _checkSearchCleanButton();
    if (typeof documentReadyMain === "function") {
        documentReadyMain()
    }
    var towrap = ".worldwide-carousel-component";
    $(towrap).each(function() {
        $(this).not(towrap + "+" + towrap).each(function() {
            $(this).nextUntil(":not(" + towrap + ")").addBack().wrapAll('<div class="w-merge-component">')
        })
    });
    var imageUrl = jQuery(".worldwide-carousel-component").attr("bg-image-url");
    jQuery(".w-merge-component").css("background-image", "url(" + imageUrl + ")");
    if (window.location.href.indexOf("/nl") > -1 || window.location.href.indexOf("/ch") > -1) {} else {
        if ($.cookie("whenToShowDialog") == null) {}
    }
    jQuery(".site-direction-button a").on("click", function() {
        var date = new Date();
        date.setTime(date.getTime() + 180 * 1000);
        $.cookie("whenToShowDialog", "yes", {
            expires: 30,
            path: "/"
        })
    });
    jQuery(document).on("click", "#clinic-popupLink", function(e) {
        e.preventDefault();
        jQuery(".js-modal-show-clinic-information").addClass("clinic-popup-open")
    });
    jQuery(document).on("click", function(event) {
        if (!jQuery(event.target).closest(".js-modal-content-site-direction, #clinic-popupLink").length) {
            jQuery(".js-modal-show-clinic-information").removeClass("clinic-popup-open")
        }
    });
    jQuery(".js-modal-show-clinic-information .js-modal-close").click(function() {
        jQuery(".js-modal-show-clinic-information").removeClass("clinic-popup-open")
    });
    jQuery(".js-modal-show-site-direction .js-modal-close").click(function() {
        jQuery(".js-modal-show-site-direction").removeClass("be-popup-open")
    });
    jQuery("body").click(function() {})
};

function removePageTransitions() {
    $(".o-loader").hide();
    var allLinks = document.querySelectorAll("a");
    [].forEach.call(allLinks, function(link) {
        link.removeEventListener("click", transitionManager._navigate)
    })
}
document.addEventListener("DOMContentLoaded", function() {
    FastClick.attach(document.body);
    rodeskMenu.init();
    setTimeout(function() {
        document.getElementById("defaultOpenTwo").click();
        document.getElementById("defaultOpen").click()
    }, 100);
    if (typeof window.fetch === "undefined") {
        removePageTransitions()
    }
    documentReady();
    rodeskPopup.checkHash();
    jQuery(".blog-left-content-part .blog-fullwidth-start").nextAll().remove();
    jQuery(".blog-full-width-content .blog-fullwidth-start").prevAll().remove()
});
transitionManager.on("NAVIGATE_END", function() {
    documentReady();
    if ($(".js-masonry").length > 0 && $(".js-masonry .o-grid__cell").length === 0) {
        var masonryGrid = document.querySelector(".js-masonry");
        salvattore.registerGrid(masonryGrid)
    }
    if (typeof acalltracker !== "undefined" && siteInfo.environment === "production") {
        acalltracker.dynamicPageload()
    }
});
transitionManager.on("NAVIGATE_IN", function(_ref5) {
    var to = _ref5.to;
    rodeskMenu.setActiveMenuItem();
    rodeskUpdate.init(to)
});
jQuery(".tab").click(function(event) {
    jQuery(".tab").removeClass("active");
    jQuery(this).addClass("active")
});
jQuery(".first-deal-btn").click(function(event) {
    jQuery("#eerste .c-accordion div:nth-child(1)").addClass("show")
});
jQuery("#eerste .c-accordion__heading").click(function(event) {
    jQuery("#eerste .c-accordion div:nth-child(1)").removeClass("show")
});
jQuery(".second-deal-btn").click(function(event) {
    jQuery("#tweede .c-accordion div:nth-child(1)").addClass("show")
});
jQuery("#tweede .c-accordion__heading").click(function(event) {
    jQuery("#tweede .c-accordion div:nth-child(1)").removeClass("show")
});
jQuery(".third-deal-btn").click(function(event) {
    jQuery("#derde .c-accordion div:nth-child(1)").addClass("show")
});
jQuery("#derde .c-accordion__heading").click(function(event) {
    jQuery("#derde .c-accordion div:nth-child(1)").removeClass("show")
});
jQuery(".fourth-deal-btn").click(function(event) {
    jQuery("#vierde .c-accordion div:nth-child(1)").addClass("show")
});
jQuery("#vierde .c-accordion__heading").click(function(event) {
    jQuery("#vierde .c-accordion div:nth-child(1)").removeClass("show")
});
jQuery("#toggleswitch").change(function() {
    if (this.checked) {
        jQuery(".c-prices__button-switch .button-js-toggle-2").trigger("click")
    } else {
        jQuery(".c-prices__button-switch .button-js-toggle-1").trigger("click")
    }
    if (jQuery(".column-price-1").hasClass("active")) {
        jQuery(".column-price-2").hide();
        jQuery(".column-price-1").show()
    } else if (jQuery(".column-price-2").hasClass("active")) {
        jQuery(".column-price-1").hide();
        jQuery(".column-price-2").show()
    }
});
if (jQuery(".column-price-1").hasClass("active")) {
    jQuery(".column-price-2").hide();
    jQuery(".column-price-1").show()
} else if (jQuery(".column-price-2").hasClass("active")) {
    jQuery(".column-price-1").hide();
    jQuery(".column-price-2").show()
}
jQuery(".make-an-appointment-modal").click(function(event) {
    if (jQuery(".show-appointment-modal").attr("data-featherlight") == "#appointment") {
        jQuery(".show-appointment-modal").trigger("click")
    }
});
jQuery(".make-an-appointment-pages").click(function(event) {
    $("html,body").animate({
        scrollTop: $("#appointment-cards").offset().top
    }, "slow")
});
jQuery(".click-btn").click(function(event) {
    jQuery(".c-contacts-btn").trigger("click")
});
var bgvideo = document.getElementById("vid");
bgvideo.muted = !0;
bgvideo.play();
window.onbeforeunload = function() {
    window.scrollTo(0, 0)
};

function openTab(evt, tabID) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("treatmentTabContent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none"
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "")
    }
    document.getElementById(tabID).style.display = "block";
    evt.currentTarget.className += " active"
}

function openTab2(evt, tabID) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("treatmentTabTwoContent");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none"
    }
    tablinks = document.getElementsByClassName("tabTwolinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "")
    }
    document.getElementById(tabID).style.display = "block";
    evt.currentTarget.className += " active"
}

function closePopup() {
    $("#videoModal").fadeOut()
}
jQuery(document).ready(function($) {
    jQuery(".treatement__new .o-grid__cell").remove();
    jQuery("link").each(function() {
        if (jQuery(this).attr("rel") === "alternate" && jQuery(this).attr("hreflang")) {
            jQuery(this).appendTo("head")
        }
    });
    document.getElementById("defaultOpen").click();
    document.getElementById("defaultOpenTwo").click();
    jQuery(".blog-left-content-part .blog-fullwidth-start").nextAll().remove();
    jQuery(".blog-full-width-content .blog-fullwidth-start").prevAll().remove()
});
const videos = document.querySelectorAll(".video-element .video");
let currentVideo = null;

function playCurrentVideo(video) {
    videos.forEach((videoElement) => {
        if (videoElement !== video) {
            videoElement.pause()
        }
    });
    video.play();
    currentVideo = video
}

function handleVideoScroll() {
    const currentViewportVideo = Array.from(videos).find((video) => {
        const rect = video.getBoundingClientRect();
        return rect.top >= 0 && rect.bottom <= window.innerHeight
    });
    if (currentViewportVideo) {
        if (currentViewportVideo !== currentVideo) {
            playCurrentVideo(currentViewportVideo)
        }
    } else {
        if (currentVideo) {
            currentVideo.pause();
            currentVideo = null
        }
    }
}

function scrollAnimate() {
    var reveals = document.querySelectorAll(".scroll-anim");
    for (var i = 0; i < reveals.length; i++) {
        var windowHeight = window.innerHeight;
        var elementTop = reveals[i].getBoundingClientRect().top;
        var elementVisible = 70;
        if (elementTop < windowHeight - elementVisible) {
            reveals[i].classList.add("active")
        } else {
            reveals[i].classList.remove("active")
        }
    }
}
jQuery(document).ready(function() {
    const video = document.getElementById("vid");
    const playPauseButton = document.querySelector(".play");
    playPauseButton.addEventListener("click", function() {
        if (video.paused) {
            video.play();
            playPauseButton.classList.remove("play");
            playPauseButton.classList.add("pause")
        } else {
            video.pause();
            playPauseButton.classList.remove("pause");
            playPauseButton.classList.add("play")
        }
    });
    video.pause()
})