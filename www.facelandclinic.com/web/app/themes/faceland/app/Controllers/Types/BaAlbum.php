<?php

// Set the namespace
namespace Rokit\Controllers\Types;

use Rokit\Controllers\Collections\TreatmentCollection;
use Rokit\Controllers\Collections\BaAlbumCollection;
use Rokit\Controllers\Collections\BaCollection;

class BaAlbum extends Post {

    protected static $postType = 'ba_album';

    var $_filter;

    var $_overwrite_items;

    var $_items;

    var $_treatment;

    var $_cta;

    var $_related;

    public function filter(){

        if( ! $this->_filter ) {

            if(!empty($items = $this->overwrite_items())) {
                // Only add tabs if more then one set of items is defined
                if(count($items) > 1) {

                    $filter = [];

                    array_walk($items, function($item, $key) use (&$filter){
                        $filter['options'][] = [
                            'name' => $item['tab'],
                            'link' => add_query_arg('type', sanitize_title($item['tab']) ,$this->link()),
                            'active' => (!empty($_GET['type']) && $_GET['type'] == sanitize_title($item['tab'])) || (empty($_GET['type']) && $key === 0) ? true : false
                        ];
                    });

                    $this->_filter = $filter;

                }

            }
        }

        return $this->_filter;

    }

    public function overwrite_items(){

        if( ! $this->_overwrite_items ) {
            $items = $this->get_field(static::$postType . '_items');
            if(is_array($items)) {
                $this->_overwrite_items = array_map(function($item) {
                    $item['slug'] = sanitize_title($item['tab']);
                    $item['items'] = BaCollection::posts_by_id($item['items']);
                    return $item;
                }, $items);
            }
        }

        return $this->_overwrite_items;

    }

    public function items(){

        if( ! $this->_items ) {

            if(!empty($this->get_field(static::$postType . '_items_overwrite'))) {
                if(!empty($items = $this->overwrite_items())) {

                    $type = !empty($_GET['type']) ? $_GET['type'] : '';
                    $key = array_search($type, array_column($items, 'slug'));
                    $key = !empty($key) ? $key : 0;

                    $this->_items = !empty($items[$key]['items']) ? $items[$key]['items'] : [];

                }
            } else {
                if($items = $this->treatment()->before_after()) {
                    $this->_items = $items;
                }
            }
        }

        return $this->_items;
    }

    public function treatment(){

        if( ! $this->_treatment ) {
            $treatment_id = $this->get_field(static::$postType . '_treatment');

            if(!empty($treatment_id)) {
                $this->_treatment = TreatmentCollection::post($treatment_id);
            }
        }

        return $this->_treatment;
    }

    public function cta(){

        if( ! $this->_cta ) {
            
            // @TODO: Get CTA from ACF settings (overwrite in detail if wanted)
            $cta = $this->get_field(static::$postType . '_cta');

            $this->_cta = $cta;
        }

        return $this->_cta;
    }

    public function related(){

        if( ! $this->_related ) {

            $related_ids = $this->get_field(static::$postType . '_related');

            if(!empty($related_ids)) {

                $albums = BaAlbumCollection::posts_by_id($related_ids);
                $treatments = BaAlbumCollection::treatments_by_albums($albums);

                // @TODO: Get title and button from ACF settings (overwrite in detail if wanted)
                $this->_related = [
                    'title' => pll__('Bekijk alle resultaten'),
                    'posts' => $treatments,
                    'button' => [
                        'label' => pll__('Bekijk resultaten'),
                        'url' => get_post_type_archive_link(static::$postType)
                    ]
                ];
            }
        }

        return $this->_related;
    }

    public function seo_description() {

        if( ! $this->_seo_description ) {
            $description = $this->panorama()['subtitle'] ? $this->panorama()['subtitle'] : $this->cta()['intro'];
            if (!empty($description)){
                $this->_seo_description = strip_tags( rokit_truncate( $description, '156' ) );
            }
        }

        return $this->_seo_description;

    }

}
