<?php

namespace Rokit\Controllers\Menu;

use TimberMenuItem;

class MenuItem extends TimberMenuItem {

    public $PostClass = 'RodeskWP\Controllers\Types\Post';

    public function __construct($data) {

        // Constrcut the parent class
        parent::__construct($data);

        // Add a active class if the item is the current page
        if ($data->current) {
            $this->add_class( 'is-active' );
        }
    }
}
