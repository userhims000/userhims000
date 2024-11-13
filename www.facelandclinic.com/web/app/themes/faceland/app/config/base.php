<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Define theme image sizes
    |--------------------------------------------------------------------------
    |
    | Define the theme image sizes.
    | Every size should be defined as desktop, desktop-retina, mobile and mobile retina
    | A size can be defined as 'demo-image' => ['width' => '300', 'height' => '300']
    | As args all default args for add_image_size() can be used
    | See https://developer.wordpress.org/reference/functions/add_image_size/
    |
    */

    'sizes' => [
        'regular' => [
            'video'                     => ['width' => '546',   'height' => '307'],
            'card'                      => ['width' => '350',   'height' => '250'],
            'treatment-cta'             => ['width' => '204',   'height' => '204'],
            'specialist-avatar'         => ['width' => '260',   'height' => '260'],
            'avatar-mg'                 => ['width' => '350',   'height' => '350'],
            'avatar-hg'                 => ['width' => '274',   'height' => '274'],
            'avatar-sm'                 => ['width' => '180',   'height' => '180'],
            'avatar-little'             => ['width' => '104',   'height' => '104'],
            'avatar-tiny'               => ['width' => '86',    'height' => '86'],
            'avatar-mini'               => ['width' => '52',    'height' => '52'],
            'location-panorama'         => ['width' => '1280',  'height' => '438'],
            'video-panorama'            => ['width' => '1280',  'height' => '1024'],
            'card-location'             => ['width' => '350',   'height' => '200'],
            'module-image'              => ['width' => '623',   'height' => '350'],
            'module-image-treatment'    => ['width' => '623',   'height' => '350'],
            'compare-slider'            => ['width' => '623',   'height' => '396'],
            'campaign-thumbnail'        => ['width' => '1134',  'height' => '457'],
            'campaign-image'            => ['width' => '1134',  'height' => '637'],
            'campaign-images'           => ['width' => '446',   'height' => '579'],
            'campaign-zigzag'           => ['width' => '567',   'height' => '426'],
            'campaign-video'            => ['width' => '1134',  'height' => '637'],
            'cta'                       => ['width' => '546',   'height' => '282'],
            'brand'                     => ['width' => '150',   'height' => '80'],
            'disclaimer'                => ['width' => '288',   'height' => '47'],
            'social'                    => ['width' => '1200',  'height' => '630'],
            'download'                  => ['width' => '155',   'height' => '147'],
            'offer-image'               => ['width' => '624',   'height' => '290'],
            'home-slider-image'         => ['width' => '1900',  'height' => '500']
        ],
        'retina' => [
            'video'                     => ['width' => '1092',  'height' => '614'],
            'card'                      => ['width' => '700',   'height' => '500'],
            'treatment-cta-image'       => ['width' => '408',   'height' => '408'],
            'specialist-avatar'         => ['width' => '520',   'height' => '520'],
            'avatar-mg'                 => ['width' => '700',   'height' => '700'],
            'avatar-hg'                 => ['width' => '548',   'height' => '548'],
            'avatar-sm'                 => ['width' => '360',   'height' => '360'],
            'avatar-little'             => ['width' => '208',   'height' => '208'],
            'avatar-tiny'               => ['width' => '172',   'height' => '172'],
            'avatar-mini'               => ['width' => '104',   'height' => '104'],
            'location-panorama'         => ['width' => '2560',  'height' => '876'],
            'video-panorama'            => ['width' => '2560',  'height' => '2048'],
            'card-location'             => ['width' => '700',   'height' => '400'],
            'module-image'              => ['width' => '1246',  'height' => '700'],
            'module-image-treatment'    => ['width' => '1246',  'height' => '700'],
            'compare-slider'            => ['width' => '1246',  'height' => '798'],
            'campaign-thumbnail'        => ['width' => '2268',  'height' => '914'],
            'campaign-image'            => ['width' => '2268',  'height' => '1274'],
            'campaign-images'           => ['width' => '892',   'height' => '1158'],
            'campaign-zigzag'           => ['width' => '1134',  'height' => '852'],
            'campaign-video'            => ['width' => '2268',  'height' => '1274'],
            'cta'                       => ['width' => '1092',  'height' => '564'],
            'brand'                     => ['width' => '300',   'height' => '160'],
            'disclaimer'                => ['width' => '576',   'height' => '94'],
            'social'                    => ['width' => '1200',  'height' => '630'],
            'download'                  => ['width' => '310',   'height' => '294'],
            'offer-image'               => ['width' => '1248',   'height' => '580'],
            'home-slider-image'         => ['width' => '1900',  'height' => '500']
        ],
        'mobile' => [
            'video'                     => ['width' => '275',   'height' => '154'],
            'card'                      => ['width' => '328',   'height' => '234'],
            'treatment-cta'             => ['width' => '204',   'height' => '204'],
            'specialist-avatar'         => ['width' => '260',   'height' => '260'],
            'avatar-mg'                 => ['width' => '280',   'height' => '280'],
            'avatar-hg'                 => ['width' => '274',   'height' => '274'],
            'avatar-sm'                 => ['width' => '180',   'height' => '180'],
            'avatar-little'             => ['width' => '104',   'height' => '104'],
            'avatar-tiny'               => ['width' => '86',    'height' => '86'],
            'avatar-mini'               => ['width' => '52',    'height' => '52'],
            'location-panorama'         => ['width' => '375',   'height' => '519'],
            'video-panorama'            => ['width' => '375',   'height' => '534'],
            'card-location'             => ['width' => '330',   'height' => '188'],
            'module-image'              => ['width' => '330',   'height' => '206'],
            'module-image-treatment'    => ['width' => '312',   'height' => '175'],
            'compare-slider'            => ['width' => '330',   'height' => '178'],
            'campaign-thumbnail'        => ['width' => '330',   'height' => '517'],
            'campaign-image'            => ['width' => '330',   'height' => '185'],
            'campaign-images'           => ['width' => '330',   'height' => '428'],
            'campaign-zigzag'           => ['width' => '330',   'height' => '250'],
            'campaign-video'            => ['width' => '285',   'height' => '160'],
            'cta'                       => ['width' => '330',   'height' => '170'],
            'brand'                     => ['width' => '143',   'height' => '76'],
            'disclaimer'                => ['width' => '288',   'height' => '47'],
            'social'                    => ['width' => '1200',  'height' => '630'],
            'download'                  => ['width' => '146',   'height' => '149'],
            'offer-image'               => ['width' => '330',   'height' => '321'],
            'home-banner-image'         => ['width' => '168',   'height' => '300'],
        ],
        'retina-mobile' => [
            'video'                     => ['width' => '550',   'height' => '308'],
            'card'                      => ['width' => '656',   'height' => '468'],
            'treatment-cta-image'       => ['width' => '408',   'height' => '408'],
            'specialist-avatar'         => ['width' => '520',   'height' => '520'],
            'avatar-mg'                 => ['width' => '560',   'height' => '560'],
            'avatar-hg'                 => ['width' => '548',   'height' => '548'],
            'avatar-sm'                 => ['width' => '360',   'height' => '360'],
            'avatar-little'             => ['width' => '208',   'height' => '208'],
            'avatar-tiny'               => ['width' => '172',   'height' => '172'],
            'avatar-mini'               => ['width' => '104',   'height' => '104'],
            'location-panorama'         => ['width' => '750',   'height' => '1038'],
            'video-panorama'            => ['width' => '750',   'height' => '1068'],
            'card-location'             => ['width' => '660',   'height' => '376'],
            'module-image'              => ['width' => '660',   'height' => '412'],
            'module-image-treatment'   => ['width' => '623',   'height' => '350'],
            'compare-slider'            => ['width' => '660',   'height' => '356'],
            'campaign-thumbnail'        => ['width' => '660',   'height' => '1034'],
            'campaign-image'            => ['width' => '660',   'height' => '370'],
            'campaign-images'           => ['width' => '660',   'height' => '856'],
            'campaign-zigzag'           => ['width' => '660',   'height' => '500'],
            'campaign-video'            => ['width' => '570',   'height' => '320'],
            'cta'                       => ['width' => '660',   'height' => '340'],
            'brand'                     => ['width' => '286',   'height' => '152'],
            'disclaimer'                => ['width' => '576',   'height' => '94'],
            'social'                    => ['width' => '1200',  'height' => '630'],
            'download'                  => ['width' => '292',   'height' => '298'],
            'offer-image'               => ['width' => '660',   'height' => '642'],
            'home-banner-image'         => ['width' => '168',   'height' => '300']
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Textdomain & languages folder
    |--------------------------------------------------------------------------
    |
    | Define the textdomain & languages folder to be used in theme
    | See https://codex.wordpress.org/I18n_for_WordPress_Developers
    |
    */

    'textdomain' => 'faceland',
    'langauges_folder' => get_template_directory() . '/languages',

    /*
    |--------------------------------------------------------------------------
    | Timber template directory
    |--------------------------------------------------------------------------
    |
    | Define the Timber template directory.
    | By default this directory is 'resources/templates'
    |
    */

    'timber_templates' => 'templates',

];
