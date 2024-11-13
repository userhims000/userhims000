<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Customfields path
    |--------------------------------------------------------------------------
    |
    | Define the path where to save the ACF JSON files for customfields
    |
    */

    'custom_fields' => get_theme_base() . '/app/customfields',

    /*
    |--------------------------------------------------------------------------
    | Custom toolbars
    |--------------------------------------------------------------------------
    |
    | Define the custom toolbars to use in ACF wysiwyg editors
    | For more info about what items you can use see the https://www.tinymce.com/docs-3x/reference/buttons/
    | Check below to see how a full toolbat looks like:
    |
    | 'custom_rokit' => [
    |   '1' => ['formatselect', 'bold', 'italic', 'bullist', 'numlist', 'blockquote', 'alignleft', 'aligncenter', 'aligncenter', 'link', 'unlink', 'wp_more', 'spellchecker', 'fullscreen', 'wp_adv' ],
    |   '2' => ['strikethrough', 'hr' , 'forecolor', 'pastetext','removeformat', 'charmap', 'outdent', 'indent', 'undo', 'redo', 'wp_help'],
    | ],
    |
    */

    'custom_toolbars' => [
        'Faceland' => [
            '1' => ['bold', 'link' , 'unlink', 'bullist', 'numlist'],
        ],
        'Faceland intro' => [
            '1' => ['bold', 'link' , 'unlink'],
        ],
        'link only' => [
            '1' => ['link' , 'unlink'],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | ACF option pages
    |--------------------------------------------------------------------------
    |
    | Define the custom ACF option pages
    | For more info about this see https://www.advancedcustomfields.com/add-ons/options-page/
    |
    */

    'options' => [
        'pages' => [
            'options' => [
                'page_title'    => __( 'Options', 'faceland' ),
                'menu_title'    => __( 'Options', 'faceland' ),
                'menu_slug'     => 'rodesk_settings',
                'capability'    => 'edit_posts',
                'position'      => 999
            ]
        ],
        'subpages' => [
            'contact' => [
                'title'         => __( 'Contact details', 'faceland' ),
                'parent'        => 'rodesk_settings',
                'capability'    => 'rodesk_non_surgery'
            ],
            'contact_online' => [
                'title'         => __( 'Contact details (online)', 'faceland' ),
                'parent'        => 'rodesk_settings',
                'capability'    => 'rodesk_non_surgery'
            ],
            'social_media' => [
                'title'         => __( 'Social media', 'faceland' ),
                'parent'        => 'rodesk_settings',
                'capability'    => 'rodesk_non_surgery'
            ],
            '404' => [
                'title'         => __( '404 page', 'faceland' ),
                'parent'        => 'rodesk_settings',
                'capability'    => 'rodesk_non_surgery'
            ],
            'header' => [
                'title'         => __( 'Header', 'faceland' ),
                'parent'        => 'rodesk_settings',
                'capability'    => 'rodesk_non_surgery'
            ],
            'footer' => [
                'title'         => __( 'Footer', 'faceland' ),
                'parent'        => 'rodesk_settings',
                'capability'    => 'rodesk_non_surgery'
            ],
            'newsletter' => [
                'title'         => __( 'Newsletter', 'faceland' ),
                'parent'        => 'rodesk_settings',
                'capability'    => 'rodesk_non_surgery'
            ],
            'comments' => [
                'title'     => __( 'Comments', 'faceland' ),
                'parent'    => 'rodesk_settings',
                'capability'    => 'rodesk_non_surgery'
            ],
            'email' => [
                'title'         => __( 'Email', 'faceland' ),
                'parent'        => 'rodesk_settings',
                'capability'	=> 'administrator'
            ],
            'chat' => [
                'title'         => __( 'Chat', 'faceland' ),
                'parent'        => 'rodesk_settings',
                'capability'	=> 'administrator'
            ],
            'faq_archive' => [
                'title'         => __( 'FAQ settings', 'faceland' ),
                'parent'        => 'edit.php?post_type=faq',
                'capability'    => 'rodesk_non_surgery'
            ],
            'location_archive' => [
                'title'         => __( 'Location settings', 'faceland' ),
                'parent'        => 'edit.php?post_type=location',
                'capability'    => 'rodesk_non_surgery'
            ],
            'specialist_archive' => [
                'title'         => __( 'Specialist settings', 'faceland' ),
                'parent'        => 'edit.php?post_type=specialist',
                'capability'    => 'rodesk_non_surgery'
            ],
            'ba_album_archive' => [
                'title'         => __( 'Before and after settings', 'faceland' ),
                'parent'        => 'edit.php?post_type=ba_album',
                'capability'    => 'rodesk_non_surgery'
            ],
            'treatment_archive' => [
                'title'         => __( 'Treatment settings', 'faceland' ),
                'parent'        => 'edit.php?post_type=treatment',
                'capability'    => 'rodesk_non_surgery'
            ],
            'academy_archive' => [
                'title'         => __( 'Academy settings', 'faceland' ),
                'parent'        => 'edit.php?post_type=academy',
                'capability'    => 'rodesk_non_surgery'
            ],
            'surgery_day_archive' => [
                'title'         => __( 'Surgery days settings', 'faceland' ),
                'parent'        => 'edit.php?post_type=surgery_day',
                'capability'    => 'rodesk_non_surgery'
            ],
            'lm_archive' => [
                'title'         => __( 'Last minutes settings', 'faceland' ),
                'parent'        => 'edit.php?post_type=last_minute',
                'capability'    => 'rodesk_non_surgery'
            ],
            'offer_archive' => [
                'title'         => __( 'Action settings', 'faceland' ),
                'parent'        => 'edit.php?post_type=offer',
                'capability'    => 'rodesk_non_surgery'
            ],
            'article_archive' => [
                'title'         => __( 'Article settings', 'faceland' ),
                'parent'        => 'edit.php?post_type=article',
                'capability'    => 'rodesk_non_surgery'
            ],
            'blog_archive' => [
                'title'         => __( 'Blog settings', 'faceland' ),
                'parent'        => 'edit.php?post_type=blog_article',
                'capability'    => 'rodesk_non_surgery'
            ],
            'price_archive' => [
                'title'         => __( 'Price settings', 'faceland' ),
                'parent'        => 'edit.php?post_type=price',
                'capability'    => 'rodesk_non_surgery'
            ],
            'video_archive' => [
                'title'         => __( 'Video settings', 'faceland' ),
                'parent'        => 'edit.php?post_type=video',
                'capability'    => 'rodesk_non_surgery'
            ],
            'news_archive' => [
                'title'         => __( 'News settings', 'faceland' ),
                'parent'        => 'edit.php?post_type=blog_article',
                'capability'    => 'rodesk_non_surgery'
            ],
            'campaign_archive' => [
                'title'         => __( 'Campaign settings', 'faceland' ),
                'parent'        => 'edit.php?post_type=campaign',
                'capability'    => 'rodesk_non_surgery'
            ],
            'review_archive' => [
                'title'         => __( 'Review settings', 'faceland' ),
                'parent'        => 'edit.php?post_type=review',
                'capability'    => 'rodesk_non_surgery'
            ]     ,
            'language_settings' => [
                'title'         => __( 'Language settings', 'faceland' ),
                'parent'        => 'rodesk_settings',
                'capability'    => 'rodesk_non_surgery'
            ],
            'structured_data_settings' => [
                'title'         => __( 'Structured Data settings', 'faceland' ),
                'parent'        => 'rodesk_settings',
                'capability'    => 'rodesk_non_surgery'
            ]
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Merge tab groups
    |--------------------------------------------------------------------------
    |
    | This allowes to merge seperate tab groups on the same page
    | If you have two ACF groups that both have tabs you can merge them into one group
    | Make sure to init the mergeTabs class in RokitSetup first
    | Check below to see how an array looks like:
    |
    | 'page_basename_here' => [
    |   'acf_grou_name_to_merge',
    |   'acf_grou_name_to_merge'
    | ]
    */

    // 'merge_tabs' => []

];
