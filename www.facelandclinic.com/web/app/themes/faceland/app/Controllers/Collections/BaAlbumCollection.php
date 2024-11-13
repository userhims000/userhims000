<?php

// Set the namespace
namespace Rokit\Controllers\Collections;

use Rokit\Controllers\Terms\BaAlbumTaxonomyTerm;

class BaAlbumCollection extends PostCollection {

    protected static $postType = 'ba_album';

    protected static $postClass = 'Rokit\Controllers\Types\BaAlbum';

    protected static $termClass = 'Rokit\Controllers\Terms\BaAlbumTaxonomyTerm';

    var $_cta;

    public function cta() {
        if( ! $this->_cta ) {
            // @TODO: Add overwrite in taxonomy if wanted
            $this->_cta =  get_field( static::$postType . '_archive_cta', 'option');
        }

        return $this->_cta;

    }

    public static function treatments_by_albums(array $albums) {

        $treatments = [];

        foreach($albums as $album) {

            $treatment = $album->treatment();
            if(!empty($treatment)) {
                $treatment->link = $album->link();
                $treatments[] = $treatment;
            }

        }

        return $treatments;

    }

    public static function types() {

        $types = [];
        $terms = get_terms(static::$postType . '_taxonomy', ['parent' => 0]);

        if(!empty($terms) and is_iterable($terms)) {
            foreach($terms as $term) {
                $types[] = new static::$termClass($term->term_id);
            }
        }

        return $types;

    }

    public static function filter() {
        return ['options' => static::types()];
    }
}
