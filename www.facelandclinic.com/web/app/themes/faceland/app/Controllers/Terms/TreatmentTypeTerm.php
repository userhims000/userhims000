<?php

// Set the namespace
namespace Rokit\Controllers\Terms;

use Rokit\Controllers\Collections\TreatmentCollection;

class TreatmentTypeTerm extends Term {

    public $TermClass = 'Rokit\Controllers\Taxonomies\TreatmentTypeTerm';

    var $_treatments_title;

    var $_intro;

    var $_intro_short;

    var $_image;

    var $_featured_treatments;

    var $_cta;

    var $_color;

    var $_why;

    var $_bottom;

    var $_items;

    var $_bodyparts;

    var $_showNavigationForVideoSlider;

    public function intro() {

        if( ! $this->_intro ) {
            $this->_intro = $this->get_field('treatment_taxonomy_intro', $this->acf_id());
        }

        return $this->_intro;
    }

    public function image() {

        if( ! $this->_image ) {
            $this->_image = $this->get_field('treatment_taxonomy_image', $this->acf_id());
        }

        return $this->_image;
    }

    public function treatments_title() {

        if( ! $this->_treatments_title ) {
            $this->_treatments_title = $this->get_field('treatment_taxonomy_treatments_title', $this->acf_id());
        }

        return $this->_treatments_title;
    }

    public function intro_short() {

        if( ! $this->_intro_short ) {
            $this->_intro_short = $this->get_field('treatment_taxonomy_short_intro', $this->acf_id());
        }

        return $this->_intro_short;
    }

    public function featured_treatments() {

        if( ! $this->_featured_treatments ) {

            $treatments = $this->get_field('treatment_taxonomy_relation', $this->acf_id());

            if(!empty($treatments)) {
                $this->_featured_treatments = TreatmentCollection::posts_by_id($treatments);
            }
        }

        return $this->_featured_treatments;
    }

    public function cta() {

        if( ! $this->_cta ) {

            if(!empty($cta_one = get_field('treatment_taxonomy_cta_one', $this->acf_id()))){
                $this->_cta[] = $cta_one;
            }

            if(!empty($cta_two = get_field('treatment_taxonomy_cta_two', $this->acf_id()))){
                $this->_cta[] = $cta_two;
            }

        }

        return $this->_cta;
    }

    public function color() {
        if( ! $this->_color ) {
            $this->_color = get_field('treatment_taxonomy_color', $this->acf_id());
        }

        return $this->_color;
    }

    public function why() {

        if( ! $this->_why ) {
            $this->_why = [
                'title' => get_field('treatment_taxonomy_why_title',  $this->acf_id()),
                'blocks' => get_field('treatment_taxonomy_why_blocks',  $this->acf_id()),
                'show' => get_field('treatment_taxonomy_show_content',  $this->acf_id()),
                'content' => get_field('treatment_taxonomy_additional_faceland_content',  $this->acf_id())
            ];
        }

        return $this->_why;

    }

    public function videos() {
        if( ! $this->_videos ) {

            $videos_data = get_field('video_section_content',  $this->acf_id());
            if( !empty( $videos_data ) && is_array($videos_data) ) {
                foreach( $videos_data as $key => $vdata ) {
                    $this->_videos[$key] = $vdata;
                }
            }
        }

        return $this->_videos;
    }

    public function showNavigationForVideoSlider() {
        if( ! $this->_showNavigationForVideoSlider ) {
            $this->_showNavigationForVideoSlider = get_field('show_dots_or_anchor_navigation',  $this->acf_id());
        }

        return $this->_showNavigationForVideoSlider;
    }

    public function gonavigation() {

        if( ! $this->_gonavigation ) {

            $quick_navigation_data = get_field('navigation_details',  $this->acf_id());
            $this->_gonavigation = [
                'title' => get_field('navigation_title', $this->acf_id()),
                'data'  => $quick_navigation_data
            ];
        }
        return $this->_gonavigation;

    }

