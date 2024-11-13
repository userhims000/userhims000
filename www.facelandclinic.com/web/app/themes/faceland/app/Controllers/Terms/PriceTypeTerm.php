<?php

// Set the namespace
namespace Rokit\Controllers\Terms;

class PriceTypeTerm extends Term {

    public $TermClass = 'Rokit\Controllers\Taxonomies\PriceTypeTerm';

    var $_title;

    var $_intro;

    var $_headers;

    var $_bottom;

    var $_price_type;

    var $_download_button;

    var $_color;

    var $_tooltips;

    var $_items;

    var $_replacable_vars;

    var $_price_list_image;
    
    var $_christmas_price_list;

    var $_area_map_image_treatments;

    public function title() {

        if( ! $this->_title ) {
            $this->_title = $this->get_field($this->post_type() .'_taxonomy_intro_title', $this->acf_id());
        }

        return $this->_title;
    }

    public function intro() {

        if( ! $this->_intro ) {

            $use_compile    = $this->get_field($this->post_type() .'_taxonomy_use_download', $this->acf_id()) ;
            $intro          = $this->get_field($this->post_type() .'_taxonomy_intro_subtitle', $this->acf_id());

            if (!empty($intro)){
                $this->_intro = $use_compile ? $this->compile($intro) : $intro;
            }
        }

        return $this->_intro;
    }

    public function headers() {

        if( ! $this->_headers ) {

            $this->_headers = [
                'title' => get_field( $this->post_type() . '_archive_intro_title', 'option'),
                'intro' => get_field( $this->post_type() . '_archive_intro_subtitle', 'option')
            ];

        }

        return $this->_headers;
    }

    public function bottom() {

        if( ! $this->_bottom ) {
            $this->_bottom = get_field( $this->post_type() . '_archive_bottom', 'option');
        }

        return $this->_bottom;
    }

    public function page_section_title() {

        if( ! $this->_page_section_title ) {
            $this->_page_section_title = get_field( $this->post_type() . '_page_section_title', 'option');
        }

        return $this->_page_section_title;
    }

    public function price_type() {

        if( ! $this->_price_type ) {
            $this->_price_type = get_query_var('price_type');
        }

        return $this->_price_type;

    }

    public function download_button() {

        if( ! $this->_download_button ) {
            $file   = $this->get_field($this->post_type() . '_taxonomy_download_file', $this->acf_id());
            $label  = $this->get_field($this->post_type() . '_taxonomy_download_label', $this->acf_id());
            $format = '<a href="%s" title="%s" class="o-link" rel="external" data-router-disabled>%s</a>';
            $this->_download_button = sprintf($format, $file, $label, $label);
        }

        return $this->_download_button;

    }

    public function color() {

        if( ! $this->_color ) {
            $this->_color = $this->get_field($this->post_type() . '_taxonomy_color', $this->acf_id());
        }

        return $this->_color;

    }

    public function tooltips() {

        if( ! $this->_tooltips ) {
            $tooltips = [];

            if ( $this->get_field($this->post_type() . '_taxonomy_doctor_popup', $this->acf_id())){
                $tooltips['doctor'] = [
                    'title' => $this->get_field($this->post_type() . '_taxonomy_doctor_popup_title', $this->acf_id()),
                    'text' => $this->get_field($this->post_type() . '_taxonomy_doctor_popup_text', $this->acf_id()),
                ];
            }

            if ( $this->get_field($this->post_type() . '_taxonomy_facecard_popup', $this->acf_id())){
                $tooltips['facecard'] = [
                    'title' => $this->get_field($this->post_type() . '_taxonomy_facecard_popup_title', $this->acf_id()),
                    'text' => $this->get_field($this->post_type() . '_taxonomy_facecard_popup_text', $this->acf_id()),
                ];
            }
            $this->_tooltips = $tooltips;
        }

        return $this->_tooltips;

    }

    public function items() {

        if( ! $this->_items ) {
            $args = [
                'posts_per_page'    => -1,
                'orderby'           => 'menu_order',
                'order'             => 'ASC'
            ];

            $post_class = rokit_timber_type_class($this->post_type);

            $this->_items = $this->get_posts($args, $post_class);
        }

        return $this->_items;
    }

    public function replacable_vars() {

        if( ! $this->_replacable_vars ) {
            $this->_replacable_vars = [
                'downloadLink' => $this->download_button()
            ];
        }

        return $this->_replacable_vars;

    }

