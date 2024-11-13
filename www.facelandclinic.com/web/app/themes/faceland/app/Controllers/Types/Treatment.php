<?php

// Set the namespace
namespace Rokit\Controllers\Types;

use Rokit\Controllers\Collections\LocationCollection;
use Rokit\Controllers\Collections\ReviewCollection;
use Rokit\Controllers\Collections\SpecialistCollection;
use Rokit\Controllers\Collections\BaCollection;
use Rokit\Controllers\Collections\FaqCollection;
use Rokit\Controllers\Collections\PriceCollection;
use Rokit\Controllers\Terms\TreatmentBodypartTerm;

class Treatment extends PostDetail {

    protected static $postType = 'treatment';

    var $_thumbnail;

    var $_label;

    var $_appointment_button;
    
    var $_cta_button;

    var $_related_price;

    var $_related_price_link;

    var $_price;

    var $_length;

    var $_control;

    var $_effect;

    var $_pricelist;

    var $_defaults;

    var $_page_type;

    var $_page_types;

    var $_general;

    var $_media;

    var $_locations;

    var $_specialists;

    var $_faq;

    var $_reviews;

    var $_ba;

    var $_locations_content;

    var $_specialists_content;

    var $_faq_content;

    var $_before_after_content;

    var $_reviews_content;

    var $_cta;

    var $_bodyparts;

    var $_replacable_vars;

    var $_nav;

    var $_related;

    var $_panorama_description;

    var $_carousel_title;

    var $_carousel_description;

    var $_carousel_slider;

    var $_card_background_color;

    var $_all_locations;
    
    var $_all_specialist;

    public function thumbnail(){
        if( ! $this->_thumbnail ) {
            $this->_thumbnail = $this->get_field( static::$postType . '_panorama_thumbnail');
        }

        return $this->_thumbnail;
    }

    public function panorama_description(){
        if( ! $this->_panorama_description ) {
            $this->_panorama_description = $this->get_field('panorama_description');
        }

        return $this->_panorama_description;
    }

    public function carousel_title(){
        if(! $this->_carousel_title) {
            $this->_carousel_title = $this->get_field(static::$postType . '_carousel_title');
        }
        return $this->_carousel_title;
    }

    public function carousel_description(){
        if(! $this->_carousel_description) {
            $this->_carousel_description = $this->get_field(static::$postType . '_carousel_description');
        }
        return $this->_carousel_description;
    }

    public function carousel_slider(){
        if(! $this->_carousel_slider) {
            $this->_carousel_slider = $this->get_field(static::$postType . '_carousel_slider');
        }
        return $this->_carousel_slider;
    }

    public function label(){
        if( ! $this->_label ) {
            $this->_label = $this->get_field( static::$postType . '_label');
        }

        return $this->_label;
    }

    public function appointment_button(){
        $appointmentButtonLable = ''; $appointmentButtonURL = '';
        if(pll_current_language('slug') == 'nl'){
            $appointmentButtonLable = get_field('nl_book_consulation_lable', 'option');
            $appointmentButtonURL = get_field('nl_book_consulation_url', 'option');
        }elseif(pll_current_language('slug') == 'be') {
            $appointmentButtonLable = get_field('be_book_consulation_lable', 'option');
            $appointmentButtonURL = get_field('be_book_consulation_url', 'option');
        }elseif(pll_current_language('slug') == 'be-fr') {
            $appointmentButtonLable = get_field('be_fr_book_consulation_lable', 'option');
            $appointmentButtonURL = get_field('be_fr_book_consulation_url', 'option');
        }elseif(pll_current_language('slug') == 'ch') {
            $appointmentButtonLable = get_field('ch_book_consulation_lable', 'option');
            $appointmentButtonURL = get_field('ch_book_consulation_url', 'option');
        }elseif(pll_current_language('slug') == 'de') {
            $appointmentButtonLable = get_field('de_book_consulation_lable', 'option');
            $appointmentButtonURL = get_field('de_book_consulation_url', 'option');
        }elseif(pll_current_language('slug') == 'en') {
            $appointmentButtonLable = get_field('en_book_consulation_lable', 'option');
            $appointmentButtonURL = get_field('en_book_consulation_url', 'option');
        }
        if( ! $this->_appointment_button ) {
            $this->_appointment_button = [
                'label' => $appointmentButtonLable ? pll__($appointmentButtonLable) : '',
                'url' => $appointmentButtonURL ? $appointmentButtonURL : ''
            ];
        }

        return $this->_appointment_button;
    }