    public function deals() {

        if( ! $this->_deals ) {

            $deals_data = get_field('deals_images',  $this->acf_id());
            $this->_deals = [
                'title'                  => get_field('deals_title', $this->acf_id()),
                'intro'                  => get_field('deals_description', $this->acf_id()), 
                'show_deals_button'      => get_field('show_deals_button', $this->acf_id()),
                'deals_button_label'     => get_field('deal_button_label', $this->acf_id()),
                'deals_button_link'      => get_field('deal_button_link', $this->acf_id()),
                'deals_button_external'  => get_field('deals_external', $this->acf_id()),
                'show_carousel'          => get_field('show_carousel', $this->acf_id()),
                'deal_tag'               => get_field('deal_title_tag', $this->acf_id()),
                'data'                   => $deals_data
            ];
        }

        return $this->_deals;

    }

    public function catcarousels() {

        if( ! $this->_catcarousels ) {

            $carousel_data = get_field('category_images',  $this->acf_id());
            $this->_catcarousels = [
                'title'       => get_field('category_carousel_title', $this->acf_id()),
                'description' => get_field('category_carousel_description', $this->acf_id()),
                'data'        => $carousel_data
            ];
        }
        return $this->_catcarousels;
    }

    public function reviews() {

        if( ! $this->_reviews ) {

            $review_data = get_field('review_details',  $this->acf_id());
            $this->_reviews = [
                'title' => get_field('review_title', $this->acf_id()),
                'review_tag' => get_field('review_title_tag', $this->acf_id()),
                'data'  => $review_data
            ];
        }

        return $this->_reviews;

    }

    public function news() {
        if( ! $this->_news ) {

            $news_data = get_field('news_list',  $this->acf_id());
            $this->_news = [
                'title' => get_field('news_main_title', $this->acf_id()),
                'news_tag' => get_field('news_title_tag', $this->acf_id()),
                'intro' => get_field('news_main_description', $this->acf_id()),
                'show_desktop' => get_field('show_news_desktop', $this->acf_id()),
                'show_mobile' => get_field('show_news_mobile', $this->acf_id()),
                'data'  => $news_data
            ];
        }

        return $this->_news;
    }

    public function bottom() {

        if( ! $this->_bottom ) {
            $this->_bottom = [
                'title' => get_field('treatment_taxonomy_bottom_title', $this->acf_id()),
                'intro' => get_field('treatment_taxonomy_bottom_intro', $this->acf_id())
            ];
        }

        return $this->_bottom;
    }

    public function items() {

        if( ! $this->_items ) {
            $args = [
                'orderby'           => 'menu_order',
                'order'             => 'ASC'
            ];

            $this->_items = self::query($args);
        }

        return $this->_items;
    }

    public function filterdetails() {

        if( ! $this->_filterdetails ) {

            $this->_filterdetails = [
                'title'      => get_field('filter_title', $this->acf_id()),
                'intro'      => get_field('filter_description', $this->acf_id()),
                'filter_tag' => get_field('filter_title_tag', $this->acf_id()),
                'filter_bodyparts' => $this->taxonomyBodyParts(get_field('filter_body_types', $this->acf_id()))
            ];
        }

        return $this->_filterdetails;

    }

    public function bodyparts() {

        if(!$this->_bodyparts) {

            $bodyparts = [];
            $treatments = self::posts();

            array_walk($treatments, function($treatment) use (&$bodyparts) {
                $treatment_bodyparts = $treatment->bodyparts();
                if(is_array($treatment_bodyparts)) {
                    $bodyparts = array_merge($treatment_bodyparts,$bodyparts);
                }
            });

            $bodyparts = rokit_array_unique($bodyparts);
            usort($bodyparts, function($a, $b){return strcmp($a->term_order, $b->term_order);});

            $this->_bodyparts = $bodyparts;

        }

        return $this->_bodyparts;

    }

    public function taxonomyBodyParts($bodyparts){

        $types = [];
        $terms = $bodyparts;

        if(!empty($terms) and is_iterable($terms)) {
            foreach($terms as $term) {
                $types[] = new TreatmentBodypartTerm($term);
            }
        }

        return $types;

    }

    public function fallback() {

        if(!$this->_fallback) {

            if(empty($fallback_text = get_field('treatment_fallback_text', $this->acf_id()))) {
                $fallback_text = sprintf(pll__('Er zijn op dit moment geen behandelingen voor %s.'), strtolower($this->title()));
            }

            $this->_fallback = [
                'text' => $fallback_text,
                'button' => [
                    'label' => pll__('Bekijk alle behandelingen'),
                    'url' => TreatmentCollection::url()
                ]
            ];
        }

        return $this->_fallback;
    }

}