    public static function price_types() {

        $types = [];
        $terms = get_terms('price_type');

        if(!empty($terms) and is_iterable($terms)) {
            foreach($terms as $term) {
                $types[] = new PriceTypeTerm($term->term_id);
            }
        }

        return $types;
    }

    public static function filter() {
        return [
            'options' => static::price_types(),
            'christmas_price_types' => static::christmas_price_list()
        ];
    }

    public function price_list_image() {
        if( ! $this->_price_list_image ) {
            $this->_price_list_image = [
               'first_price_list_image' => $this->get_field($this->post_type() .'_taxonomy_list_image', $this->acf_id()),
               'christmas_price_list_image' => $this->get_field($this->post_type() .'_taxonomy_list_christmas_image', $this->acf_id())
            ];
        }

        return $this->_price_list_image;
    }

    public static function christmas_price_list() {
        $types = [];
        $terms = get_terms('price_type');

        if(!empty($terms) and is_iterable($terms)) {
            foreach($terms as $term) {
                $getChristmasPriceType = get_term_meta( $term->term_id, 'price_show_type_christmas', true);
                if($getChristmasPriceType == true) {
                    $types[] = new PriceTypeTerm($term->term_id);
                }
            }
        }

        return $types;
    }


    public static function treatmentsWithPriceList() {
        
        $treatments = [];
    
        $getExtractedTreatments = [];

        $treatmentPriceInformation = [];

        $priceInformation = [];

        $currentQueriedObject = get_queried_object();

        $getTreatmentsList = \get_field('face_treatments_list', $currentQueriedObject->taxonomy . '_' . $currentQueriedObject->term_id);
    
        foreach($getTreatmentsList as $fetchTreatment){

            $assignPrices = \get_field('treatment_price_detail_information', $fetchTreatment['list_of_treatments'][0]->ID);

            $priceInformation = [];

            foreach ($assignPrices as $priceInfo) {
                $treatmentPriceTitle = $priceInfo['show_treatment_price_title'];
                foreach ($priceInfo['assign_the_prices_for_this_treatment'] as $price) {
                    $priceInformation[$treatmentPriceTitle][] = [
                        'treatment_specification_volume' => \get_field('treatment_specification_volume', $price->ID),
                        'treatment_price_panorama_title' => \get_field('price', $price->ID)['panorama_titles_title'],
                        'treatment_prices' => [
                            'euro_currency' => \get_field('euro_price_currency', $price->ID),
                            'euro_behandelaar_prijs' => \get_field('euro_behandelaar_prijs', $price->ID),
                            'euro_behandelaar_prijs_striketrough' => \get_field('euro_behandelaar_prijs_striketrough', $price->ID),
                            'euro_behandelaar_prijs__discount' => \get_field('euro_behandelaar_prijs__discount', $price->ID),
                            'euro_behandelaar_prijs_discount_striketrough' => \get_field('euro_behandelaar_prijs_discount_striketrough', $price->ID),
                            'show_euro_price_clinic_deal' => \get_field('show_euro_price_clinic_deal', $price->ID),
                            'pound_price_currency' => \get_field('pound_price_currency', $price->ID),
                            'pound_behandelaar_prijs' => \get_field('pound_behandelaar_prijs', $price->ID),
                            'pound_behandelaar_prijs_striketrough' => \get_field('pound_behandelaar_prijs_striketrough', $price->ID),
                            'pound_behandelaar_prijs__discount' => \get_field('pound_behandelaar_prijs__discount', $price->ID),
                            'pound_behandelaar_prijs_discount_striketrough' => \get_field('pound_behandelaar_prijs_discount_striketrough', $price->ID),
                            'show_pound_price_clinic_deal' => \get_field('show_pound_price_clinic_deal', $price->ID),
                            'doller_price_currency' => \get_field('doller_price_currency', $price->ID),
                            'doller_behandelaar_prijs' => \get_field('doller_behandelaar_prijs', $price->ID),
                            'doller_behandelaar_prijs_striketrough' => \get_field('doller_behandelaar_prijs_striketrough', $price->ID),
                            'doller_behandelaar_prijs_discount' => \get_field('doller_behandelaar_prijs_discount', $price->ID),
                            'doller_behandelaar_prijs_discount_striketrough' => \get_field('doller_behandelaar_prijs_discount_striketrough', $price->ID),
                            'show_doller_price_clinic_deal' => \get_field('show_doller_price_clinic_deal', $price->ID),
                        ],
                    ];
                }
            }


            foreach($fetchTreatment['list_of_treatments'] as $treatMent){
                $treatmentPriceInformation[$treatMent->ID]['treatment_price_image_desktop'] = \get_field('treatment_price_image_desktop', $treatMent->ID); 
                $treatmentPriceInformation[$treatMent->ID]['treatment_title'] = get_the_title($treatMent->ID); 
                $treatmentPriceInformation[$treatMent->ID]['show_treatment_price_clinic_deals'] = \get_field('show_treatment_price_clinic_deals', $treatMent->ID); 
                $treatmentPriceInformation[$treatMent->ID]['show_advance_treatment'] = \get_field('show_advance_treatment', $treatMent->ID); 
                $treatmentPriceInformation[$treatMent->ID]['treatment_price_detail_information'] = \get_field('treatment_price_detail_information', $treatMent->ID); 
                $treatmentPriceInformation[$treatMent->ID]['treatment_overwrite_price_label'] = \get_field('treatment_overwrite_price_label', $treatMent->ID); 
                $treatmentPriceInformation[$treatMent->ID]['treatment_length'] = \get_field('treatment_length', $treatMent->ID); 
                $treatmentPriceInformation[$treatMent->ID]['treatment_control'] = \get_field('treatment_control', $treatMent->ID); 
                $treatmentPriceInformation[$treatMent->ID]['treatment_effect'] = \get_field('treatment_effect', $treatMent->ID); 
                $treatmentPriceInformation[$treatMent->ID]['treatment_detail_page_link'] = get_permalink($treatMent->ID); 
                $treatmentPriceInformation[$treatMent->ID]['treatment_price_list_description'] = \get_field('treatment_price_list_description', $treatMent->ID);
                $treatmentPriceInformation[$treatMent->ID]['treatment_post_id'] = $treatMent->ID;
                $treatmentPriceInformation[$treatMent->ID]['treatment_price_new_layout_information'] = $priceInformation;
                $treatmentPriceInformation[$treatMent->ID]['treatment_cta'] = [
                    'label' => \get_field('treatment_cta_button_label', $treatMent->ID),
                    'url' => \get_field('treatment_cta_button_url', $treatMent->ID),
                    'external' => \get_field('treatment_cta_button_external', $treatMent->ID)
                ];
            }
        }
    
        return $treatmentPriceInformation;
    }

