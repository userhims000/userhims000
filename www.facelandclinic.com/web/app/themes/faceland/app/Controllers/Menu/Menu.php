<?php

namespace Rokit\Controllers\Menu;

use TimberMenu;

class Menu extends TimberMenu {

    /* Use a custom menu item controller */
    public $MenuItemClass = 'Rokit\Controllers\Menu\MenuItem';

    /* Use a custom menu item controller */
    public $MenuPostType = '';

    /**
     * Construct the custom Menu class
     *
     * @param string    $slug   Slug/ID of the menu to use (or post type if $type is 'post_type')
     * @param mixed     $type   Can be false or 'post_type'
     */
    public function __construct( $slug, $type = false ) {

        if( !empty( $type ) && post_type_exists( $slug ) ) {

            $this->MenuPostType = $slug;

            if( $type == 'post_type' ) {
                $this->init_pt_menu( $slug );
            }

        } else {

            // Construct the parent function
            parent::__construct( $slug );

        }

    }

    /**
     * Init a post type based TimberMenu
     *
     * @param  string   $post_type  String with the name of the post type
     */
    protected function init_pt_menu( $post_type ) {

        // @TODO Add method for taxonomy

        if( function_exists( 'rokit_timber_collection_class' ) ) {

            $controller = rokit_timber_collection_class( $post_type, true );
            $menu       = $controller::all();

            if ( !empty( $menu ) && is_array( $menu ) ) {

                _wp_menu_item_classes_by_context($menu);

                if ( is_array($menu) ) {

                    $menu = $this->add_children($menu);
                    $menu = $this->prepare_posttype_items_for_menu($menu);
                    $menu = self::order_children($menu);
                }

                $this->items = $menu;

            }

        } else {
            throw new Exception('Cannot find timber class.');
        }

    }

    /**
     * Add children menu items for use in a TimberMenu
     *
     * @param  array    $items  Array of post objects
     * @return array            Array of post objects prepared for use with TimberMenu
     */

    function add_children( $items ) {

        $child_items = array();

        // Loop all menu items
        foreach ( $items as $item ) {

            // Check if this menu item has children
            $children = $item->children;

            // Check if children are defined for this menu item
            if ( !empty( $children ) && is_array( $children ) ) {

                // Loop child items for this menu item
                foreach ( $children as $child ) {
                    $child_items[] = $child;
                }

            }
        }

        $new_items = array_merge( $items, $child_items );

        return $new_items;
    }

    /**
     * Prepare an array of post typ items for use in a TimberMenu
     *
     * @param  array    $items  Array of post objects
     * @return array            Array of post objects prepared for use with TimberMenu
     */
    protected function prepare_posttype_items_for_menu( $items ) {

        foreach ( $items as $item ) {

            // Set the title of the menu item
            $item->title = $item->post_title;


            $item->menu_item_parent = $item->post_parent;

            // Set the current state of the menu item
            if( $item->ID == get_the_id() ) {
                $item->current = true;
            }

            // Add the correct WP classes
            $classes = array();
            $classes[] = 'menu-item';
            $classes[] = 'menu-item-type-post-type';
            $classes[] = 'menu-item-object-' . $item->post_type;
            $item->classes = $classes;

        }

        return $items;
    }

    /**
     * Get the archive details of a certain post type
     *
     * @return boolean  True fo False depending if the menu has active childrem
     */
    public function get_archive() {

        if( !empty( $this->MenuPostType ) ) {

            // Setup archive details array
            $archive_details = array();

            // Get post type object details
            $post_type = $this->MenuPostType;
            $post_type_obect = get_post_type_object ( $post_type );
            $post_type_labels = get_post_type_labels( $post_type_obect );

            // Add details to archive details
            $archive_details['link'] = get_post_type_archive_link( $this->MenuPostType );
            $archive_details['title'] = $post_type_labels->name;

            return $archive_details;

        }

        return false;

    }

    /**
     * Check if menu had active children
     *
     * @return boolean  True fo False depending if the menu has active childrem
     */
    public function has_active() {

        $items = $this->get_items;

        if( !empty( $items ) && is_array( $items ) ) {

            // Loop all children of this menu
            foreach( $this->get_items as $item ) {

                // Get the children for this item
                $children = $item->get_children;

                // Check if this menu item is current
                if( !empty( $item->current ) ) {
                    return true;
                }

                // Check if one of the child menu items is current
                if( !empty( $children ) && is_array( $children ) ) {

                    foreach( $item->get_children as $child ) {

                        // Check if this menu item is current
                        if( !empty( $child->current ) ) {
                            return true;
                        }

                    }
                }

            }

        }

        return false;

    }

}
