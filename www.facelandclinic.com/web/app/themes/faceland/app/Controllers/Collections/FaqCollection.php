<?php

// Set the namespace
namespace Rokit\Controllers\Collections;

use Rokit\Controllers\Terms\FaqTaxonomyTerm;

class FaqCollection extends PostCollection {

    protected static $postType = 'faq';

    protected static $postClass = 'Rokit\Controllers\Types\Faq';

    var $_contact;

    var $_panorama_image;

    var $_navigation;

    var $_faq_information;

    var $_topics;

    var $_navigationImage;

    public function contact() {
        if( ! $this->_contact ) {
            $this->_contact = [
                'short' => get_field( static::$postType .'_archive_connect_short_title', 'option' ),
                'long'  => get_field( static::$postType .'_archive_connect_long_title', 'option'  ),
                'description'  => get_field( static::$postType .'_archive_connect_description', 'option'  ),
                'icons' => [
                    'phone' =>  get_field( static::$postType .'_phone_icon_image', 'option'  ),  
                    'whatsapp'  => get_field( static::$postType .'_whatsapp_icon_image', 'option'  ),  
                    'email' =>  get_field( static::$postType .'_email_icon_image', 'option'  ),  
                    'chat' =>  get_field( static::$postType .'_chat_icon_image', 'option'  ),  
                ], 
            ];
        }

        return $this->_contact;
    }

    public function panorama_image() {
        if( ! $this->_panorama_image ) {
            $this->_panorama_image = [
                'image' => get_field( static::$postType .'_archive_image', 'option' )
            ];
        }

        return $this->_panorama_image;
    }


    public function navigation() {
        if( ! $this->_navigation ) {
            $this->_navigation = [
                'navigation_title_heading' => get_field( static::$postType .'_archive_title_navigation_heading', 'option' ),
                'navigation_title' => get_field( static::$postType .'_archive_navigation_title', 'option' )
            ];
        }

        return $this->_navigation;
    }


    public function faq_information() {
        if( ! $this->_faq_information ) {
            $this->_faq_information = [
                'faq_info' => get_field( static::$postType .'_archive_information_details', 'option' )
            ];
        }

        return $this->_faq_information;
    }

    static function get_webshop_taxonomy_id() {
        return 428;
    }

    static function get_webshop_types() {
        return get_terms( 'faq_taxonomy', array( 'parent' => self::get_webshop_taxonomy_id(), 'orderby' => 'slug' ) );
    }

    public static function types() {

        $types = [];
        $terms = get_terms('faq_taxonomy');

        if(!empty($terms) and is_iterable($terms)) {
            foreach($terms as $term) {
                if ($term->parent == 0 && $term->term_id != self::get_webshop_taxonomy_id()){
                    $types[] = new FaqTaxonomyTerm($term->term_id);
                }
            }
        }

        return $types;
    }

    public function faq_topics() {
      
        $topics = [];
        $terms = get_terms('faq_topic');

        if(!empty($terms) and is_iterable($terms)){
            foreach($terms as $term){
                $topics[] = new FaqTaxonomyTerm($term->term_id);
            }
        }

        return $topics;

    } 

     public function faq_topics_by_posts() {
      
        $topicsByPosts = [];
        $terms = get_terms('faq_topic');

        if(!empty($terms) and is_iterable($terms)){
            foreach($terms as $term){
                $args = [
                    'posts_per_page'=> -1,
                    'tax_query' => [
                        [
                            'taxonomy'  => 'faq_topic',
                            'field'     => 'term_id',
                            'terms'     => $term->term_id,
                        ]
                    ],
                    'order'=>'ASC',
                    'orderby' => 'menu_order'
                ];

                $topicsByPosts[$term->name] = FaqCollection::query($args);
            }
        }

        return $topicsByPosts;

    } 

    public function faq_navigation_image() {
      
        $navigationImage = [];

        $terms = get_terms('faq_topic');

        if(!empty($terms) and is_iterable($terms)){
            foreach($terms as $term){
                $navigationImage[$term->term_id] = get_field('topic_navigation_icon', $term->taxonomy.'_'.$term->term_id );
            }
        }

        return $navigationImage;

    } 

}