    public function cta_button(){
        if( ! $this->_cta_button ) {
            $this->_cta_button = [
                'label' => $this->get_field( static::$postType . '_cta_button_label') ? pll__($this->get_field( static::$postType . '_cta_button_label')) : '',
                'url' => $this->get_field( static::$postType . '_cta_button_url') ? pll__($this->get_field( static::$postType . '_cta_button_url')) : '',
                'external' => $this->get_field( static::$postType . '_cta_button_external') ? pll__($this->get_field( static::$postType . '_cta_button_external')) : ''
            ];
        }

        return $this->_cta_button;
    }

    public function related_price(){
        if( ! $this->_related_price ) {
            if(!empty($related_price = $this->get_field( static::$postType . '_price_relation'))) {
                $this->_related_price = PriceCollection::post($related_price);
            }
        }

        return $this->_related_price;
    }

    public function related_price_link(){
        if( ! $this->_related_price_link ) {
            if(!empty($related_price = $this->related_price())) {
                $this->_related_price_link = PriceCollection::post($related_price)->link;
            }
        }

        return $this->_related_price_link;
    }

    public function price(){
        if( ! $this->_price ) {

            if ($this->get_field(static::$postType . '_overwrite_price')){
                $label = $this->get_field(static::$postType . '_overwrite_price_label');
            } else if(!empty($related_price = $this->related_price())) {
                $label = $related_price->lowest_price_doctor(true);
                if(!empty($label)){
                    $prelabletext = array('allvoor' => pll__('Al voor'));
                    $label = array_merge($prelabletext,$label);
                }
            }

            $this->_price = [
                'label' => !empty($label) ? pll__('Prijs') : '',
                'value' => !empty($label) ? $label : ''
            ];
        }

        return $this->_price;
    }

    public function length(){
        if( ! $this->_length ) {
            $this->_length =  [
                'label' => pll__('Behandeltijd'),
                'value' => $this->get_field( static::$postType . '_length')
            ];
        }

        return $this->_length;
    }

    public function control(){
        if( ! $this->_control ) {
            $this->_control = [
                'label' => pll__('Controle'),
                'value' => $this->get_field( static::$postType . '_control')
            ];
        }

        return $this->_control;
    }

    public function effect(){
        if( ! $this->_effect ) {
            if (!empty($this->get_field( static::$postType . '_effect'))){
                $this->_effect = [
                    'label' => pll__('Effect'),
                    'value' => $this->get_field( static::$postType . '_effect')
                ];
            }
        }

        return $this->_effect;

    }

    public function pricelist(){
        if( ! $this->_pricelist ) {
            $this->_pricelist = $this->get_field( static::$postType . '_pricelist');
        }

        return $this->_pricelist;

    }

    public function page_type() {

        $query_param = get_query_var('pagetype');
        $page_types = $this->page_types();

        if(empty($query_param)) {
            return $page_types['default'];
        }

        $page_type_slugs = array_combine(array_keys($page_types), array_column($page_types, 'slug'));
        $searched_key = array_search($query_param, $page_type_slugs);

        if(!empty($page_types[$searched_key])) {
            return $page_types[$searched_key];
        }

        return false;
    }

