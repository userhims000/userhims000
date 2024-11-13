<?php

// Set the namespace
namespace Rokit\Controllers\Terms;

use Rokit\Controllers\Collections\BaAlbumCollection;

class BaAlbumTaxonomyTerm extends Term {

    public $TermClass = 'Rokit\Controllers\Terms\BaAlbumTaxonomyTerm';

    public function treatments() {

        $albums = $this->query([
            'orderby' => 'menu_order',
            'order' => 'ASC',
        ]);
        return BaAlbumCollection::treatments_by_albums($albums);

    }

}