    public static function bodyTreatmentsWithPriceList() {
        
        $treatments = [];
    
        $getExtractedTreatments = [];

        $treatmentPriceInformation = [];

        $priceInformation = [];

        $currentQueriedObject = get_queried_object();

        $getTreatmentsList = \get_field('body_treatments_list', $currentQueriedObject->taxonomy . '_' . $currentQueriedObject->term_id);
    

        foreach($getTreatmentsList as $fetchTreatment){

            $assignPrices = \get_field('treatment_price_detail_information', $fetchTreatment['body_list_of_treatments'][0]->ID);

            $priceInformation = [];

            foreach ($assignPrices as $priceInfo) {
                $treatmentPriceTitle = $priceInfo['show_treatment_price_title'];
                foreach ($priceInfo['assign_the_prices_for_this_treatment'] as $price) {
                    $priceInformation[$treatmentPriceTitle][] = [
                        'treatment_specification_volume' => \get_field('treatment_specification_volume', $price->ID),
                        'treatment_price_panorama_title' => \get_field('price', $price->ID)['panorama_titles_title'],
                        'treatment_prices' => [
                            'euro_currency' => \get_field('euro_price_currency', $price->ID),
                            'euro_behandelaar_prijs' => \get_field('euro_behandelaar_prijs', $price->ID),
                            'euro_behandelaar_prijs_striketrough' => \get_field('euro_behandelaar_prijs_striketrough', $price->ID),
                            'euro_behandelaar_prijs__discount' => \get_field('euro_behandelaar_prijs__discount', $price->ID),
                            'euro_behandelaar_prijs_discount_striketrough' => \get_field('euro_behandelaar_prijs_discount_striketrough', $price->ID),
                            'show_euro_price_clinic_deal' => \get_field('show_euro_price_clinic_deal', $price->ID),
                            'pound_price_currency' => \get_field('pound_price_currency', $price->ID),
                            'pound_behandelaar_prijs' => \get_field('pound_behandelaar_prijs', $price->ID),
                            'pound_behandelaar_prijs_striketrough' => \get_field('pound_behandelaar_prijs_striketrough', $price->ID),
                            'pound_behandelaar_prijs__discount' => \get_field('pound_behandelaar_prijs__discount', $price->ID),
                            'pound_behandelaar_prijs_discount_striketrough' => \get_field('pound_behandelaar_prijs_discount_striketrough', $price->ID),
                            'show_pound_price_clinic_deal' => \get_field('show_pound_price_clinic_deal', $price->ID),
                            'doller_price_currency' => \get_field('doller_price_currency', $price->ID),
                            'doller_behandelaar_prijs' => \get_field('doller_behandelaar_prijs', $price->ID),
                            'doller_behandelaar_prijs_striketrough' => \get_field('doller_behandelaar_prijs_striketrough', $price->ID),
                            'doller_behandelaar_prijs_discount' => \get_field('doller_behandelaar_prijs_discount', $price->ID),
                            'doller_behandelaar_prijs_discount_striketrough' => \get_field('doller_behandelaar_prijs_discount_striketrough', $price->ID),
                            'show_doller_price_clinic_deal' => \get_field('show_doller_price_clinic_deal', $price->ID),
                        ],
                    ];
                }
            }


            foreach($fetchTreatment['body_list_of_treatments'] as $treatMent){
                $treatmentPriceInformation[$treatMent->ID]['treatment_price_image_desktop'] = \get_field('treatment_price_image_desktop', $treatMent->ID); 
                $treatmentPriceInformation[$treatMent->ID]['treatment_title'] = get_the_title($treatMent->ID); 
                $treatmentPriceInformation[$treatMent->ID]['show_treatment_price_clinic_deals'] = \get_field('show_treatment_price_clinic_deals', $treatMent->ID); 
                $treatmentPriceInformation[$treatMent->ID]['show_advance_treatment'] = \get_field('show_advance_treatment', $treatMent->ID); 
                $treatmentPriceInformation[$treatMent->ID]['treatment_price_detail_information'] = \get_field('treatment_price_detail_information', $treatMent->ID); 
                $treatmentPriceInformation[$treatMent->ID]['treatment_overwrite_price_label'] = \get_field('treatment_overwrite_price_label', $treatMent->ID); 
                $treatmentPriceInformation[$treatMent->ID]['treatment_length'] = \get_field('treatment_length', $treatMent->ID); 
                $treatmentPriceInformation[$treatMent->ID]['treatment_control'] = \get_field('treatment_control', $treatMent->ID); 
                $treatmentPriceInformation[$treatMent->ID]['treatment_effect'] = \get_field('treatment_effect', $treatMent->ID); 
                $treatmentPriceInformation[$treatMent->ID]['treatment_detail_page_link'] = get_permalink($treatMent->ID); 
                $treatmentPriceInformation[$treatMent->ID]['treatment_price_list_description'] = \get_field('treatment_price_list_description', $treatMent->ID);
                $treatmentPriceInformation[$treatMent->ID]['treatment_post_id'] = $treatMent->ID;
                $treatmentPriceInformation[$treatMent->ID]['treatment_price_new_layout_information'] = $priceInformation;
                $treatmentPriceInformation[$treatMent->ID]['treatment_cta'] = [
                    'label' => \get_field('treatment_cta_button_label', $treatMent->ID),
                    'url' => \get_field('treatment_cta_button_url', $treatMent->ID),
                    'external' => \get_field('treatment_cta_button_external', $treatMent->ID)
                ];
            }
        }
    
        return $treatmentPriceInformation;
    }