    public function page_types() {


        $show_settings = rokit_get_language_settings()['treatment'];

        $page_types['default'] = [
            'default_label' => 'De behandeling',
            'label'         => pll__('De behandeling'),
            'slug'          => sanitize_title(pll__('De behandeling')),
            'template'      => 'default',
            'disabled'      => !empty($this->content_modules)
        ];

        if ($show_settings['specialists']){
            $page_types['specialists'] = [
                'default_label' => 'Specialisten',
                'label'         => pll__('Specialisten'),
                'slug'          => sanitize_title(pll__('Specialisten')),
                'template'      => 'specialists',
                'disabled'      => !($this->specialists())
            ];
        }

        if ($show_settings['before_after']) {
            $page_types['before_after'] = [
                'default_label' => 'Voor en na',
                'label'         => pll__('Voor en na'),
                'slug'          => sanitize_title(pll__('Voor en na')),
                'template'      => 'before_after',
                'disabled'      => !($this->before_after())
            ];
        }

        if ($show_settings['faq']) {
            $page_types['faq'] = [
                'default_label' => 'Veelgestelde vragen',
                'label'         => pll__('Veelgestelde vragen'),
                'slug'          => sanitize_title(pll__('Veelgestelde vragen')),
                'template'      => 'faq',
                'disabled'      => !($this->faq())
            ];
        }
        $current_lang = pll_current_language();
        $review = $current_lang == 'nl' ? 'Ervaringen' : 'Reviews';
        if ($show_settings['reviews']) {
            $page_types['reviews'] = [
                'default_label' => 'Reviews',
                'label'         => pll__($review),
                'slug'          => sanitize_title(pll__('Ervaringen')),
                'template'      => 'reviews',
                'disabled'      => !($this->reviews())
            ];
        }

        return $page_types;

    }

    public function general(){
        if( ! $this->_general ) {
            $this->_general = [
                'price'     => $this->price(),
                'length'    => $this->length(),
                'control'   => $this->control()
            ];

            if ($this->effect()){
                $this->_general['effect'] = $this->effect();
            }
        }
        return $this->_general;
    }


    public function media(){
        if( ! $this->_media ) {
            $type =  $this->get_field( static::$postType . '_media_type');
            $media['type'] =$type;
            $media[$type] = $this->get_field( static::$postType . '_media_'.$type);
            $this->_media = $media;
        }

        return $this->_media;
    }


    public function specialists(){
        if( ! $this->_specialists ) {

            $posts_ids = $this->get_field( static::$postType . '_specialist_relation');

            if(!empty($posts_ids) && is_iterable($posts_ids)) {
                $args = [
                    'meta_query'    => [
                        [
                            'relation' => 'AND',
                            'first_name' => [
                                'key'       => 'specialist_first_name',
                                'compare'   => 'EXISTS',
                            ],
                            'last_name' => [
                                'key'       => 'specialist_last_name',
                                'compare'   => 'EXISTS',
                            ],
                        ]
                    ],
                    'orderby' => [
                        'first_name'    => 'ASC',
                        'last_name'     => 'ASC',
                    ]
                ];

                $this->_specialists = SpecialistCollection::posts_by_id($posts_ids, $args);
            }
        }

        return $this->_specialists;
    }

    public function locations(){
        if( ! $this->_locations ) {

            $locations = $this->get_field(static::$postType . '_location_relation');

            if(!empty($locations)) {

                $args = [
                    'post__in' => $locations,
                    'meta_query'    => [
                        [
                            'title' => [
                                'key'       => 'location_panorama_titles_title',
                                'compare'   => 'EXISTS',
                            ],
                        ]
                    ],
                    'orderby' => [
                        'title'    => 'ASC',
                    ]
                ];

                $this->_locations = LocationCollection::query($args);

            }

        }

        return $this->_locations;
    }

    public function before_after(){
        if( ! $this->_before_after ) {

            $posts_ids = $this->get_field( static::$postType . '_ba_relation');

            if(!empty($posts_ids) && is_iterable($posts_ids)) {
                $this->_before_after = BaCollection::posts_by_id($posts_ids);
            }
        }

        return $this->_before_after;
    }

    public function faq(){
        if( ! $this->_faq ) {

            $posts_ids = $this->get_field( static::$postType . '_faq_relation');

            if(!empty($posts_ids) && is_iterable($posts_ids)) {
                $this->_faq = FaqCollection::posts_by_id($posts_ids);
            }
        }

        return $this->_faq;
    }

