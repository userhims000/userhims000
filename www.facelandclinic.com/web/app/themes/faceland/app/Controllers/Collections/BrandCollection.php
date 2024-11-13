<?php

// Set the namespace
namespace Rokit\Controllers\Collections;

// Include Timber objects
use Timber;
use TimberPost;

class BrandCollection extends PostCollection {

    protected static $postType = 'brand';

    protected static $postClass = 'Rokit\Controllers\Types\Brand';

}
