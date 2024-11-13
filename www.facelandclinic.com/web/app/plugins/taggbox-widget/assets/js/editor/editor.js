jQuery(function (blocks, element, editor, components, i18n, data, compose) {

    var El = element.createElement;
    var TBVars = {};
    const {registerBlockType} = blocks;
    const {RichText, InspectorControls} = editor;
    const {Fragment} = element;
    const {IconButton, TextControl, ToggleControl, Panel, PanelBody, PanelRow} = components;
    const {select, withSelect, withDispatch} = data;
    const {compos} = compose;
    const iconEl = El("div", {
        className: "taggbox_logo__"
    }, El("img", {
        src:"data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIiB3aWR0aD0iMzYuOTk5IiBoZWlnaHQ9IjM2Ljk5OSIgdmlld0JveD0iMCAwIDM2Ljk5OSAzNi45OTkiPgogPGRlZnM+CiAgIDxsaW5lYXJHcmFkaWVudCBpZD0ibGluZWFyLWdyYWRpZW50IiB4MT0iMC41IiB5MT0iMSIgeDI9IjAuNSIgZ3JhZGllbnRVbml0cz0ib2JqZWN0Qm91bmRpbmdCb3giPgogICAgIDxzdG9wIG9mZnNldD0iMCIgc3RvcC1jb2xvcj0iI2ViNWM5OSIvPgogICAgIDxzdG9wIG9mZnNldD0iMC43NyIgc3RvcC1jb2xvcj0iIzYxMzk4MyIvPgogICAgIDxzdG9wIG9mZnNldD0iMSIgc3RvcC1jb2xvcj0iIzYxMzk4MyIvPgogICA8L2xpbmVhckdyYWRpZW50PgogPC9kZWZzPgogPGcgaWQ9IlRhZ2dib3giIHRyYW5zZm9ybT0idHJhbnNsYXRlKC0xNDM0MyAzMjUpIj4KICAgPHBhdGggaWQ9IlBhdGhfNTcxNSIgZGF0YS1uYW1lPSJQYXRoIDU3MTUiIGQ9Ik0xOC41LDBBMTguNSwxOC41LDAsMSwwLDM3LDE4LjVoMEExOC41MzEsMTguNTMxLDAsMCwwLDE4LjUsMFptMCwzNS41MDhBMTcuMDA4LDE3LjAwOCwwLDEsMSwzNS41MDgsMTguNSwxNy4wMDgsMTcuMDA4LDAsMCwxLDE4LjUsMzUuNTA4WiIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoMTQzNDMgLTMyNSkiIGZpbGw9InVybCgjbGluZWFyLWdyYWRpZW50KSIvPgogICA8cGF0aCBpZD0iU3VidHJhY3Rpb25fMSIgZGF0YS1uYW1lPSJTdWJ0cmFjdGlvbiAxIiBkPSJNMTYuMzI0LDMyLjY1QTE2LjMyNiwxNi4zMjYsMCwxLDEsMzIuNjYsMTYuMzI2LDE2LjM0NCwxNi4zNDQsMCwwLDEsMTYuMzI0LDMyLjY1Wk0xMS40MzQsMTYuOTc5djguOWwxMC4xMDctOC45aDYuNTA4VjkuNjhINC42NTZ2Ny4zWiIgdHJhbnNmb3JtPSJ0cmFuc2xhdGUoMTQzNDUuMTQ0IC0zMjIuODI2KSIgZmlsbD0idXJsKCNsaW5lYXItZ3JhZGllbnQpIi8+CiA8L2c+Cjwvc3ZnPg==",
        alt:"Taggbox",
        height:"28",
        width:"28"
    }));
  

    /* REGISTER BLOCK*/
    registerBlockType('taggbox-block/taggbox', {
        title: 'Taggbox Widget',
        description: 'Display your social media content with the Taggbox Wordpress plugin - including hashtags and user content - in a beautiful and richly interactive view.',
        category: 'widgets',
        icon: iconEl,
        keywords: ['taggbox widget'],
        supports: {align: true},
        attributes: {
            shortCode: {default: null},
            widgetId: {default: null},
            height: {default: '100%'},
            width: {default: '100%'},
            url: {default: 'https://widget.taggbox.com/'},
            preview: {default: 'hide'}
        },
        edit:
            function (props) {
                function updateShortCode(event) {
                    props.setAttributes({shortCode: event.target.value});
                    const shortcode = event.target.value;  
                    let shortcodeAttrs = {};
                    shortcode.match(/[\w-]+=".*?"/g).forEach(function(shortcodeAttr) {
                        shortcodeAttr = shortcodeAttr.match(/([\w-]+)="(.*?)"/);
                        shortcodeAttrs[shortcodeAttr[1]] = shortcodeAttr[2];
                    });

                    if(shortcodeAttrs['widgetid'] != '' && shortcodeAttrs['widgetid'] != null && !isNaN(shortcodeAttrs['widgetid']) && jQuery.isNumeric(shortcodeAttrs['widgetid'])){
                        props.setAttributes({widgetId: shortcodeAttrs['widgetid'],width:props.attributes.width, height:props.attributes.height});
                        jQuery('.tb_flash_msg').remove();
                    }else{
                        jQuery('.tb_flash_msg').remove();
                        errMgs = '<div class="tb_alert__ tb_flash_msg"><div class="tb_alert__text">Enter a valid shortCode</div></div>';
                        jQuery(event.target).parent().parent().parent().append(errMgs);
                    }
                }
                function hidePreview() {
                    var parent = jQuery(event.target).closest(".is-selected");
                    parent.children(".taggbox-preview").hide();
                    parent.children(".taggbox-editor-main-div").show();
                    props.setAttributes({preview: "hide"});
                }

                function showPreview(event) {
                    if((props.attributes.widgetId != '' && props.attributes.widgetId != null) && !isNaN(props.attributes.widgetId)) {
                        var parent = jQuery(event.target).closest(".is-selected");
                        parent.children(".taggbox-preview").show();
                        parent.children(".taggbox-editor-main-div").hide();
                        props.setAttributes({preview: "show"});
                        jQuery('.tb_flash_msg').remove();
                    }else {
                        jQuery('.tb_flash_msg').remove();
                        errMgs = '<div class="tb_alert__ tb_flash_msg"><div class="tb_alert__text">Enter a valid shortCode</div></div>';
                        jQuery(event.target).parent().parent().parent().append(errMgs);
                    }
                }

                return [
                    El(Fragment, {},
                        El(
                            InspectorControls, {},
                            El(PanelBody, {title: 'Widget Settings', initialOpen: true},
                                /* Height Field */
                                El(PanelRow, {},
                                    El(TextControl,
                                        {
                                            label: 'Height',
                                            type: 'text',
                                            onChange: (value) => {
                                                props.setAttributes({height: value});
                                            },
                                            value: props.attributes.height
                                        }
                                    )
                                ),
                                /* Width Field */
                                El(PanelRow, {},
                                    El(TextControl,
                                        {
                                            label: 'Width',
                                            type: 'text',
                                            onChange: (value) => {
                                                props.setAttributes({width: value});
                                            },
                                            value: props.attributes.width
                                        }
                                    )
                                ),
                            ),
                        ),
                    ),
                    El(
                        "div", {
                        className: ((props.attributes.preview == "hide") ? "taggbox-preview-show" : "taggbox-preview-hide") + " taggbox-editor-main-div"
                    }, El("div", {
                        className: "taggbox-editor-widget-main-div"
                    }, El("div", {
                            className: "tb_form-group"
                        }, El("div", {
                            className: "taggbox-editor-heading"
                        }, "Taggbox Widget")), 
                                    El("div", {
                                        className: "tb_wall_input_group"
                                    },
                                        El("div", {
                                            className: "tb_wall_input"
                                        },
                                        El("div", {
                                            className: "tb_input__00"
                                        }, El("input", {
                                            type: "text",
                                            className: "tb_gt_input_box",
                                            placeholder: "Enter Widget Shortcode",
                                            value: props.attributes.shortCode,
                                            onChange: updateShortCode
                                        })), 
                                        El("div", {
                                            className: "tb_button__00"
                                        },

                                        El("div", {
                                            className: "taggbox-preview-btn",
                                            onClick: showPreview,
                                        }, "Preview")))),


                        El("div", {
                                className: "tb_signup clear-both"
                            }, El("div", {
                                className: "taggbox-editor-singup-msg-div"
                            }, " If you don't have a widget yet, create one at taggbox : "),
                            El("a", {
                                className: "taggbox-editor-singup-link",
                                href: "https://app.taggbox.com/widget/accounts/register",
                                target: "_blank"
                            }, " Sign Up ")))),
                    
                        
                    El("div", {
                        className: ((props.attributes.preview == "show") ? "taggbox-preview-show" : "taggbox-preview-hide") + " taggbox-preview",
                    }, 
                    El("div", {
                        className: ((props.attributes.preview == "show") ? "taggbox-preview-show" : "taggbox-preview-hide") + " taggbox-close-preview-btn taggbox-preview",
                        onClick: hidePreview
                    }, El("svg", {
                        "xmlns":"http://www.w3.org/2000/svg",
                        "width":"24",
                        "height":"24",
                        "viewBox":"0 0 24 24"
                    },El("g", {
                        "stroke":"none",
                        "stroke-width":"1", 
                        "fill":"none",
                        "fill-rule":"evenodd"
                    }, El("g", {
                        "transform":"translate(12.000000, 12.000000) rotate(-45.000000) translate(-12.000000, -12.000000) translate(4.000000, 4.000000)",
                        "fill":"#fff"
                    }, El("rect", {
                        "x":"0", 
                        "y":"7", 
                        "width":"16", 
                        "height":"2", 
                        "rx":"1"
                    }), El("rect", {
                        "transform":"translate(8.000000, 8.000000) rotate(-270.000000) translate(-8.000000, -8.000000)", 
                        "x":"0",
                        "y":"7",
                        "width":"16",
                        "height":"2",
                        "rx":"1"
                    }))))),
                    El("div", {
                        className: "tb_preview_wrapper"
                    }, El("iframe", {
                        className: "taggbox-editor-iframe",
                        src: props.attributes.url + props.attributes.widgetId + '?preview=1',
                        // src: props.attributes.url + TBVars.widgetId,
                        allowfullscreen: "allowfullscreen",
                        frameborder: "0",
                        title: "Taggbox-widget",
                        border: "0",
                    }))),
                ]
            },
        save: function (props) {
            return El("div", {
                className: "taggbox_container__",
                },
                El("div", {
                    className: "taggbox",
                    style: "width:" + props.attributes.width + ";height:" + props.attributes.height + ";",
                    "data-widget-id": props.attributes.widgetId,
                }),
                El("script", {
                    src: "https://widget.taggbox.com/embed-lite.min.js",
                    type: "text/javascript",
                })
                );
        },
    });
}(
    wp.blocks,
    wp.element,
    wp.blockEditor,
    wp.components,
    wp.i18n,
    wp.data,
    wp.compose,
));