    public function reviews(){
        if( ! $this->_reviews ) {
            $this->_reviews = ReviewCollection::reviews_by_treatment($this->id);
        }

        return $this->_reviews;
    }

    public function locations_content(){
        if( ! $this->_locations_content ) {

            $locations = $this->locations();

            if(!empty($locations) && is_iterable($locations)) {

                $this->_locations_content = [
                    'title' => pll__('Beschikbare locaties'),
                    'posts' => $locations,
                    'cta' => $this->cta(),
                ];

            }
        }

        return $this->_locations_content;
    }

    public function specialists_content(){
        if( ! $this->_specialists_content ) {

            $specialists = $this->specialists();
            $titles = $this->get_field( static::$postType . '_specialists_overwrite', 'option') ? $this->get_field( static::$postType . '_specialists') : $this->defaults('specialist');

            if(!empty($specialists) && is_iterable($specialists)) {

                $this->_specialists_content = [
                    'titles'  => (new Treatment())->compile($titles),
                    'posts' => $specialists
                ];

            }
        }

        return $this->_specialists_content;
    }

    public function faq_content(){
        if( ! $this->_faq_content ) {

            $faq = $this->faq();
            $titles = $this->get_field( static::$postType . '_faq_overwrite', 'option') ? $this->get_field( static::$postType . '_faq') : $this->defaults('faq');

            if(!empty($faq) && is_iterable($faq)) {

                $this->_faq_content = [
                    'titles'  => (new Treatment())->compile($titles),
                    'posts' => $faq
                ];

            }
        }

        return $this->_faq_content;
    }

    public function before_after_content(){
        if( ! $this->_before_after_content ) {

            $before_after = $this->before_after();
            $titles = $this->get_field( static::$postType . '_ba_overwrite', 'option') ? $this->get_field( static::$postType . '_ba') : $this->defaults('before-after');

            if(!empty($before_after) && is_iterable($before_after)) {

                $this->_before_after_content = [
                    'titles'  => (new Treatment())->compile($titles),
                    'posts' => $before_after
                ];

            }
        }

        return $this->_before_after_content;
    }

    public function reviews_content(){
        if( ! $this->_reviews_content ) {
            if(!empty($this->reviews())) {
                if ( $this->get_field( static::$postType . '_review_overwrite') ) {
                    $titles = [
                            'title'     => $this->get_field( static::$postType . '_review_title'),
                            'subtitle'  => $this->get_field( static::$postType . '_review_subtitle')
                    ];
                } else {
                    $titles = ReviewCollection::detail_titles();
                }

                $this->_reviews_content = [
                    'reviews' => $this->reviews(),
                    'titles' => $titles,
                    'grade' => ReviewCollection::average_review($this->reviews())
                ];
            }
        }

        return $this->_reviews_content;
    }

    public function cta(){
        if( ! $this->_cta ) {

            $cta = $this->get_field( static::$postType . '_cta_overwrite', 'option') ? $this->get_field( static::$postType . '_cta') : $this->defaults('cta');

            if(!empty($cta['text'])) {
                $cta['text'] = (new Treatment())->compile($cta['text']);
            }
            $cta['show_button'] = true;

            $this->_cta = $cta;

        }

        return $this->_cta;
    }

    public function bodyparts() {
        if( ! $this->_bodyparts ) {
            $bodyparts = $this->terms('treatment_bodypart');
            if(!empty($bodyparts) && is_array($bodyparts)) {
                foreach($bodyparts as $bodypart) {
                    $this->_bodyparts[] = new TreatmentBodypartTerm($bodypart->ID);
                }
            }
        }

        return $this->_bodyparts;

    }

    public function replacable_vars() {

        if( ! $this->_replacable_vars ) {
            $this->_replacable_vars = [
                'treatment' => strtolower($this->title()),
                'phone'     => rokit_get_a_tag_aen_code(get_field('contact_online_phone', 'option'))
            ];
        }

        return $this->_replacable_vars;

    }