    public function areaMapImageWithTreatments() {

        $currentQueriedObject = get_queried_object();

        $currentLanguage = pll_current_language();

        $appointmentButtonURL = \get_field($currentLanguage."_book_consulation_url","option");
        $appointmentButtonLabel = \get_field($currentLanguage."_book_consulation_lable","option");
        $appointmentButtonExternal = \get_field($currentLanguage."_book_consulation_external","option");

        if( ! $this->_area_map_image_treatments ) {
            $this->_area_map_image_treatments = [
                'current_price_type_name' => strtolower($currentQueriedObject->name),
                'face_image' => wp_get_attachment_url($this->get_field('price_face_image', $this->acf_id())),
                'body_image' => wp_get_attachment_url($this->get_field('price_body_image', $this->acf_id())),
                'face_list_treatments' => \get_field('face_treatments_list', $currentQueriedObject->taxonomy . '_' . $currentQueriedObject->term_id), 
                'body_list_treatments' => \get_field('body_treatments_list', $currentQueriedObject->taxonomy . '_' . $currentQueriedObject->term_id),
                'price_page_label' =>  \get_field('price_page_treatment_label', $currentQueriedObject->taxonomy . '_' . $currentQueriedObject->term_id),
                'face_clinic_deals_toggle' =>  \get_field('face_clinic_deals_toggle', $currentQueriedObject->taxonomy . '_' . $currentQueriedObject->term_id),
                'face_clinic_deal_image' =>  \get_field('face_clinic_deal_image', $currentQueriedObject->taxonomy . '_' . $currentQueriedObject->term_id),
                'face_clinic_deal_image_mobile' =>  \get_field('face_clinic_deal_image_mobile', $currentQueriedObject->taxonomy . '_' . $currentQueriedObject->term_id),
                'face_clinic_deal_label' =>  \get_field('face_clinic_deal_label', $currentQueriedObject->taxonomy . '_' . $currentQueriedObject->term_id),
                'face_clinic_deal_description' =>  \get_field('face_clinic_deal_description', $currentQueriedObject->taxonomy . '_' . $currentQueriedObject->term_id),
                'body_clinic_deals_toggle' =>  \get_field('body_clinic_deals_toggle', $currentQueriedObject->taxonomy . '_' . $currentQueriedObject->term_id),
                'body_clinic_deal_image' =>  \get_field('body_clinic_deal_image', $currentQueriedObject->taxonomy . '_' . $currentQueriedObject->term_id),
                'body_treatment_label' =>  \get_field('body_treatment_label', $currentQueriedObject->taxonomy . '_' . $currentQueriedObject->term_id),
                'body_clinic_deal_description' =>  \get_field('body_clinic_deal_description', $currentQueriedObject->taxonomy . '_' . $currentQueriedObject->term_id),
                'face_show_combination' => \get_field('face_show_combination', $currentQueriedObject->taxonomy . '_' . $currentQueriedObject->term_id), 
                'combination_section_label' => \get_field('combination_section_label', $currentQueriedObject->taxonomy . '_' . $currentQueriedObject->term_id),
                'combination_section_description' => \get_field('combination_section_description', $currentQueriedObject->taxonomy . '_' . $currentQueriedObject->term_id),
                'combination_information' => \get_field('combination_information', $currentQueriedObject->taxonomy . '_' . $currentQueriedObject->term_id),
                'show_treatments_with_prices' => static::treatmentsWithPriceList(),
                'show_body_treatments_with_prices' => static::bodyTreatmentsWithPriceList(),
                'price_page_advance_label_text' => \get_field('price_page_advance_label_text', $currentQueriedObject->taxonomy . '_' . $currentQueriedObject->term_id),
                'price_page_view_treatment_label_text' => \get_field('price_page_view_treatment_label_text', $currentQueriedObject->taxonomy . '_' . $currentQueriedObject->term_id),
                'price_page_faq_section_title_heading' => \get_field('faq_section_tag_heading', $currentQueriedObject->taxonomy . '_' . $currentQueriedObject->term_id),
                'price_page_faq_section_title' => \get_field('faq_section_title', $currentQueriedObject->taxonomy . '_' . $currentQueriedObject->term_id),
                'price_page_faq_section_list' => \get_field('price_faq_list', $currentQueriedObject->taxonomy . '_' . $currentQueriedObject->term_id),
                'book_appointment' => [
                    'url' => $appointmentButtonURL,
                    'label' => $appointmentButtonLabel,
                    'external' => $appointmentButtonExternal
                ],
                'show_currency' => \get_field('price_show_currency_symbol', $currentQueriedObject->taxonomy . '_' . $currentQueriedObject->term_id),
                'you_saved_text' => \get_field('price_page_you_save_text', $currentQueriedObject->taxonomy . '_' . $currentQueriedObject->term_id)
            ];
        }

        return $this->_area_map_image_treatments;
    }
}
