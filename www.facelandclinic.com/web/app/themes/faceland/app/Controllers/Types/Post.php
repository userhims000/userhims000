<?php

// Set the namespace
namespace Rokit\Controllers\Types;

use Timber;
use TimberPost;
use Rokit\Frame\Share\RokitShare;
use Rokit\Controllers\Collections\AcademyCollection;

class Post extends TimberPost {

    protected static $postType = 'post';

    var $_panorama;

    var $_defaults;

    var $_content_modules;

    var $_share;

    var $_action_list;
    
    var $_offer_post_type;

    var $_seo_description;

    var $_seo_image;

    var $_search_title;

    var $_search_excerpt;

    var $_search_link;

    public function panorama() {
        global $post;
        if( ! $this->_panorama ) {

            $panorama = [
                'title_heading' => $this->get_field( static::$postType . '_panorama_title_heading'), 
                'title'  => ($post->post_name == 'maak-een-afspraak' && pll_current_language() == 'nl' || $post->post_name == 'maak-een-afspraak' && pll_current_language() == 'be' || $post->post_name == 'planifiez-rendez-vous' && pll_current_language() == 'be-fr' || $post->post_name == 'make-an-appointment-en' && pll_current_language() == 'en' || $post->post_name == 'termin-buchen' && pll_current_language() == 'ch' ) ? $this->get_field( static::$postType . '_appointment_panorama_titles_title') : $this->get_field( static::$postType . '_panorama_titles_title')  ,
                'subtitle'  => $this->get_field( static::$postType . '_panorama_titles_subtitle')
            ];

            $panorama['show']    = $this->get_field( static::$postType . '_panorama_show_image');
            if ($this->get_field( static::$postType . '_panorama_show_image')){
                $panorama['image']    = $this->get_field( static::$postType . '_panorama_image');
            }

            $panorama['show_with_backgroud_colour'] = $this->get_field( static::$postType . '_show_background_colour_layout'); 


            $this->_panorama = $panorama;
        }

        return $this->_panorama;
    }

    protected function defaults($option=null){

        // Grab the defaults for the collection (only once)
        if(!$this->_defaults) {
            $controller = rokit_timber_collection_class($this->post_type);
            $this->_defaults = $controller::single_default();
        }

        // Check if the requested default is defined
        if(!empty($option) && !empty($this->_defaults[$option])) {
            return $this->_defaults[$option];
        }

    }

    protected function compile($content, array $vars = []) {

        if(empty($vars)) {
            $vars = $this->replacable_vars();
        }

        return rokit_compile($content, $vars);

    }

    public function content_modules() {

        if ( ! $this->_content_modules ) {

            if( is_page('facecard-loyalty') || is_page('faceland-in-store') || is_singular('campaign') ){
                $content_modules = $this->get_field('campaign_modules');
            }else{
                $content_modules = $this->get_field('modules');
            }

            // Run content modules over a filter
            if( !empty( $content_modules ) && is_array( $content_modules ) ) {
                foreach( $content_modules as $key => $module ) {
                    $module = apply_filters( "rokit/content_modules/{$module['acf_fc_layout']}", $module );
                    $content_modules[ $key ] = $module;
                }
            }


            $this->_content_modules = $content_modules;
        }

        return $this->_content_modules;
    }

    public function share() {

        if ( ! $this->_share ) {

            $summary_field = rokit_get_post_summary_field( $this->ID );

            $share_class = new RokitShare( $summary_field, $this->ID );

            $this->_share = array(
                'facebook'  => $share_class->get_link( 'facebook' ),
                'twitter'   => $share_class->get_link( 'twitter' ),
                'google'    => $share_class->get_link( 'google' ),
                'pinterest' => $share_class->get_link( 'pinterest' ),
                'linkedin'  => $share_class->get_link( 'linkedin' ),
                'email'     => $share_class->get_link( 'mail' ),
                'whatsapp'  => $share_class->get_link( 'whatsapp' )
            );

        }

        return $this->_share;
    }

