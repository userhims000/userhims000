<?php

namespace Rokit\Controllers\Terms;

use TimberTerm;
use Timber;

class Term extends TimberTerm {

    public $TermClass = 'Rokit\Controllers\Terms\Term';

    var $_seo_image;

    var $_seo_description;

    var $_content_modules;

    /**
     * Import init function from Timber/Term
     * We don't want the meta data included in the Term info
     * We will include this ourselves
     *
     * @param int $tid
     * @return void
     */
    protected function init( $tid ) {

        $term = $this->get_term($tid);

        if ( isset($term->id) ) {
			$term->ID = $term->id;
		} else if ( isset($term->term_id) ) {
			$term->ID = $term->term_id;
		}

		if ( isset($term->ID) ) {
			$term->id = $term->ID;
			$this->import($term);
		}
	}

    public function posts($numberposts_or_args = '-1', $post_type_or_class = 'any', $post_class=null) {

        if(empty($post_class)) {
            $post_class = rokit_timber_type_class($this->post_type);
        }

        return $this->get_posts($numberposts_or_args, $post_type_or_class, $post_class);
    }

    /**
     * Setup a custom query for posts from this custom post type
     *
     * This function takes a standard set of WP_Query arguments but mixes it with
     * arguments that mean we're selecting the right post type
     *
     * @param  array    $args       Array of default WP_Query arguments
     * @param  string   $postClass  Sting with the name of the postclass to be used
     * @return object               Timber object with requested posts
     */

    public function query( $args = null, $postClass = null ) {

        $args = is_array($args) ? $args : [];

        // Set the correct post type
        $args = array_merge($args, ['post_type' => $this->post_type]);

        if (!isset($args['post_status'])) {
            $args['post_status'] = 'publish';
        }

        if (!isset($args['posts_per_page'])) {
            $args['posts_per_page'] = '-1';
        }

        if( empty( $postClass ) ) {
            $postClass = rokit_timber_type_class($this->post_type);
        }

        $args['tax_query'] = [
            [
                'taxonomy' => $this->taxonomy,
                'field' => 'term_id',
                'terms' => $this->term_id
            ]
        ];

        return Timber::get_posts( $args, $postClass);
    }
    public function get_children() {
		if ( !isset($this->_children) ) {
			$children = get_term_children($this->ID, $this->taxonomy);
			foreach ( $children as &$child ) {
                $child = new $this->TermClass($child);
			}
			$this->_children = $children;
		}
		return $this->_children;
	}

    public function acf_id() {
        return $this->taxonomy . '_' . $this->term_id;
    }

    public function collection() {
        $controller = rokit_timber_collection_class();
        return new $controller();
    }

    public function post_type() {
        if(!empty($type = $this->collection()->type())) {
            return $type;
        }
    }

    public function active() {
        if($this->term_id() == $this->get_term_from_query()) {
            return true;
        }

        return false;
    }

    public function lang_id() {
        return pll_get_term($this->id,  pll_default_language());
    }

    protected function compile($content, array $vars = []) {

        if(empty($content)) {
            return;
        }

        if(empty($vars)) {
            $vars = $this->replacable_vars();
        }

        if(is_iterable($content)) {
            return array_map(function($content) use ($vars) {
                return Timber::compile_string($content, $vars);
            }, $content);
        } else {
            return Timber::compile_string($content, $vars);
        }
    }

    public function seo_image() {


        if(!empty($item = self::posts()[0])) {

            if ($item->thumbnail()) {
                $image_id = $item->thumbnail();

            } else if ($item->image()) {
                $image_id = $item->image();

            } else if (isset($item->panorama()['image'])) {
                $image_id = $item->panorama()['image'];

            }

            if (!empty($image = rokit_get_attachment($image_id, 'social'))) {

                $this->_seo_image = $image;
            }
        }
        return $this->_seo_image;

    }

    public function seo_description() {

        if( ! $this->_seo_description ) {
            if ($this->description()){
                $description = $this->description();
            } else if ($this->intro()){
                $description = $this->intro();
            }
            $this->_seo_description = $description;
        }

        return $this->_seo_description;

    }

    public function content_modules() {

        if ( ! $this->_content_modules ) {

            $content_modules = [];
            while ( have_rows('modules', $this->acf_id()) ) : the_row();
                $row = get_row();
                $row_data = array();
                foreach ($row as $field_key => $field_value) {
                    $field_object = get_field_object($field_key);
                    $field_name = $field_object['name'] ? $field_object['name'] : 'acf_fc_layout';
                    $row_data[$field_name] = $field_value;
                }

                // Add the row data to the flexible content array
                $content_modules[] = $row_data;

            endwhile;

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

}