    public function nav(){

        if( ! $this->_nav ) {

            $page_types = $this->page_types();
            $base_url = trailingslashit($this->link);

            array_walk($page_types, function($page_type, $key) use ($base_url, &$page_types){
                $url = $key != 'default' ? $base_url . $page_type['slug'] : $base_url;
                $page_types[$key]['url'] = trailingslashit($url);
            });

            $this->_nav = $page_types;

        }

        return $this->_nav;
    }


    public function related(){
        if( ! $this->_related ) {

            $locations = $this->locations();

            if(!empty($locations) && is_iterable($locations)) {

                $this->_related = [
                    'title' => pll__('Beschikbare locaties'),
                    'locations' => $locations,
                    'cta' => $this->cta(),
                ];

            }
        }

        return $this->_related;
    }

    public function card_background_color() {
        if(!$this->_card_background_color) {
            if(!empty($this->get_field('use_background_colour'))) {
                $this->_card_background_color = $this->get_field('use_background_colour');
            }
        }

        return $this->_card_background_color;
    }

    public function all_locations(){    
        
        $treatmentID = get_the_ID();

        if( ! $this->_all_locations ) {

            $args = array(
                'post_type' => 'location',
                'post_status' => 'publish',
                'posts_per_page' => -1,
                'lang' =>  pll_current_language()
            );

            $query = new \WP_Query($args);

            // Loop through the query results
            if ($query->have_posts()) {
                while ($query->have_posts()) {
                    $query->the_post();

                    $locationArray[] = [
                        'location_section_title' => \get_field('treatment_detail_clinic_section_title', 'option'),
                        'location_title' => get_the_title(),
                        'location_image' => \get_field('treatment_clinic_section_image', get_the_ID()), 
                        'location_show_video' => \get_field('treatment_clinic_section_show_video', get_the_ID()), 
                        'location_video_url' => \get_field('treatment_clinic_section_video', get_the_ID()), 
                        'location_url' => get_permalink(get_the_ID()),
                        'location_show_in_treatment' => \get_field('location_all_treatment_relation', get_the_ID()),
                        'current_treatment_id' => $treatmentID,
                        'location_section_button' => [
                            'btn_url' => \get_field('treatment_detail_clinic_section_button_url', 'option'),
                            'btn_label' => \get_field('treatment_detail_clinic_section_button_label', 'option'),
                            'external' => \get_field('treatment_detail_clinic_section_button_external', 'option')
                        ] 
                    ];
                }
                wp_reset_postdata();
            }

            $this->_all_locations = $locationArray;

        }

        return $this->_all_locations;
    }

    public function all_specialist(){

        $treatmentID = get_the_ID();
        
        if( ! $this->_all_specialist ) {

            $args = array(
                'post_type' => 'specialist',
                'post_status' => 'publish',
                'posts_per_page' => -1,
                'lang' =>  pll_current_language()
            );

            $query = new \WP_Query($args);

            // Loop through the query results
            if ($query->have_posts()) {
                while ($query->have_posts()) {
                    $query->the_post();
                    $specialistArray[] = [
                        'specialist_section_title' => \get_field('treatment_detail_specialist_section_title', 'option'),
                        'specialist_title' => get_the_title(),
                        'specialist_image' =>   wp_get_attachment_url(\get_field('specialist_avatar', get_the_ID())), 
                        'specialist_show_video' => \get_field('treatment_specialist_section_show_video', get_the_ID()), 
                        'specialist_video_url' => \get_field('treatment_specialist_section_video', get_the_ID()), 
                        'specialist_url' => get_permalink(get_the_ID()),
                        'specialist_show_in_treatment' => \get_field('specialist_treatment_relation', get_the_ID()),
                        'current_treatment_id' => $treatmentID,
                        'specialist_section_button' => [
                            'btn_url' => \get_field('treatment_detail_specialist_section_button_url', 'option'),
                            'btn_label' => \get_field('treatment_detail_specialist_section_button_label', 'option'),
                            'external' => \get_field('treatment_detail_specialist_section_button_external', 'option')
                        ] 
                    ];
                }
                wp_reset_postdata();
            }

            $this->_all_specialist = $specialistArray;

        }

        return $this->_all_specialist;
    }

}