    public function action_list(){
        $homepage_id = get_option( 'page_on_front' );

        $action_list = [];
        $academy_items = AcademyCollection::items(['posts_per_page' => 4]);
        $last_minutes_items = self::items(['posts_per_page' => 4]);

        $academy = [
            'title' => get_field('page_actions_academy_title',$homepage_id),
            'subtitle' => get_field('page_actions_academy_subtitle',$homepage_id)
        ];

        $last_minutes = [
            'title' => get_field('page_actions_last_minutes_title',$homepage_id),
            'subtitle' => get_field('page_actions_last_minutes_subtitle',$homepage_id)
        ];

        if (!empty($academy_items)) {
            $academy['items'] = $academy_items;
            $academy['button'] = [
                'url' => AcademyCollection::url(),
                'label' => pll__('Bekijk alle academy dagen')
            ];
        }

        if (!empty($last_minutes_items)) {
            $last_minutes['items'] = $last_minutes_items;
            $last_minutes['button'] = [
                'url' => self::url(),
                'label' => pll__('Bekijk alle last minutes')
            ];
        }

        $show_settings = rokit_get_language_settings()['general'];

        if (pll_current_language('slug') != 'nl') {
            if ($show_settings['last-minute']) {
                $action_list['lists']['last-minute'] = $last_minutes;
            }
        }

        if ($show_settings['academy']) {
            $action_list['lists']['academy'] = $academy;
        }

        $this->_action_list = $action_list;
        
        return $this->_action_list;
    }
    public function offer_post_type(){
        
        $offerPosttype = get_post_type( get_the_ID() );

        $this->_offer_post_type = $offerPosttype;
        
        return $this->_offer_post_type;
    }

    public function seo_description() {

        if( ! $this->_seo_description ) {

            $description_field_key = rokit_get_post_summary_field( $this->ID );
            $description = $this->get_field( $description_field_key, $this->ID );

            if( empty( $description ) ) {
                $content_modules = $this->content_modules();
                $description = rokit_return_first_content_module( $content_modules );
            }

            if( !empty( $description ) ) {
                $this->_seo_description = strip_tags( rokit_truncate( $description, '156' ) );
            }
        }

        return $this->_seo_description;

    }

    public function seo_image() {

        if( ! $this->_seo_image ) {

            if ($this->thumbnail()) {
                $image_id = $this->thumbnail();

            } else if ($this->image()) {
                $image_id = $this->image();

            } else if (isset($this->panorama()['image'])) {
                $image_id = $this->panorama()['image'];

            } else if (isset($this->video()['thumbnail'])) {
                $image_id = $this->video()['thumbnail'];

            }

            if( !empty( $image_id ) ) {
                $image = rokit_get_attachment( $image_id, 'social' );
                if (!empty($image)){
                    $this->_seo_image = $image;
                }
            }

        }

        return $this->_seo_image;

    }

    public function search_title() {
        if(!$this->_search_title) {
            $this->_search_title = $this->title();
        }

        return $this->_search_title;
    }

    public function search_excerpt(string $passed_excerpt=null) {
        if(!$this->_search_excerpt) {

            if(function_exists('rodesk_term_highlight_get_the_excerpt_global')) {
                $excerpt = rodesk_term_highlight_get_the_excerpt_global( $this->ID, null, get_search_query() );
                if(!empty($excerpt)) {
                    $excerpt = sprintf('...%s...', str_replace('[…]', '', $excerpt));
                }
            }

            if(empty($excerpt) && !empty($passed_excerpt)) {
                $excerpt = $passed_excerpt;
            }

            if(empty($excerpt) || str_word_count(strip_tags($excerpt)) <= 5) {
                if(!empty($this->seo_description())) {
                    $excerpt = $this->seo_description();
                }
            }

            if(!empty($excerpt)) {
                $this->_search_excerpt = strip_tags($excerpt, '<mark><strong>');
            }

        }

        return $this->_search_excerpt;
    }

    public function search_link() {

        if(!$this->_search_link) {
            $this->_search_link = $this->link();
        }

        return $this->_search_link;
    }


}
